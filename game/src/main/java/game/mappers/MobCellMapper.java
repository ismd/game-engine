package game.mappers;

import static game.mappers.Mapper.em;
import game.mob.Mob;
import java.util.List;

/**
 * @author ismd
 */
public class MobCellMapper extends Mapper {

    public Mob getById(int id) {
        return em.find(Mob.class, id);
    }

    public void save(Mob mob) {
        em.getTransaction().begin();
        em.persist(mob);
        em.getTransaction().commit();
    }

    public List<Mob> getAll() {
        return em.createQuery("from Mob", Mob.class).getResultList();
    }
}
