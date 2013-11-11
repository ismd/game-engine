package game.server;

import game.User;
import game.server.controllers.common.AbstractController;
import game.server.controllers.common.AbstractAuthController;
import game.World;
import java.io.FileNotFoundException;
import java.lang.reflect.InvocationTargetException;
import java.util.HashMap;
import java.util.Map;
import java.util.logging.Level;
import java.util.logging.Logger;
import org.reflections.Reflections;

/**
 * @author ismd
 */
public class RequestRouter {

    public static World world;

    private final Map<String, Class<? extends AbstractController>> controllers = new HashMap<>();
    private final Map<String, AbstractController> controllersObjects = new HashMap<>();

    RequestRouter(String layoutsPath) throws FileNotFoundException {
        world = new World(layoutsPath);

        // Создаём и сохраняем объекты всех контроллеров
        Reflections reflections = new Reflections("game.server.controllers");

        for (Class<? extends AbstractController> controller : reflections.getSubTypesOf(AbstractController.class)) {
            initController(controller);
        }

        for (Class<? extends AbstractAuthController> controller : reflections.getSubTypesOf(AbstractAuthController.class)) {
            initController(controller);
        }
    }

    private void initController(Class<? extends AbstractController> controller) {
        String controllerName = controller.getName().substring("game.server.controllers.".length(),
            controller.getName().lastIndexOf("Controller"));

        if ("common.AbstractAuth".equals(controllerName)) {
            return;
        }

        try {
            controllersObjects.put(controllerName,
                (AbstractController)Class.forName(controller.getName()).newInstance());

            controllers.put(controllerName, controller);
        } catch (ClassNotFoundException | IllegalAccessException | InstantiationException ex) {
            Logger.getLogger(RequestHandler.class.getName()).log(Level.SEVERE, null, ex);
        }
    }

    Response executeRequest(Request request) throws NoSuchMethodException, IllegalAccessException, IllegalArgumentException, InvocationTargetException {
        User user = World.users.get(request.getWs());
        String controller = request.getController();
        AbstractController controllerObject = controllersObjects.get(controller);

        // Проверяем аутентификацию
        try {
            if (!(boolean)AbstractController.class
                .getDeclaredMethod("init", User.class)
                .invoke(controllerObject, user)) {
                return new Response(false, "Аутентификация не пройдена");
            }
        } catch (NullPointerException ex) {
            return new Response(false, "Ошибка");
        }

        return (Response)controllers.get(controller)
            .getDeclaredMethod(request.getAction(), Request.class)
            .invoke(controllerObject, request);
    }
}
