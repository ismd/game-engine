package game.world;

/**
 * @author ismd
 */
public class Cell {

    private CellType type;
    private CellContent[] content;

    Cell(CellType type) {
        this.type = type;
        System.out.println("CREATED NEW CELL OF TYPE " + type);
    }
}
