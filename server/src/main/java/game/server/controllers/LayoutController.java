package game.server.controllers;

import game.server.controllers.common.AbstractAuthController;
import game.server.request.Request;
import game.server.response.Response;
import game.user.User;

/**
 * @author ismd
 */
public class LayoutController extends AbstractAuthController {

    public Response getCurrentCellAction(Request request, User user) {
        return new Response(true, true, "cell-update")
                .appendData("cell", user.getCurrentCharacter().getCell());
    }
}
