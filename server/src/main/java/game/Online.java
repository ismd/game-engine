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
import java.util.Map.Entry;
import org.java_websocket.WebSocket;

/**
 * @author ismd
 */
public class Online {

    public static World world;

    public static final Map<WebSocket, User> users = new HashMap<>();
    public static final List<Character> characters = new ArrayList<>();

    public static final Notifier notifier = new Notifier();

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

    public static void removeUserById(int id) {
        User user;

        for (Entry<WebSocket, User> entry : users.entrySet()) {
            user = entry.getValue();

            if (id == user.getId()) {
                removeUser(user);
                return;
            }
        }
    }

    public static void addCharacter(Character character) {
        Cell cell = character.getCell();
        characters.add(character.getId(), character);

        List<Character> cellCharacters = cell.getCharacters();
        cellCharacters.remove(character);

        notifier.notifyByCharacter(
                cellCharacters,
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

    public static void removeCharacterById(int id) {
        Character character = characters.get(id);

        if (null == character) {
            return;
        }

        removeCharacter(character);
    }
}
