package game.server.controllers;

import game.server.controllers.common.AbstractAuthController;
import game.character.Character;
import game.server.Response;
import java.util.Map;

/**
 * @author ismd
 */
public class LayoutController extends AbstractAuthController {

    public Response getCurrentCell(Character character, Map<String, Object> args) {
        return new Response(true, true, "cell-update").appendData("cell", character.getCell());
    }
}
