package game.server.request;

import com.google.gson.Gson;
import com.google.gson.GsonBuilder;
import game.character.Character;
import game.server.response.Response;
import java.lang.reflect.InvocationTargetException;
import java.util.HashMap;
import java.util.Map;
import java.util.logging.Level;
import java.util.logging.Logger;
import org.java_websocket.WebSocket;

/**
 * @author ismd
 */
public class RequestHandler implements Runnable {

    private final WebSocket ws;
    private final String message;
    
    public static Map<WebSocket, Character> characters = new HashMap<>();

    public RequestHandler(WebSocket ws, String message) {
        this.ws = ws;
        this.message = message;
    }

    @Override
    public void run() {
        Gson gson = new Gson();
        Request request = gson.fromJson(message, Request.class);

        try {
            Response response = new RequestRouter().executeRequest(request.setWs(ws));

            gson = new GsonBuilder()
                    .excludeFieldsWithoutExposeAnnotation()
                    .create();

            String json = gson.toJson(response.setIdCallback(request.getIdCallback()));

            System.out.println("Sending: " + json);
            ws.send(json);
        } catch (NoSuchMethodException | IllegalAccessException | InvocationTargetException e) {
            Logger.getLogger(RequestHandler.class.getName()).log(Level.SEVERE, null, e);
        }
    }
}
