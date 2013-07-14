package game.layout;

import com.google.gson.annotations.Expose;
import java.util.HashMap;
import java.util.LinkedList;
import java.util.List;
import java.util.Map;

/**
 * @author ismd
 */
public class Cell {

    private Layout layout;
    @Expose
    private CellType type;
    @Expose
    private final Map<ContentType, List<CellContent>> content = new HashMap<>();
    @Expose
    private int idLayout;
    @Expose
    private int x;
    @Expose
    private int y;

    Cell(Layout layout, CellType type, int x, int y) {
        this.layout = layout;
        this.type = type;
        this.idLayout = layout.getId();
        this.x = x;
        this.y = y;

        content.put(ContentType.CHARACTER, new LinkedList<CellContent>());
        content.put(ContentType.MOB, new LinkedList<CellContent>());
        content.put(ContentType.NPC, new LinkedList<CellContent>());
    }

    public Cell addContent(CellContent item) {
        content.get(item.getType()).add(item);
        item.setCell(this);
        return this;
    }

    public Layout getLayout() {
        return layout;
    }

    public CellType getType() {
        return type;
    }

    public int getIdLayout() {
        return idLayout;
    }

    public int getX() {
        return x;
    }

    public int getY() {
        return y;
    }
}
