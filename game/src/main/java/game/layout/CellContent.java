package game.layout;

import game.character.Character;
import game.dao.DaoFactory;
import game.mob.Mob;
import game.npc.Npc;
import java.io.Serializable;

/**
 * @author ismd
 */
abstract public class CellContent implements Serializable {

    private Cell cell;

    public Cell getCell() {
        return cell;
    }

    public CellContent setCell(Cell cell) {
        if (this instanceof Character) {
            Character character = (Character)this;
            character.setIdLayout(cell.getLayout().getId());
            character.setX(cell.getX());
            character.setY(cell.getY());
        } else if (this instanceof Mob) {
            Mob mob = (Mob)this;
            mob.setIdLayout(cell.getLayout().getId());
            mob.setX(cell.getX());
            mob.setY(cell.getY());
        } else if (this instanceof Npc) {
            Npc npc = (Npc)this;
            npc.setIdLayout(cell.getLayout().getId());
            npc.setX(cell.getX());
            npc.setY(cell.getY());
        }

        this.cell = cell;
        return this;
    }

    public ContentType getType() {
        if (this instanceof Character) {
            return ContentType.CHARACTER;
        } else if (this instanceof Mob) {
            return ContentType.MOB;
        } else if (this instanceof Npc) {
            return ContentType.NPC;
        }

        return ContentType.UNKNOWN;
    }
}
