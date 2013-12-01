package game.dao;

import game.layout.Layout;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import org.hibernate.Session;

/**
 * @author ismd
 */
public class LayoutDao extends Dao {

    LayoutDao() {
    }

    public Layout getById(int id) {
        return (Layout)getById(Layout.class, id);
    }

    public Map<Integer, Layout> getAll() {
        Session session = sessionFactory.openSession();

        List<Layout> layoutsList = session.createCriteria(Layout.class).list();
        session.close();

        Map<Integer, Layout> layouts = new HashMap<>();
        for (Layout layout : layoutsList) {
            layouts.put(layout.getId(), layout);
        }

        return layouts;
    }
}
