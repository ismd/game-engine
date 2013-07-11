package game.server.controllers;

import game.character.Character;
import game.server.Response;
import java.util.Map;

/**
 * @author ismd
 */
public class CharacterController extends AbstractController {

    public void move(Character character, Map<String, Object> args) {
        System.out.println("TEST MOVE");
    }
}
