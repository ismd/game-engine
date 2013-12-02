package game;

import com.google.gson.GsonBuilder;
import game.character.Character;
import game.server.response.Response;
import game.user.User;
import java.util.ArrayList;
import java.util.List;
import java.util.Map.Entry;
import org.java_websocket.WebSocket;
import org.java_websocket.exceptions.WebsocketNotConnectedException;

/**
 * @author ismd
 */
public class Notifier {

    public void notifyByCharacter(List<Character> characters, Response response) {
        List<User> users = new ArrayList<>();

        for (Character character : characters) {
            users.add(character.getUser());
        }

        notifyByUser(users, response);
    }

    public void notifyByUser(List<User> users, Response response) {
        List<WebSocket> websockets = new ArrayList<>();

        for (User user : users) {
            websockets.add(user.getWebSocket());
        }

        notifyByWebSocket(websockets, response);
    }

    public void notifyByWebSocket(List<WebSocket> websockets, Response response) {
        String message = new GsonBuilder()
                .excludeFieldsWithoutExposeAnnotation()
                .create()
                .toJson(response);

        for (WebSocket ws : websockets) {
            ws.send(message);
        }
    }

    public void notifyAll(Response response) {
        String message = new GsonBuilder()
                .excludeFieldsWithoutExposeAnnotation()
                .create()
                .toJson(response);

        for (Entry<WebSocket, User> entry : Online.users.entrySet()) {
            try {
                entry.getKey().send(message);
            } catch (WebsocketNotConnectedException e) {
            }
        }
    }
}
