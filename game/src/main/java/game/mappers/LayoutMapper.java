package game.mappers;

import game.layout.Layout;
import static game.mappers.Mapper.em;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

/**
 * @author ismd
 */
public class LayoutMapper extends Mapper {

    public Layout getById(int id) {
        return em.find(Layout.class, id);
    }

    public void save(Layout layout) {
        em.getTransaction().begin();
        em.persist(layout);
        em.getTransaction().commit();
    }

    public Map<Integer, Layout> getAll() {
        List<Layout> layoutsList = em.createQuery("from Layout", Layout.class).getResultList();

        Map<Integer, Layout> layouts = new HashMap<>();

        for (Layout layout : layoutsList) {
            layouts.put(layout.getId(), layout);
        }

        return layouts;
    }
}
