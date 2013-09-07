package game.dao;

import game.npc.Npc;
import java.util.List;
import org.hibernate.Session;

/**
 * @author ismd
 */
public class NpcDao extends Dao {

    NpcDao() {
    }

    public Npc getById(int id) {
        return (Npc)getById(Npc.class, id);
    }

    public List<Npc> getAll() {
        Session session = sessionFactory.openSession();
        List<Npc> npcs = session.createCriteria(Npc.class).list();

        session.close();
        return npcs;
    }
}
