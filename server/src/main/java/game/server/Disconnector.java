package game.server;

import game.Online;
import game.World;
import game.character.Character;
import game.user.User;
import java.util.logging.Level;
import java.util.logging.Logger;
import org.java_websocket.WebSocket;

/**
 * @author ismd
 */
public class Disconnector implements Runnable {

    // Таймаут отключения в секундах
    private final int timeout = 60;
    private final WebSocket ws;
    private final String ip;

    public Disconnector(WebSocket ws) {
        this.ws = ws;
        ip = ws.getRemoteSocketAddress().getAddress().getHostAddress();
    }

    @Override
    public void run() {
        try {
            Thread.sleep(timeout * 1000);

            User user = World.users.get(ws);

            if (null == user) {
                return;
            }

            World.users.remove(ws);

            Character character = user.getCurrentCharacter();
            if (null != character) {
                Online.removeCharacter(character);
            }

            System.out.println("User " + user.getLogin() + " disconnected from " + ip);
        } catch (Exception e) {
            Logger.getLogger(Disconnector.class.getName()).log(Level.SEVERE, null, e);
            Thread.currentThread().interrupt();
        }
    }
}
