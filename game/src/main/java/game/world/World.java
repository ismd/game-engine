package game.world;

import game.layout.Layout;
import com.google.gson.Gson;
import game.dao.DaoFactory;
import game.dao.LayoutDao;
import game.dao.MobDao;
import game.dao.NpcDao;
import game.mob.MobInfo;
import game.mob.MobAvailableCell;
import game.mob.Mob;
import game.npc.Npc;
import game.world.exceptions.BadCoordinatesException;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.util.List;
import java.util.Map;
import java.util.Random;
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
        initializeLayouts(dir);
        initializeMobs();
        initializeNpcs();
    }

    private void initializeLayouts(String dir) throws FileNotFoundException {
        log.info("Initializing layouts " + dir);

        Gson gson = new Gson();
        FileReader reader;

        layouts = DaoFactory.getInstance().getLayoutDao().getAll();
        for (Map.Entry<Integer, Layout> layout : layouts.entrySet()) {
            log.info("Parsing layout ({}) {}", layout.getValue().getId(), layout.getValue().getTitle());

            reader = new FileReader(dir + "/" + layout.getValue().getId() + ".txt");
            layout.getValue().setCells(gson.fromJson(reader, int[][][].class));
        }
    }

    private void initializeMobs() {
        log.info("Initializing mobs");

        MobDao mobDao = DaoFactory.getInstance().getMobDao();
        mobDao.removeAllFromWorld();

        Random random = new Random(System.currentTimeMillis());

        for (MobInfo mob : mobDao.getAllAvailable()) {
            int maxInWorld = mob.getMaxInWorld();
            List<MobAvailableCell> availableCells = mobDao.getAvailableCells(mob);

            if (0 == availableCells.size()) {
                log.warn("No available cells for mob `{}' ({})", mob.getName(), mob.getId());
                continue;
            }

            for (int i = 0; i < maxInWorld; i++) {
                MobAvailableCell mobCell;

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
                    Mob m = new Mob(mob);
                    layouts.get(idLayout).getCell(x, y).addContent(m);
                    DaoFactory.getInstance().getMobDao().add(m);
                } catch (BadCoordinatesException e) {
                    log.error("Can't place mob");
                }
            }
        }
    }

    private void initializeNpcs() {
        log.info("Initializing NPCs");

        for (Npc npc : DaoFactory.getInstance().getNpcDao().getAll()) {
            log.info("Placing NPC `{}' ({}) on layout {} (x: {}, y: {})",
                npc.getName(),
                npc.getId(),
                npc.getIdLayout(),
                npc.getX(),
                npc.getY());

            try {
                layouts.get(npc.getIdLayout()).getCell(npc.getX(), npc.getY()).addContent(npc);
            } catch (BadCoordinatesException e) {
                log.error("Can't place mob");
            }
        }
    }

    public Layout getLayout(int id) {
        return layouts.get(id);
    }
}
