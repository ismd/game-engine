package game.server;

import game.World;
import game.character.Character;
import game.layout.Cell;
import game.layout.CellContent;
import game.layout.ContentType;
import game.user.User;
import java.util.ArrayList;
import java.util.List;
import org.java_websocket.WebSocket;

/**
 * @author ismd
 */
public class Disconnector implements Runnable {

    // Таймаут отключения в секундах
    private final int timeout = 60;
    private final WebSocket ws;

    public Disconnector(WebSocket ws) {
        this.ws = ws;
    }

    @Override
    public void run() {
        try {
            Thread.sleep(timeout * 1000);

            User user = World.users.get(ws);

            if (null == user) {
                return;
            }

            try {
                Cell cell = user.getCurrentCharacter().getCell();
                cell.removeContent(user.getCurrentCharacter());

                List<Character> characters = new ArrayList<>();
                for (CellContent c : cell.getContent().get(ContentType.CHARACTER)) {
                    characters.add((Character)c);
                }

                new Notifier().notifyByCharacter(characters,
                    new Response(true, true, "cell-update").appendData("cell", cell));
            } catch (Exception e) {
            }

            World.users.remove(ws);

            System.out.println("Disconnected from "
                + ws.getRemoteSocketAddress().getAddress().getHostAddress());
        } catch (Exception e) {
            System.out.println("Error while disconnecting");
            Thread.currentThread().interrupt();
        }
    }
}
