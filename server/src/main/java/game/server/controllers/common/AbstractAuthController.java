package game.server.controllers.common;

import game.World;
import game.server.Request;

/**
 * @author ismd
 */
abstract public class AbstractAuthController extends AbstractController {

    @Override
    public boolean init(Request request) {
        if (null != World.users.get(request.getWs()).getCurrentCharacter()) {
            return true;
        }

        String controller = request.getController();
        String action = request.getAction();

        if ("Character".equals(controller) && ("create".equals(action) || "set".equals(action))) {
            return true;
        }

        return false;
    }
}
