package game.server.controllers;

import game.server.RequestRouter;
import game.world.World;

/**
 * @author ismd
 */
abstract public class AbstractController {

    protected final World world = RequestRouter.world;
}
