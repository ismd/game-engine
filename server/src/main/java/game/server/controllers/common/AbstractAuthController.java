package game.server.controllers.common;

import game.World;
import game.server.request.Request;
import game.user.User;

/**
 * @author ismd
 */
abstract public class AbstractAuthController extends AbstractController {

    @Override
    public boolean init(Request request) {
        User user = World.users.get(request.getWs());

        if (null != user && null != user.getCurrentCharacter()) {
            return true;
        }

        String controller = request.getController();
        String action = request.getAction();

        return "Character".equals(controller) && ("create".equals(action) || "set".equals(action));
    }
}
