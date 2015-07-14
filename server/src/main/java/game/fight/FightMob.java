package game.fight;

import game.dao.MobDao;
import game.user.User;
import game.world.World;
import org.java_websocket.WebSocket;

/**
 * @author ismd
 */
public class FightMob extends Fight {

    int id;

    public FightMob(User user, int idMob) {
        super(user.getCurrentCharacter(), user.getWebSocket(), World.getMobById(idMob));
        id = idMob;
    }

    void afterFight() {
        World.removeMobById(id);
    }
}
