package game.server;

import com.google.gson.Gson;
import com.google.gson.GsonBuilder;
import game.server.controllers.*;
import game.world.World;
import java.io.FileNotFoundException;
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

    public static World world;

    RequestHandler(WebSocket ws, String message) {
        this.ws = ws;
        this.message = message;
    }

    static void init(String layoutsPath) throws FileNotFoundException {
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

        world = new World(layoutsPath);
    }

    @Override
    public void run() {
        Gson gson = new Gson();
        request = gson.fromJson(message, Request.class);

        try {
            Response response = (Response)controllers.get(request.getController())
                .getDeclaredMethod(request.getAction(), Map.class)
                .invoke(controllersObjects.get(request.getController()), request.getArgs());

            gson = new GsonBuilder()
                .excludeFieldsWithoutExposeAnnotation()
                .create();

            System.out.println("Sending: " + response.setIdCallback(request.getIdCallback()).toString());
            System.out.println(gson.toJson(response));
            ws.send(gson.toJson(response));
        } catch (NoSuchMethodException | SecurityException | IllegalAccessException | IllegalArgumentException | InvocationTargetException | NullPointerException ex) {
            Logger.getLogger(RequestHandler.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
}
