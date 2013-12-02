package game;

import game.character.Character;
import game.layout.Cell;
import game.server.response.Response;
import game.user.User;
import game.world.World;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import org.java_websocket.WebSocket;

/**
 * @author ismd
 */
public class Online {

    public static World world;

    public static final Map<WebSocket, User> users = new HashMap<>();
    public static final List<Character> characters = new ArrayList<>();

    private static final Notifier notifier = new Notifier();

    public static void addUser(User user) {
        Online.users.put(user.getWebSocket(), user);
    }

    public static void removeUser(User user) {
        Character character = user.getCurrentCharacter();
        if (null != character) {
            removeCharacter(character);
        }

        users.remove(user.getWebSocket());
    }

    public static void addCharacter(Character character) {
        Cell cell = character.getCell();
        characters.add(character);

        List<Character> characters = cell.getCharacters();
        characters.remove(character);

        notifier.notifyByCharacter(
                characters,
                new Response(true, true, "cell-update").appendData("cell", cell)
        );

        notifier.notifyAll(new Response(true, true, "chat-update-members")
                .appendData("members", characters));
    }

    public static void removeCharacter(Character character) {
        Cell cell = character.getCell();

        cell.removeContent(character);
        characters.remove(character);

        notifier.notifyByCharacter(
                cell.getCharacters(),
                new Response(true, true, "cell-update").appendData("cell", cell)
        );

        notifier.notifyAll(new Response(true, true, "chat-update-members")
                .appendData("members", characters));
    }
}
