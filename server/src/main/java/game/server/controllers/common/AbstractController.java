package game.server.controllers.common;

import game.User;
import game.server.RequestRouter;
import game.World;

/**
 * @author ismd
 */
abstract public class AbstractController {

    protected World world = RequestRouter.world;

    public boolean init(User user) {
        return true;
    }
}
