package game.world;

/**
 * @author ismd
 */
public class Cell {

    private CellType type;
    private CellContent[] content;

    Cell(CellType type) {
        this.type = type;
    }

    public CellType getType() {
        return type;
    }
}
