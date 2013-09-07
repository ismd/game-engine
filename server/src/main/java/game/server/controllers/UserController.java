package game.server.controllers;

import game.character.Character;
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

            User user = (User)DaoFactory.getInstance().getUserDao().getByLoginAndPassword(
                (String)args.get("username"),
                (String)args.get("password"));

            World.users.put(request.getWs(), user);
        } catch (Exception e) {
            return new Response(false, "Неверный логин или пароль");
        }

        return new Response(false, "Ошибка");

        /*try {
            for (Map.Entry<WebSocket, game.character.Character> entry : characters.entrySet()) {
                if (character.getIdUser() == entry.getValue().getIdUser()) {
                    removeCharacter(entry.getKey());
                }
            }

            characters.put(request.getWs(), character);

            return new Response(true).appendData("character", character);
        } catch (BadAuthKeyException e) {
            return new Response(false, "Ошибка при проверке пользователя", true, "logout-success");
        } catch (Exception e) {
            return new Response(false, "Ошибка");
        }*/
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
            Character character = DaoFactory.getInstance().getCharacterDao().getById(id.intValue());
            character.setCell(world.getLayout(character.getIdLayout()).getCell(character.getX(), character.getY()));
            World.users.get(request.getWs()).setCurrentCharacter(character);

            return new Response(true).appendData("character", character);
        } catch (BadCoordinatesException ex) {
            Logger.getLogger(UserController.class.getName()).log(Level.SEVERE, null, ex);
        }

        return new Response(false);
    }

    public Response listCharacters(User user, Map<String, Double> args) {
        return new Response(true).appendData("characters", user.getCharacters());
    }
}