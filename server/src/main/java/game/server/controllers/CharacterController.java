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

    public Response create(Request request) {
        User user = World.users.get(request.getWs());
        Character character = new Character();

        character.setIdUser(user.getId());
        character.setName((String)request.getArgs().get("name"));
        character.setLevel(1);
        character.setMoney(10);
        character.setIdLayout(1);
        character.setX(3);
        character.setY(3);
        character.setStrength(10);
        character.setDexterity(10);
        character.setEndurance(10);
        character.setHp(20);
        character.setMaxHp(20);
        character.setMinDamage(3);
        character.setMaxDamage(5);
        character.setImage("player.png");
        character.setExperience(0);

        DaoFactory.getInstance().getCharacterDao().addCharacter(character);
        return new Response(true);
    }
}
