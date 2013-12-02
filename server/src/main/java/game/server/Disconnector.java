package game.server;

import game.Online;
import game.user.User;
import org.java_websocket.WebSocket;

/**
 * @author ismd
 */
public class Disconnector implements Runnable {

    private final WebSocket ws;
    private final String ip;

    public Disconnector(WebSocket ws) {
        this.ws = ws;
        ip = ws.getRemoteSocketAddress().getAddress().getHostAddress();
    }

    @Override
    public void run() {
        User user = Online.users.get(ws);

        if (null == user) {
            return;
        }

        Online.removeUser(user);
        System.out.println("User " + user.getLogin() + " disconnected from " + ip);
    }
}
