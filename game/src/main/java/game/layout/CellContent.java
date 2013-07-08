package game.layout;

import java.io.Serializable;

/**
 * @author ismd
 */
abstract public class CellContent implements Serializable {

    private Cell cell;

    public Cell getCell() {
        return cell;
    }

    public void setCell(Cell cell) {
        this.cell = cell;
    }
}
