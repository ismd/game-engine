package game.dao;

import game.mob.MobAvailableCell;
import game.mob.MobInfo;
import java.util.List;
import org.hibernate.Session;
import org.hibernate.criterion.Restrictions;

/**
 * @author ismd
 */
public class MobDao extends Dao {

    public MobDao() {
    }

    public MobInfo getById(int id) {
        return (MobInfo)getById(MobInfo.class, id);
    }

    public List<MobInfo> getAllAvailable() {
        Session session = sessionFactory.openSession();

        List<MobInfo> mobs = session.createCriteria(MobInfo.class).list();
        session.close();

        return mobs;
    }

    public List<MobAvailableCell> getAvailableCells(MobInfo mob) {
        Session session = sessionFactory.openSession();

        List cells = session.createCriteria(MobAvailableCell.class)
                .add(Restrictions.eq("idMob", mob.getId()))
                .list();

        session.close();
        return cells;
    }
}
