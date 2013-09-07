package game.server.controllers.common;

import game.User;

/**
 * @author ismd
 */
abstract public class AbstractAuthController extends AbstractController {

    public boolean init(User user) {
        if (null == user.getCurrentCharacter()) {
            return false;
        }

        return true;
    }
}
