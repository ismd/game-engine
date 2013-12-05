package game.server.controllers;

import game.Online;
import game.character.Character;
import game.dao.DaoFactory;
import game.layout.Cell;
import game.server.controllers.common.AbstractController;
import game.server.request.Request;
import game.server.response.Response;
import game.user.User;
import game.util.Md5;
import game.world.exceptions.BadCoordinatesException;
import java.io.UnsupportedEncodingException;
import java.security.NoSuchAlgorithmException;
import java.util.Map;
import java.util.logging.Level;
import java.util.logging.Logger;

/**
 * @author ismd
 */
public class UserController extends AbstractController {

    public Response loginAction(Request request, User user) throws NoSuchAlgorithmException, UnsupportedEncodingException {
        Map<String, Object> args = request.getArgs();

        User u = DaoFactory.getInstance().userDao.getByLoginAndPassword(
                (String)args.get("username"),
                (String)args.get("password")
        );

        if (null == u) {
            return new Response(false, "Неверный логин или пароль");
        }

        Online.removeUserById(u.getId());

        u.setWebSocket(request.getWs());
        Online.addUser(u);

        // Генерируем authKey
        DaoFactory.getInstance().userDao
                .update(u.setAuthKey(Md5.get(System.currentTimeMillis())));

        return new Response(true, true, "login-success").appendData("user", u);
    }

    public Response logoutAction(Request request, User user) {
        Online.removeUser(user);
        return new Response(true, true, "logout-success");
    }

    public Response listCharactersAction(Request request, User user) {
        return new Response(true)
                .appendData("characters", user.getCharacters());
    }

    public Response registerAction(Request request, User user) {
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

        User u = new User()
                .setLogin((String)args.get("login"))
                .setPassword(Md5.get(args.get("password")))
                .setEmail((String)args.get("email"))
                .setInfo((String)args.get("info"))
                .setSite((String)args.get("site"));

        DaoFactory.getInstance().userDao.add(u);
        return new Response(true).appendData("user", u);
    }

    public Response loginByAuthKeyAction(Request request, User user) {
        Map<String, Object> args = request.getArgs();
        int id = (int)(double)args.get("id");

        User u = DaoFactory.getInstance().userDao.getByIdAndAuthKey(
                id,
                (String)args.get("authKey")
        );

        if (null == u) {
            return new Response(false);
        }

        Online.removeUserById(id);

        u.setWebSocket(request.getWs());
        Online.addUser(u);

        // Генерируем authKey
        DaoFactory.getInstance().userDao
                .update(u.setAuthKey(Md5.get(System.currentTimeMillis())));

        // Устанавливаем персонажа
        Character c = null;

        try {
            int idCharacter = (int)(double)args.get("idCharacter");
            
            for (Character ch : u.getCharacters()) {
                Cell cell = ch.getCell();

                if (null != cell) {
                    Online.removeCharacter(ch);
                }

                if (idCharacter == ch.getId()) {
                    try {
                        cell = Online.world.getLayout(ch.getIdLayout()).getCell(ch.getX(), ch.getY());
                        ch.setCell(cell.addContent(ch));

                        Online.addCharacter(ch);
                    } catch (BadCoordinatesException e) {
                        Logger.getLogger(CharacterController.class.getName()).log(Level.SEVERE, null, e);
                    }

                    u.setCurrentCharacter(ch);
                    c = ch;
                }
            }

            return new Response(true, true, "init")
                    .appendData("user", u)
                    .appendData("character", c);
        } catch (NullPointerException e) {
            return new Response(false);
        }
    }
}
