package game.server.controllers;

import game.server.RequestHandler;
import game.world.World;

/**
 * @author ismd
 */
abstract public class AbstractController {

    protected final World world = RequestHandler.world;
}
