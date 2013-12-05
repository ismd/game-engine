package game.layout;

import com.google.gson.annotations.Expose;
import game.character.Character;
import game.mob.Mob;
import game.npc.Npc;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.LinkedList;
import java.util.List;
import java.util.Map;

/**
 * @author ismd
 */
public class Cell {

    @Expose
    private final Layout layout;

    @Expose
    private final Map<ContentType, List<CellContent>> content = new HashMap<>();

    @Expose
    private final int idLayout;
    @Expose
    private final int x;
    @Expose
    private final int y;
    private final SpriteCoordinate spriteCoordinate;
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

    public Cell removeContent(CellContent item) {
        List<CellContent> list;

        if (item instanceof Character) {
            list = content.get(ContentType.CHARACTER);
        } else if (item instanceof Mob) {
            list = content.get(ContentType.MOB);
        } else if (item instanceof Npc) {
            list = content.get(ContentType.NPC);
        } else {
            list = content.get(ContentType.UNKNOWN);
        }

        list.remove(item);
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

    public Map<ContentType, List<CellContent>> getContent() {
        return content;
    }

    public List<Character> getCharacters() {
        List<Character> characters = new ArrayList<>();

        for (CellContent cc : content.get(ContentType.CHARACTER)) {
            characters.add((Character)cc);
        }

        return characters;
    }

    public List<Mob> getMobs() {
        List<Mob> mobs = new ArrayList<>();

        for (CellContent cc : content.get(ContentType.MOB)) {
            mobs.add((Mob)cc);
        }

        return mobs;
    }

    public List<Npc> getNpcs() {
        List<Npc> npcs = new ArrayList<>();

        for (CellContent cc : content.get(ContentType.NPC)) {
            npcs.add((Npc)cc);
        }

        return npcs;
    }
}
