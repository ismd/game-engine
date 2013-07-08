package game.mappers;

import static game.mappers.Mapper.em;
import game.npc.Npc;
import java.util.List;

/**
 * @author ismd
 */
public class NpcMapper extends Mapper {

    public Npc getById(long id) {
        return em.find(Npc.class, id);
    }

    public void save(Npc npc) {
        em.getTransaction().begin();
        em.persist(npc);
        em.getTransaction().commit();
    }

    public List<Npc> getAll() {
        return em.createQuery("from Npc", Npc.class).getResultList();
    }
}
