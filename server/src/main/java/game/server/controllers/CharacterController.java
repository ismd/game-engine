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

    public Response moveAction(Request request, User user) {
        Map<String, Object> args = request.getArgs();
        Character character = user.getCurrentCharacter();

        int idLayout = Double.valueOf(args.get("idLayout").toString()).intValue();
        int x = Double.valueOf(args.get("x").toString()).intValue();
        int y = Double.valueOf(args.get("y").toString()).intValue();

        try {
            Cell oldCell = character.getCell();
            Cell newCell = Online.world.getLayout(idLayout).getCell(x, y);

            // Уведомляем персонажей на старой клетке
            oldCell.removeContent(character);
            Online.notifier.notifyByCharacter(
                    oldCell.getCharacters(),
                    new Response(true, true, "cell-update").appendData("cell", oldCell));

            // Уведомляем персонажей на новой клетке
            character.setCell(newCell.addContent(character));
            Online.notifier.notifyByCharacter(
                    newCell.getCharacters(),
                    new Response(true, true, "cell-update").appendData("cell", newCell));

            DaoFactory.getInstance().characterDao.update(character);

            return new Response(true);
        } catch (BadCoordinatesException e) {
            return new Response(false, "Невозможно переместиться");
        }
    }

    public Response setAction(Request request, User user) {
        int id = Double.valueOf(request.getArgs().get("id").toString()).intValue();
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

        return new Response(true, true, "set-character-success").appendData("character", c);
    }

    public Response createAction(Request request, User user) {
        Map<String, Object> args = request.getArgs();

        Object name = args.get("name");
        Object image = args.get("image");

        if (null == name || "".equals((String)name)) {
            return new Response(false, "Не введено имя");
        }

        if (null == image) {
            return new Response(false, "Не загружена аватарка");
        }

        int stat1 = Double.valueOf(args.get("stat1").toString()).intValue();
        int stat2 = Double.valueOf(args.get("stat2").toString()).intValue();
        int stat3 = Double.valueOf(args.get("stat3").toString()).intValue();

        Character ch = new Character()
            .setIdUser(user.getId())
            .setName((String)name)
            .setLevel(1)
            .setMoney(10)
            .setIdLayout(1)
            .setX(3)
            .setY(3)
            .setStrength(7)
            .setSpeed(7)
            .setEndurance(7)
            .setPerception(7)
            .setIntelligence(7)
            .setWill(7)
            .setHp(20)
            .setMaxHp(20)
            .setMinDamage(3)
            .setMaxDamage(5)
            .setImage((String)image)
            .setBiography((String)request.getArgs().get("biography"))
            .setStat1(stat1)
            .setStat2(stat2)
            .setStat3(stat3)
            .setExperience(0);

        user.addCharacter(ch);

        DaoFactory.getInstance().characterDao.add(ch);
        return new Response(true).appendData("character", ch);
    }
}
