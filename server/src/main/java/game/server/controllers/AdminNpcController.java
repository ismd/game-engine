package game.server.controllers;

import game.dao.DaoFactory;
import game.dao.NpcDao;
import game.npc.Npc;
import game.server.controllers.common.AbstractAdminController;
import game.server.request.Request;
import game.server.response.Response;
import game.user.User;
import game.world.World;
import game.world.exceptions.BadCoordinatesException;

import java.util.Map;

public class AdminNpcController extends AbstractAdminController {

    public Response readAllAction(Request request, User user) {
        NpcDao npcDao = DaoFactory.getInstance().npcDao;

        return new Response(true)
                .appendData("npcs", npcDao.getAll());
    }

    public Response updateAction(Request request, User user) {
        Map<String, Object> args = request.getArgs();
        Npc npc = World.getNpcById(Double.valueOf(args.get("id").toString()).intValue());

        if (null == npc) {
            return new Response(false, "Npc not found");
        }

        int idLayout, x, y;

        try {
            idLayout = Double.valueOf(args.get("idLayout").toString()).intValue();
            x = Double.valueOf(args.get("x").toString()).intValue();
            y = Double.valueOf(args.get("y").toString()).intValue();
        } catch (NullPointerException e) {
            return new Response(false, "Заполнены не все поля");
        }

        if (idLayout != npc.getIdLayout() || x != npc.getX() || y != npc.getY()) {
            try {
                World.layouts.get(npc.getIdLayout()).getCell(npc.getX(), npc.getY()).removeContent(npc);
                World.layouts.get(idLayout).getCell(x, y).addContent(npc);
            } catch (BadCoordinatesException e) {
                e.printStackTrace();
            }
        }

        try {
            npc.setName(args.get("name").toString());
            npc.setGreeting(args.get("greeting").toString());
            npc.setImage(args.get("image").toString());
            npc.setIdLayout(idLayout);
            npc.setX(x);
            npc.setY(y);
        } catch (NullPointerException e) {
            return new Response(false, "Заполнены не все поля");
        }

        DaoFactory.getInstance().npcDao.update(npc);
        return new Response(true);
    }

    public Response createAction(Request request, User user) {
        Map<String, Object> args = request.getArgs();
        Npc npc = new Npc();

        try {
            npc.setName(args.get("name").toString());
            npc.setGreeting(args.get("greeting").toString());
            npc.setImage(args.get("image").toString());
            npc.setIdLayout(Double.valueOf(args.get("idLayout").toString()).intValue());
            npc.setX(Double.valueOf(args.get("x").toString()).intValue());
            npc.setY(Double.valueOf(args.get("y").toString()).intValue());
        } catch (NullPointerException e) {
            return new Response(false, "Заполнены не все поля");
        }

        DaoFactory.getInstance().npcDao.add(npc);
        World.addNpc(npc);

        return new Response(true);
    }

    public Response deleteAction(Request request, User user) {
        Map<String, Object> args = request.getArgs();
        Npc npc = World.getNpcById(Double.valueOf(args.get("id").toString()).intValue());

        if (null == npc) {
            return new Response(false, "Npc not found");
        }

        DaoFactory.getInstance().mobDao.delete(npc);
        World.deleteNpc(npc);

        return new Response(true);
    }
}
