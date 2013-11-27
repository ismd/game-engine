package game.server.controllers;

import game.character.Character;
import game.user.User;
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

    public Response move(Request request) {
        Character character = World.users.get(request.getWs()).getCurrentCharacter();
        Map<String, Object> args = request.getArgs();

        int idLayout = (int)(double)args.get("idLayout");
        int x = (int)(double)args.get("x");
        int y = (int)(double)args.get("y");

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
        int id = (int)(double)request.getArgs().get("id");

        try {
            Character character = new Character(DaoFactory.getInstance().getCharacterDao().getById(id));
            User user = World.users.get(request.getWs());

            if (character.getIdUser() != user.getId()) {
                return new Response(false, "Ошибка");
            }

            character.setCell(world.getLayout(character.getIdLayout()).getCell(character.getX(), character.getY()));
            user.setCurrentCharacter(character);

            return new Response(true, true, "set-character-success").appendData("character", character);
        } catch (BadCoordinatesException ex) {
            Logger.getLogger(CharacterController.class.getName()).log(Level.SEVERE, null, ex);
            return new Response(false, "Ошибка");
        }
    }

    public Response create(Request request) {
        User user = World.users.get(request.getWs());

        Character character = new Character().
            setIdUser(user.getId()).
            setName((String)request.getArgs().get("name")).
            setLevel(1).
            setMoney(10).
            setIdLayout(1).
            setX(3).
            setY(3).
            setStrength(10).
            setDexterity(10).
            setEndurance(10).
            setHp(20).
            setMaxHp(20).
            setMinDamage(3).
            setMaxDamage(5).
            setImage("player.png").
            setExperience(0);

        DaoFactory.getInstance().getCharacterDao().addCharacter(character);
        return new Response(true).appendData("character", character);
    }
}
