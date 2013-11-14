package game.server.controllers;

import game.Character;
import game.server.controllers.common.AbstractController;
import game.server.Response;
import game.User;
import game.World;
import game.dao.DaoFactory;
import game.server.Request;
import game.world.exceptions.BadCoordinatesException;
import java.util.Map;
import java.util.logging.Level;
import java.util.logging.Logger;
import org.java_websocket.WebSocket;

/**
 * @author ismd
 */
public class UserController extends AbstractController {

    public Response login(Request request) {
        try {
            Map<String, Object> args = request.getArgs();

            // Метод возвращает null, если пользователь не найден. Исключение всё равно случится.
            User user = new User(DaoFactory.getInstance().getUserDao().getByLoginAndPassword(
                (String)args.get("username"),
                (String)args.get("password")));

            World.users.put(request.getWs(), user);
            return new Response(true);
        } catch (Exception e) {
            return new Response(false, "Неверный логин или пароль");
        }
    }

    public Response logout(Request request) {
        WebSocket ws = request.getWs();
        game.character.Character character = World.users.get(ws).getCurrentCharacter();

        character.getCell().removeContent(character);
        World.users.remove(ws);

        return new Response(true);
    }

    public Response setCharacter(Request request) {
        Map<String, Object> args = request.getArgs();

        Double id = (Double)args.get("id");
        String key = (String)args.get("key");

        try {
            Character character = new Character(DaoFactory.getInstance().getCharacterDao().getById(id.intValue()));
            character.setCell(world.getLayout(character.getIdLayout()).getCell(character.getX(), character.getY()));
            World.users.get(request.getWs()).setCurrentCharacter(character);

            return new Response(true).appendData("character", character);
        } catch (BadCoordinatesException ex) {
            Logger.getLogger(UserController.class.getName()).log(Level.SEVERE, null, ex);
        }

        return new Response(false);
    }

    public Response listCharacters(Request request) {
        return new Response(true).appendData("characters", World.users.get(request.getWs()).getCharacters());
    }

    public Response register(Request request) {
        Map args = request.getArgs();
        
        if (!args.get("password").equals(args.get("password1"))) {
            return new Response(false, "Пароли не совпадают");
        }

        User user = new User();

        user.setLogin((String)args.get("login"));
        user.setPassword((String)args.get("password"));
        user.setEmail((String)args.get("email"));
        user.setInfo((String)args.get("info"));
        user.setSite((String)args.get("site"));

        return new Response(true);
    }
}
