package game.server;

import com.google.gson.Gson;
import game.server.controllers.*;
import java.lang.reflect.InvocationTargetException;
import java.util.HashMap;
import java.util.Map;
import java.util.Set;
import java.util.logging.Level;
import java.util.logging.Logger;
import org.java_websocket.WebSocket;
import org.reflections.Reflections;

/**
 * @author ismd
 */
public class RequestHandler implements Runnable {

    private WebSocket ws;
    private String message;
    private Request request;

    private static Map<String, Class<? extends AbstractController>> controllers = new HashMap<>();
    private static Map<String, AbstractController> controllersObjects = new HashMap<>();

    RequestHandler(WebSocket ws, String message) {
        this.ws = ws;
        this.message = message;
    }

    static void init() {
        Reflections reflections = new Reflections("game.server.controllers");

        Set<Class<? extends AbstractController>> allControllers
            = reflections.getSubTypesOf(AbstractController.class);

        for (Class<? extends AbstractController> controller : allControllers) {
            String controllerName = controller.getName().substring("game.server.controllers.".length(),
                controller.getName().lastIndexOf("Controller"));

            try {
                controllersObjects.put(controllerName,
                    (AbstractController)Class.forName(controller.getName()).newInstance());

                controllers.put(controllerName, controller);
            } catch (ClassNotFoundException | IllegalAccessException | InstantiationException ex) {
                Logger.getLogger(RequestHandler.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
    }

    @Override
    public void run() {
        request = new Gson().fromJson(message, Request.class);

        try {
            controllers.get(request.getController())
                .getDeclaredMethod(request.getAction(), Map.class)
                .invoke(controllersObjects.get(request.getController()), request.getArgs());
        } catch (NoSuchMethodException | SecurityException | IllegalAccessException | IllegalArgumentException | InvocationTargetException | NullPointerException ex) {
            Logger.getLogger(RequestHandler.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
}
