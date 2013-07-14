package game.mappers;

import static game.mappers.Mapper.em;
import game.mob.Mob;
import game.mob.MobCell;
import game.mob.MobLayout;
import java.util.List;
import org.hibernate.Session;

/**
 * @author ismd
 */
public class MobMapper extends Mapper {

    public Mob getById(int id) {
        return em.find(Mob.class, id);
    }

    public void save(MobLayout mob) {
        em.getTransaction().begin();
        em.merge(mob);
        em.getTransaction().commit();
    }

    public List<Mob> getAllAvailable() {
        return em.createQuery("from Mob", Mob.class).getResultList();
    }

    public List<MobCell> getAvailableCells(Mob mob) {
        return em.createQuery("from MobCell where idMob = :idMob", MobCell.class)
            .setParameter("idMob", mob.getId())
            .getResultList();
    }

    public void removeAllFromMap() {
        Session session = (Session)em.getDelegate();
        session.createSQLQuery("truncate table `MobLayout`").executeUpdate();
    }
}
