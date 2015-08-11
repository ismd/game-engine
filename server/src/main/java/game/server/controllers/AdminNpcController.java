package game.server.controllers;

import game.dao.DaoFactory;
import game.dao.NpcDao;
import game.server.controllers.common.AbstractAdminController;
import game.server.request.Request;
import game.server.response.Response;
import game.user.User;

public class AdminNpcController extends AbstractAdminController {

    public Response readAllAction(Request request, User user) {
        NpcDao npcDao = DaoFactory.getInstance().npcDao;

        return new Response(true)
                .appendData("npcs", npcDao.getAll());
    }
}
