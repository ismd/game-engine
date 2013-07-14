package game.layout;

import game.character.Character;
import game.mob.MobLayout;
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
        this.cell = cell;
        return this;
    }

    public ContentType getType() {
        if (this instanceof Character) {
            return ContentType.CHARACTER;
        } else if (this instanceof MobLayout) {
            return ContentType.MOB;
        } else if (this instanceof Npc) {
            return ContentType.NPC;
        }

        return ContentType.UNKNOWN;
    }
}
