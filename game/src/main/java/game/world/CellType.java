package game.world;

import java.util.HashMap;
import java.util.Map;

/**
 * @author ismd
 */
enum CellType {

    GRASS(0),
    EARTH(1),
    WATER(2);

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
