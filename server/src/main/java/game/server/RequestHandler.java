package game.server;

import com.google.gson.Gson;
import com.google.gson.GsonBuilder;
import game.character.Character;
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

    private WebSocket ws;
    private RequestRouter requestRouter;
    private String message;
    private Request request;
    
    public static Map<WebSocket, Character> characters = new HashMap<>();

    RequestHandler(WebSocket ws, RequestRouter requestRouter, String message) {
        this.ws = ws;
        this.requestRouter = requestRouter;
        this.message = message;
    }

    @Override
    public void run() {
        Gson gson = new Gson();
        request = gson.fromJson(message, Request.class);

        try {
            Response response = requestRouter.executeRequest(request.setWs(ws));

            gson = new GsonBuilder()
                .excludeFieldsWithoutExposeAnnotation()
                .create();

            String json = gson.toJson(response.setIdCallback(request.getIdCallback()));

            System.out.println("Sending: " + json);
            ws.send(json);
        } catch (NoSuchMethodException | SecurityException | IllegalAccessException | IllegalArgumentException | InvocationTargetException e) {
            Logger.getLogger(RequestHandler.class.getName()).log(Level.SEVERE, null, e);
        }
    }
}
