package game.layout;

import java.util.HashMap;
import java.util.Map;

/**
 * @author ismd
 */
public enum CellType {

    WATER(0),
    ROCK(1),
    GRASS(2);

    private final int id;

    private static Map<Integer, CellType> mapping;

    private CellType(int id) {
        this.id = id;
    }

    public int getId() {
        return id;
    }

    public static CellType getById(int i) {
        if (null == mapping) {
            initMapping();
        }

        return mapping.get(i);
    }

    private static void initMapping() {
        mapping = new HashMap<>();

        for (CellType type : values()) {
            mapping.put(type.getId(), type);
        }
    }
}
