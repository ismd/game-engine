package game.server.controllers;

import game.character.Character;
import game.server.controllers.common.AbstractController;
import game.server.Response;
import game.World;
import game.dao.DaoFactory;
import game.server.Request;
import game.user.User;
import java.math.BigInteger;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.util.Map;
import org.java_websocket.WebSocket;

/**
 * @author ismd
 */
public class UserController extends AbstractController {

    public Response loginAction(Request request) {
        try {
            Map<String, Object> args = request.getArgs();

            // Метод возвращает null, если пользователь не найден. Исключение всё равно случится.
            User user = DaoFactory.getInstance().getUserDao().getByLoginAndPassword(
                (String)args.get("username"),
                (String)args.get("password"));

            World.users.put(request.getWs(), user);

            // Генерируем authKey
            MessageDigest md = MessageDigest.getInstance("MD5");
            md.update(String.valueOf(System.currentTimeMillis()).getBytes());
            String key = String.format("%032x", new BigInteger(1, md.digest()));

            DaoFactory.getInstance().getUserDao().update(user.setAuthKey(key));

            return new Response(true, true, "login-success").appendData("user", user);
        } catch (Exception e) {
            return new Response(false, "Неверный логин или пароль");
        }
    }

    public Response logoutAction(Request request) {
        WebSocket ws = request.getWs();
        Character character = World.users.get(ws).getCurrentCharacter();

        character.getCell().removeContent(character);
        World.users.remove(ws);

        return new Response(true, true, "logout-success");
    }

    public Response listCharactersAction(Request request) {
        return new Response(true).appendData("characters", World.users.get(request.getWs()).getCharacters());
    }

    public Response registerAction(Request request) throws NoSuchAlgorithmException {
        Map args = request.getArgs();

        if (null == args.get("login")) {
            return new Response(false, "Необходимо указать логин");
        }

        if (!args.get("password").equals(args.get("password1"))) {
            return new Response(false, "Пароли не совпадают");
        }

        if (null == args.get("email")) {
            return new Response(false, "Необходимо указать e-mail");
        }

        MessageDigest md = MessageDigest.getInstance("MD5");
        md.update(((String)args.get("password")).getBytes());
        String password = String.format("%032x", new BigInteger(1, md.digest()));

        User user = new User().
            setLogin((String)args.get("login")).
            setPassword(password).
            setEmail((String)args.get("email")).
            setInfo((String)args.get("info")).
            setSite((String)args.get("site"));

        DaoFactory.getInstance().getUserDao().addUser(user);
        return new Response(true).appendData("user", user);
    }

    public Response loginByAuthKeyAction(Request request) {
        Map<String, Object> args = request.getArgs();

        int id = (int)(double)args.get("id");
        String authKey = (String)args.get("authKey");

        for (Map.Entry<WebSocket, User> entry : World.users.entrySet()) {
            User user = entry.getValue();

            if (id == user.getId() && authKey.equals(user.getAuthKey())) {
                World.users.put(request.getWs(), user);
                World.users.remove(entry.getKey());

                return new Response(true, true, "init").
                    appendData("user", user).
                    appendData("character", user.getCurrentCharacter());
            }
        }

        return new Response(false);
    }
}
