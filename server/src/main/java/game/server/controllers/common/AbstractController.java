package game.server.controllers.common;

import game.server.request.RequestRouter;
import game.World;
import game.server.request.Request;

/**
 * @author ismd
 */
abstract public class AbstractController {

    protected World world = RequestRouter.world;

    public boolean init(Request request) {
        return true;
    }
}
