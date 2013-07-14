package game.mappers;

import static game.mappers.Mapper.em;
import game.mob.MobInfo;
import game.mob.MobAvailableCell;
import game.mob.Mob;
import java.util.List;
import org.hibernate.Session;

/**
 * @author ismd
 */
public class MobMapper extends Mapper {

    public MobInfo getById(int id) {
        return em.find(MobInfo.class, id);
    }

    public void save(Mob mob) {
        em.getTransaction().begin();
        em.persist(mob);
        em.getTransaction().commit();
    }

    public List<MobInfo> getAllAvailable() {
        return em.createQuery("from MobInfo", MobInfo.class).getResultList();
    }

    public List<MobAvailableCell> getAvailableCells(MobInfo mob) {
        return em.createQuery("from MobAvailableCell where idMob = :idMob", MobAvailableCell.class)
            .setParameter("idMob", mob.getId())
            .getResultList();
    }

    public void removeAllFromWorld() {
        Session session = (Session)em.getDelegate();
        session.createSQLQuery("truncate table Mob").executeUpdate();
    }
}
