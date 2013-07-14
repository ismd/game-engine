package game.server;

import game.character.Character;
import game.mappers.CharacterMapper;
import game.mappers.UserMapper;
import game.server.controllers.AbstractController;
import game.user.User;
import game.world.World;
import game.world.exceptions.BadCoordinatesException;
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
public class RequestRouter {

    public static World world;

    private Map<String, Class<? extends AbstractController>> controllers = new HashMap<>();
    private Map<String, AbstractController> controllersObjects = new HashMap<>();

    private final Map<WebSocket, Character> characters = new HashMap<>();

    RequestRouter(String layoutsPath) throws FileNotFoundException {
        world = new World(layoutsPath);

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

    Response executeRequest(Request request) throws NoSuchMethodException, IllegalAccessException, IllegalArgumentException, InvocationTargetException {
        Character character = characters.get(request.getWs());

        if (null == character || ("Character".equals(request.getController())) && "set".equals(request.getAction())) {
            try {
                character = setCharacter(request);
                characters.put(request.getWs(), character);

                return new Response(true).appendData("character", character);
            } catch (BadAuthKeyException e) {
                return new Response(false, "Неверный ключ");
            } catch (Exception e) {
                System.out.println(e.getMessage());
                return new Response(false, "Ошибка");
            }
        }

        return (Response)controllers.get(request.getController())
            .getDeclaredMethod(request.getAction(), Character.class, Map.class)
            .invoke(controllersObjects.get(request.getController()), character, request.getArgs());
    }

    private Character setCharacter(Request request) throws BadAuthKeyException, BadCoordinatesException {
        Map<String, Object> args = request.getArgs();

        Double id = (Double)args.get("id");
        String key = (String)args.get("key");

        Character character = new CharacterMapper().getById(id.intValue());
        User user = new UserMapper().getById(character.getIdUser());

        if (!key.equals(user.getAuthKey())) {
            throw new BadAuthKeyException();
        }

        return (Character)character.setCell(world.getLayout(character.getIdLayout()).getCell(character.getX(), character.getY()));
    }

    void removeCharacter(WebSocket ws) {
        Character character = characters.get(ws);
        character.getCell().removeContent(character);

        characters.remove(ws);
    }
}

class BadAuthKeyException extends Exception {
}
