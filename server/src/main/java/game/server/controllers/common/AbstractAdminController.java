package game.server.controllers.common;

import game.Online;
import game.server.request.Request;
import game.user.User;

/**
 * @author ismd
 */
abstract public class AbstractAdminController extends AbstractController {

    @Override
    public boolean init(Request request) {
        User user = Online.users.get(request.getWs());

        if (null == user) {
            return false;
        }

        return user.getAdmin();
    }
}
