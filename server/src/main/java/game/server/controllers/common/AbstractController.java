package game.server.controllers.common;

import game.server.RequestRouter;
import game.World;
import game.server.Request;

/**
 * @author ismd
 */
abstract public class AbstractController {

    protected World world = RequestRouter.world;

    public boolean init(Request request) {
        return true;
    }
}
