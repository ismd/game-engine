package game.server.controllers;

import game.Online;
import game.character.Character;
import game.dao.DaoFactory;
import game.layout.Cell;
import game.server.controllers.common.AbstractAuthController;
import game.server.request.Request;
import game.server.response.Response;
import game.user.User;
import game.world.exceptions.BadCoordinatesException;
import java.util.Map;
import java.util.logging.Level;
import java.util.logging.Logger;

/**
 * @author ismd
 */
public class CharacterController extends AbstractAuthController {

    public Response moveAction(Request request, Character character) {
        Map<String, Object> args = request.getArgs();

        int idLayout = (int)(double)args.get("idLayout");
        int x = (int)(double)args.get("x");
        int y = (int)(double)args.get("y");

        try {
            Cell oldCell = character.getCell();
            Cell newCell = Online.world.getLayout(idLayout).getCell(x, y);

            // Уведомляем персонажей на старой клетке
            oldCell.removeContent(character);
            Online.notifier.notifyByCharacter(
                    oldCell.getCharacters(),
                    new Response(true, true, "cell-update").appendData("cell", oldCell)
            );

            // Уведомляем персонажей на новой клетке
            character.setCell(newCell.addContent(character));
            Online.notifier.notifyByCharacter(
                    newCell.getCharacters(),
                    new Response(true, true, "cell-update").appendData("cell", newCell)
            );

            DaoFactory.getInstance().characterDao.update(character);

            return new Response(true);
        } catch (BadCoordinatesException e) {
            return new Response(false, "Невозможно переместиться");
        }
    }

    public Response setAction(Request request, Character character) {
        int id = (int)(double)request.getArgs().get("id");

        User user = Online.users.get(request.getWs());
        Character c = null;

        // Удаляем всех персонажей пользователя с карты
        for (Character ch : user.getCharacters()) {
            Cell cell = ch.getCell();

            if (null != cell) {
                Online.removeCharacter(ch);
            }

            if (id == ch.getId()) {
                try {
                    cell = Online.world.getLayout(ch.getIdLayout()).getCell(ch.getX(), ch.getY());
                    ch.setCell(cell.addContent(ch));
                    Online.addCharacter(ch);
                } catch (BadCoordinatesException e) {
                    Logger.getLogger(CharacterController.class.getName()).log(Level.SEVERE, null, e);
                }

                user.setCurrentCharacter(ch);
                c = ch;
            }
        }

        if (null == c) {
            return new Response(false);
        }

        return new Response(true, true, "set-character-success").
            appendData("character", c);
    }

    public Response createAction(Request request, Character character) {
        User user = Online.users.get(request.getWs());

        Character ch = new Character()
                .setIdUser(user.getId())
                .setName((String)request.getArgs().get("name"))
                .setLevel(1)
                .setMoney(10)
                .setIdLayout(1)
                .setX(3)
                .setY(3)
                .setStrength(10)
                .setDexterity(10)
                .setEndurance(10)
                .setHp(20)
                .setMaxHp(20)
                .setMinDamage(3)
                .setMaxDamage(5)
                .setImage("player.png")
                .setExperience(0);

        user.addCharacter(ch);

        DaoFactory.getInstance().characterDao.add(ch);
        return new Response(true).appendData("character", ch);
    }
}
