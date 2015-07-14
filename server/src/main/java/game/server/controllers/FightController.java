package game.server.controllers;

import game.fight.Fight;
import game.fight.FightMob;
import game.server.controllers.common.AbstractAuthController;
import game.server.request.Request;
import game.server.response.Response;
import game.user.User;

import java.util.HashMap;
import java.util.Map;

/**
 * @author ismd
 */
public class FightController extends AbstractAuthController {

    public Response killMobAction(Request request, User user) {
        Map<String, Object> args = request.getArgs();

        try {
            int idMob = Double.valueOf(args.get("id").toString()).intValue();

            FightMob fightThread = new FightMob(user, idMob);
            fightThread.start();

            return new Response(true, true, "start-fight");
        } catch (Exception e) {
            return new Response(false, "Невозможно создать бой");
        }
    }

    public Response getInfoAction(Request request, User user) {
        Map<String, Object> args = request.getArgs();

        Fight fight = user.getCurrentCharacter().getFight();

        if (null == fight) {
            return new Response(false, "Не в драке");
        }

        Map<String, Object> data = new HashMap<String, Object>();
        data.put("initiator", fight.getInitiator());
        data.put("enemy", fight.getEnemy());
        data.put("steps", fight.getSteps());

        Response response = new Response(true);
        response.setData(data);

        return response;
    }
}
