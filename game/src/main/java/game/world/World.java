package game.world;

import com.google.gson.Gson;
import java.io.File;
import java.io.FileReader;
import java.io.IOException;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

/**
 * @author ismd
 */
public class World {

    private Logger log = LoggerFactory.getLogger(World.class);
    private Layout[] layouts;

    public World(String dirPath) {
        log.info("Initializing world");

        Gson gson = new Gson();
        File[] dir = new File(dirPath).listFiles();

        layouts = new Layout[dir.length];

        for (int i = 0; i < dir.length; i++) {
            log.info("Parsing file {}", dir[i]);

            try (FileReader reader = new FileReader(dir[i])) {
                layouts[i] = new Layout(gson.fromJson(reader, int[][].class));
            } catch (IOException ex) {
                log.error(World.class.getName(), ex);
            }
        }
    }

    public Layout getLayout(int id) {
        return layouts[id];
    }

    public static void main(String[] args) {
        World world = new World("/home/ismd/coding/game/maps");
    }
}
