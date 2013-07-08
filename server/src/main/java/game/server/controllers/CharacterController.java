package game.server.controllers;

import game.character.UserCharacter;
import game.mappers.CharacterMapper;
import game.mappers.UserMapper;
import game.server.Response;
import game.user.User;
import java.util.Map;

/**
 * @author ismd
 */
public class CharacterController extends AbstractController {

    public Response set(Map<String, Object> args) {
        Double id = (Double)args.get("id");
        String key = (String)args.get("key");

        UserCharacter character = new CharacterMapper().getById(id.intValue());
        User user = new UserMapper().getById(character.getIdUser());

        if (!key.equals(user.getAuthKey())) {
            return new Response().appendData("status", "error");
        }

        return new Response()
            .appendData("status", "ok")
            .appendData("character", character);
    }

    public Response getCurrent(Map<String, Object> args) {
        // FIXME: Возвращать текущего персонажа
        return new Response().appendData("character", new CharacterMapper().getById(3));
    }

    public void move(Map<String, Object> args) {
        System.out.println("TEST MOVE");
    }
}
