package game.server.controllers;

import game.character.Character;
import game.layout.Cell;
import game.server.Response;
import game.world.exceptions.BadCoordinatesException;
import java.util.Map;

/**
 * @author ismd
 */
public class CharacterController extends AbstractController {

    public Response move(Character character, Map<String, Double> args) {
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
}
