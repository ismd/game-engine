package game.server.controllers;

import game.server.RequestRouter;
import game.world.World;

/**
 * @author ismd
 */
abstract public class AbstractController {

    protected World world = RequestRouter.world;
}
