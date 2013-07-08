package game.layout;

import java.util.LinkedList;
import java.util.List;

/**
 * @author ismd
 */
public class Cell {

    private Layout layout;
    private CellType type;
    private final List<CellContent> content = new LinkedList<>();
    private int x;
    private int y;

    Cell(Layout layout, CellType type, int x, int y) {
        this.layout = layout;
        this.type = type;
        this.x = x;
        this.y = y;
    }

    public Cell addContent(CellContent item) {
        content.add(item);
        item.setCell(this);
        return this;
    }

    public Layout getLayout() {
        return layout;
    }

    public CellType getType() {
        return type;
    }

    public int getX() {
        return x;
    }

    public Cell setX(int x) {
        this.x = x;
        return this;
    }

    public int getY() {
        return y;
    }

    public Cell setY(int y) {
        this.y = y;
        return this;
    }
}
