package game.world;

import game.layout.Layout;
import com.google.gson.Gson;
import game.character.UserCharacter;
import game.mappers.CharacterMapper;
import game.mappers.LayoutMapper;
import game.mappers.MobMapper;
import game.mappers.NpcMapper;
import game.mob.Mob;
import game.mob.MobCell;
import game.mob.MobLayout;
import game.npc.Npc;
import game.world.exceptions.BadCoordinatesException;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.util.List;
import java.util.Map;
import java.util.Random;
import java.util.logging.Level;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

/**
 * @author ismd
 */
public class World {

    private Logger log = LoggerFactory.getLogger(World.class);
    private Map<Integer, Layout> layouts;

    public World(String dir) throws FileNotFoundException {
        log.info("Initializing world");

        Gson gson = new Gson();
        FileReader reader;

        layouts = new LayoutMapper().getAll();
        for (Map.Entry<Integer, Layout> layout : layouts.entrySet()) {
            log.info("Parsing layout ({}) {}", layout.getValue().getId(), layout.getValue().getTitle());

            reader = new FileReader(dir + "/" + layout.getValue().getId() + ".txt");
            layout.getValue().setCells(gson.fromJson(reader, int[][].class));
        }

        initializeCharacters();
        initializeMobs();
        initializeNpcs();
    }

    private void initializeCharacters() {
        log.info("Initializing characters");

        for (UserCharacter character : new CharacterMapper().getAll()) {
            log.info("Placing character `{}' ({}) on layout {} (x: {}, y: {})",
                character.getName(),
                character.getId(),
                character.getIdLayout(),
                character.getX(),
                character.getY());

            try {
                layouts.get(character.getIdLayout())
                    .getCell(character.getX(), character.getY())
                    .addContent(character);
            } catch (BadCoordinatesException ex) {
                log.error("Can't place character");
            }
        }
    }

    private void initializeMobs() {
        log.info("Initializing mobs");

        MobMapper mobMapper = new MobMapper();
        mobMapper.removeAllFromMap();

        Random random = new Random(System.currentTimeMillis());

        for (Mob mob : mobMapper.getAllAvailable()) {
            int maxInWorld = mob.getMaxInWorld();
            List<MobCell> availableCells = mobMapper.getAvailableCells(mob);

            if (0 == availableCells.size()) {
                log.warn("No available cells for mob `{}' ({})", mob.getName(), mob.getId());
                continue;
            }

            for (int i = 0; i < maxInWorld; i++) {
                MobCell mobCell;

                if (1 == availableCells.size()) {
                    mobCell = availableCells.get(0);
                } else {
                    mobCell = availableCells.get(random.nextInt(availableCells.size()));
                }

                int idLayout = mobCell.getIdLayout();
                int x = mobCell.getX();
                int y = mobCell.getY();

                log.info("Placing mob `{}' ({}) on layout {} (x: {}, y: {})",
                    mob.getName(),
                    mob.getId(),
                    idLayout,
                    x,
                    y);

                try {
                    MobLayout mobLayout = new MobLayout(mob);
                    layouts.get(idLayout).getCell(x, y).addContent(mobLayout);
                } catch (BadCoordinatesException ex) {
                    log.error("Can't place mob");
                }
            }
        }
    }

    private void initializeNpcs() {
        log.info("Initializing NPCs");

        for (Npc npc : new NpcMapper().getAll()) {
            log.info("Placing NPC `{}' ({}) on layout {} (x: {}, y: {})",
                npc.getName(),
                npc.getId(),
                npc.getIdLayout(),
                npc.getX(),
                npc.getY());

            try {
                layouts.get(npc.getIdLayout()).getCell(npc.getX(), npc.getY()).addContent(npc);
            } catch (BadCoordinatesException ex) {
                log.error("Can't place mob");
            }
        }
    }

    public Layout getLayout(int id) {
        return layouts.get(id);
    }

    public static void main(String[] args) throws FileNotFoundException {
        World world = new World("/home/ismd/coding/game/layouts");
    }
}
