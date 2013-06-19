package game;

import com.google.gson.Gson;
import java.lang.reflect.InvocationTargetException;
import java.lang.reflect.Method;
import java.util.HashMap;
import java.util.Map;
import java.util.TreeMap;
import org.java_websocket.WebSocket;

/**
 * @author ismd
 */
public class RequestHandler implements Runnable {

    private WebSocket ws;
    private String message;
    private Request request;
    Map<String, AbstractDispatcher> dispatchers = new HashMap<>();

    RequestHandler(WebSocket ws, String message) {
        this.ws = ws;
        this.message = message;
        dispatchers.put("move", new MoveDispatcher());
    }

    @Override
    public void run() {
        request = new Gson().fromJson(message, Request.class);
        dispatchers.get(request.getCommand()).handle();
    }

    public void move() {
        System.out.println("Moved");
    }
}


abstract class AbstractDispatcher {
    abstract void handle();
}

class MoveDispatcher extends AbstractDispatcher {

    @Override
    void handle() {
        System.out.println("Moved");
    }
}