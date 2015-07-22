package game.server.controllers;

import game.dao.DaoFactory;
import game.dao.MobDao;
import game.mob.Mob;
import game.mob.MobInfo;
import game.server.controllers.common.AbstractAdminController;
import game.server.request.Request;
import game.server.response.Response;
import game.user.User;
import game.world.World;

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

        DaoFactory.getInstance().mobDao.update(mobInfo);

        return new Response(true);
    }
}
