package game.server.controllers;

import com.google.gson.Gson;
import game.dao.DaoFactory;
import game.dao.MobDao;
import game.mob.MobAvailableCell;
import game.mob.MobInfo;
import game.server.controllers.common.AbstractAdminController;
import game.server.request.Request;
import game.server.response.Response;
import game.user.User;
import game.world.World;

import java.util.ArrayList;
import java.util.List;
import java.util.Map;

public class AdminMobController extends AbstractAdminController {

    public Response readAllAction(Request request, User user) {
        MobDao mobDao = DaoFactory.getInstance().mobDao;

        return new Response(true)
                .appendData("mobs", mobDao.getAllAvailable());
    }

    public Response updateAction(Request request, User user) {
        Map<String, Object> args = request.getArgs();
        MobInfo mobInfo = World.getMobInfoById(Double.valueOf(args.get("id").toString()).intValue());

        if (null == mobInfo) {
            return new Response(false, "Mob not found");
        }

        mobInfo.setName(args.get("name").toString());
        mobInfo.setLevel(Double.valueOf(args.get("level").toString()).intValue());
        mobInfo.setMinDamage(Double.valueOf(args.get("minDamage").toString()).intValue());
        mobInfo.setMaxDamage(Double.valueOf(args.get("maxDamage").toString()).intValue());
        mobInfo.setMaxHp(Double.valueOf(args.get("maxHp").toString()).intValue());
        mobInfo.setExperience(Double.valueOf(args.get("experience").toString()).intValue());
        mobInfo.setMaxInWorld(Double.valueOf(args.get("maxInWorld").toString()).intValue());
        mobInfo.setImage(args.get("image").toString());

        DaoFactory.getInstance().mobDao.update(mobInfo);

        return new Response(true);
    }

    public Response createAction(Request request, User user) {
        Map<String, Object> args = request.getArgs();
        MobInfo mobInfo = new MobInfo();

        try {
            mobInfo.setName(args.get("name").toString());
            mobInfo.setLevel(Double.valueOf(args.get("level").toString()).intValue());
            mobInfo.setMinDamage(Double.valueOf(args.get("minDamage").toString()).intValue());
            mobInfo.setMaxDamage(Double.valueOf(args.get("maxDamage").toString()).intValue());
            mobInfo.setMaxHp(Double.valueOf(args.get("maxHp").toString()).intValue());
            mobInfo.setExperience(Double.valueOf(args.get("experience").toString()).intValue());
            mobInfo.setMaxInWorld(Double.valueOf(args.get("maxInWorld").toString()).intValue());
            mobInfo.setImage(args.get("image").toString());
        } catch (NullPointerException e) {
            return new Response(false, "Заполнены не все поля");
        }

        DaoFactory.getInstance().mobDao.add(mobInfo);
        World.addMobInfo(mobInfo);

        return new Response(true);
    }

    public Response deleteAction(Request request, User user) {
        Map<String, Object> args = request.getArgs();
        MobInfo mobInfo = World.getMobInfoById(Double.valueOf(args.get("id").toString()).intValue());

        if (null == mobInfo) {
            return new Response(false, "Mob not found");
        }

        DaoFactory.getInstance().mobDao.delete(mobInfo);
        World.deleteMobInfo(mobInfo);

        return new Response(true);
    }

    public Response getAvailableCellsAction(Request request, User user) {
        Map<String, Object> args = request.getArgs();
        MobInfo mobInfo = World.getMobInfoById(Double.valueOf(args.get("id").toString()).intValue());

        if (null == mobInfo) {
            return new Response(false, "Mob not found");
        }

        return new Response(true)
                .appendData("cells", mobInfo.getAvailableCells());
    }

    public Response setAvailableCellsAction(Request request, User user) {
        Map<String, Object> args = request.getArgs();
        MobInfo mobInfo = World.getMobInfoById(Double.valueOf(args.get("id").toString()).intValue());

        if (null == mobInfo) {
            return new Response(false, "Mob not found");
        }

        Gson gson = new Gson();
        List<MobAvailableCell> cellsJson = gson.fromJson(args.get("availableCells").toString(), List.class);
        List<MobAvailableCell> currentCells = mobInfo.getAvailableCells();

        List<MobAvailableCell> cells = new ArrayList<>();
        for (Object cell : cellsJson) {
            MobAvailableCell c = gson.fromJson(cell.toString(), MobAvailableCell.class);
            cells.add(c.setIdMob(mobInfo.getId()));
        }

        for (MobAvailableCell cell : cells) {
            boolean found = false;

            for (MobAvailableCell currentCell : currentCells) {
                if (cell.getIdLayout() == currentCell.getIdLayout()
                        && cell.getX() == currentCell.getX()
                        && cell.getY() == currentCell.getY()) {
                    found = true;
                    break;
                }
            }

            if (!found) {
                DaoFactory.getInstance().mobAvailableCellDao.add(cell);
            }
        }

        for (MobAvailableCell currentCell : currentCells) {
            boolean found = false;

            for (MobAvailableCell cell : cells) {
                if (cell.getIdLayout() == currentCell.getIdLayout()
                        && cell.getX() == currentCell.getX()
                        && cell.getY() == currentCell.getY()) {
                    found = true;
                    break;
                }
            }

            if (!found) {
                DaoFactory.getInstance().mobAvailableCellDao.delete(currentCell);
            }
        }

        mobInfo.setAvailableCells(cells);
        return new Response(true);
    }
}
