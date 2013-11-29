package game.server.controllers;

import com.google.gson.Gson;
import com.google.gson.GsonBuilder;
import game.character.Character;
import game.user.User;
import game.World;
import game.dao.DaoFactory;
import game.server.controllers.common.AbstractAuthController;
import game.layout.Cell;
import game.layout.CellContent;
import game.layout.ContentType;
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

    public Response moveAction(Request request) {
        Character character = World.users.get(request.getWs()).getCurrentCharacter();
        Map<String, Object> args = request.getArgs();

        int idLayout = (int)(double)args.get("idLayout");
        int x = (int)(double)args.get("x");
        int y = (int)(double)args.get("y");

        try {
            Cell oldCell = character.getCell();
            Cell newCell = world.getLayout(idLayout).getCell(x, y);

            oldCell.removeContent(character);
            notifyCharactersExcept(oldCell, character);
            character.setCell(newCell.addContent(character));
            notifyCharactersExcept(newCell, character);

            DaoFactory.getInstance().getCharacterDao().update(character);

            return new Response(true, true, "cell-update").appendData("cell", newCell);
        } catch (BadCoordinatesException e) {
            return new Response(false, "Невозможно переместиться");
        }
    }

    public Response setAction(Request request) {
        int id = (int)(double)request.getArgs().get("id");

        User user = World.users.get(request.getWs());
        Character c = null;

        for (Character character : user.getCharacters()) {
            Cell cell = character.getCell();

            if (null != cell) {
                cell.removeContent(character);
            }

            if (id == character.getId()) {
                try {
                    cell = world.getLayout(character.getIdLayout()).getCell(character.getX(), character.getY());
                    character.setCell(cell.addContent(character));
                    notifyCharactersExcept(cell, character);
                } catch (BadCoordinatesException e) {
                    Logger.getLogger(CharacterController.class.getName()).log(Level.SEVERE, null, e);
                }

                user.setCurrentCharacter(character);
                c = character;
            }
        }

        if (null == c) {
            return new Response(false);
        }

        return new Response(true, true, "set-character-success").
            appendData("character", c);
    }

    public Response createAction(Request request) {
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

        user.addCharacter(character);

        DaoFactory.getInstance().getCharacterDao().addCharacter(character);
        return new Response(true).appendData("character", character);
    }

    private void notifyCharactersExcept(Cell cell, Character character) {
        Gson gson = new GsonBuilder().
            excludeFieldsWithoutExposeAnnotation().
            create();

        for (CellContent c : cell.getContent().get(ContentType.CHARACTER)) {
            Character c1 = (Character)c;

            if (c1 == character) {
                continue;
            }

            try {
                c1.getUser().getWebSocket().send(gson.toJson(new Response(true, true, "cell-update").
                    appendData("cell", cell)));
            } catch (Exception e) {
            }
        }
    }
}
