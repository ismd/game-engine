package game.server.controllers.common;

import game.server.request.Request;

/**
 * @author ismd
 */
abstract public class AbstractController {

    public boolean init(Request request) {
        return true;
    }
}
