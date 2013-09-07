package game;

import java.io.FileNotFoundException;
import java.util.HashMap;
import java.util.Map;
import org.java_websocket.WebSocket;

public class World extends game.world.World {

    public final static Map<WebSocket, User> users = new HashMap<>();

    public World(String dir) throws FileNotFoundException {
        super(dir);
    }
}
