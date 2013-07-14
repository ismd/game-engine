package game.server.controllers;

import game.server.Response;
import java.util.Map;

/**
 * @author ismd
 */
public class LayoutController extends AbstractController {

    public Response getCurrentCell(game.character.Character character, Map<String, Object> args) {
        return new Response(true).appendData("cell", character.getCell());
    }
}
