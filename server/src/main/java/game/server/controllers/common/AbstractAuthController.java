package game.server.controllers.common;

import game.User;

/**
 * @author ismd
 */
abstract public class AbstractAuthController extends AbstractController {

    @Override
    public boolean init(User user) {
        return null != user.getCurrentCharacter();
    }
}
