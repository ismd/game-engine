package game.server.controllers;

import game.World;
import game.server.controllers.common.AbstractAuthController;
import game.server.request.Request;
import game.server.response.Response;

/**
 * @author ismd
 */
public class LayoutController extends AbstractAuthController {

    public Response getCurrentCellAction(Request request) {
        return new Response(true, true, "cell-update")
                .appendData("cell", World.users.get(request.getWs()).getCurrentCharacter().getCell());
    }
}
