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
    private final Map<ContentType, List<CellContent>> content = new HashMap<>();
    @Expose
    private int idLayout;
    @Expose
    private int x;
    @Expose
    private int y;
    @Expose
    private SpriteCoordinate spriteCoordinate;
    @Expose
    private SpriteCoordinate[][] vicinity = new SpriteCoordinate[7][5];

    Cell(Layout layout, int x, int y, SpriteCoordinate spriteCoordinate) {
        this.layout = layout;
        this.idLayout = layout.getId();
        this.x = x;
        this.y = y;
        this.spriteCoordinate = spriteCoordinate;

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

    public int getIdLayout() {
        return idLayout;
    }

    public int getX() {
        return x;
    }

    public int getY() {
        return y;
    }

    public SpriteCoordinate getSpriteCoordinate() {
        return spriteCoordinate;
    }

    public Cell setVicinity(SpriteCoordinate[][] vicinity) {
        this.vicinity = vicinity;
        return this;
    }

    public SpriteCoordinate[][] getVicinity() {
        return vicinity;
    }
}
