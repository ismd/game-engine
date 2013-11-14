package game.server.controllers;

import game.Character;
import game.User;
import game.World;
import game.dao.DaoFactory;
import game.server.controllers.common.AbstractAuthController;
import game.layout.Cell;
import game.server.Request;
import game.server.Response;
import game.world.exceptions.BadCoordinatesException;
import java.util.Map;
import java.util.logging.Level;
import java.util.logging.Logger;

/**
 * @author ismd
 */
public class CharacterController extends AbstractAuthController {

    public Response move(User user, Map<String, Double> args) {
        Character character = user.getCurrentCharacter();

        int idLayout = args.get("idLayout").intValue();
        int x = args.get("x").intValue();
        int y = args.get("y").intValue();

        try {
            Cell cell = world.getLayout(idLayout).getCell(x, y);

            character.getCell().removeContent(character);
            character.setCell(cell.addContent(character));

            return new Response(true, true, "cell-update").appendData("cell", cell);
        } catch (BadCoordinatesException e) {
            return new Response(false, "Невозможно переместиться");
        }
    }

    public Response set(Request request) {
        int id = (int)request.getArgs().get("id");

        try {
            World.users.get(request.getWs()).setCurrentCharacter(new Character(DaoFactory.getInstance().getCharacterDao().getById(id)));
        } catch (BadCoordinatesException ex) {
            Logger.getLogger(CharacterController.class.getName()).log(Level.SEVERE, null, ex);
            return new Response(false, "Ошибка");
        }

        return new Response(true);
    }
}
