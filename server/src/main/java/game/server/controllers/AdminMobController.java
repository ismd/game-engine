package game.server.controllers;

import game.dao.DaoFactory;
import game.dao.MobDao;
import game.server.controllers.common.AbstractAdminController;
import game.server.request.Request;
import game.server.response.Response;
import game.user.User;

public class AdminMobController extends AbstractAdminController {

    public Response readAllAction(Request request, User user) {
        MobDao mobDao = DaoFactory.getInstance().mobDao;

        return new Response(true)
                .appendData("mobs", mobDao.getAllAvailable());
    }
}
