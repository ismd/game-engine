package game.dao;

import org.hibernate.Session;
import org.hibernate.SessionFactory;
import org.hibernate.cfg.Configuration;

/**
 * @author ismd
 */
abstract public class Dao {

    protected final static SessionFactory sessionFactory = new Configuration().configure().buildSessionFactory();

    protected Object getById(Class c, int id) {
        return sessionFactory.openSession().load(c, id);
    }

    public void add(Object object) {
        Session session = sessionFactory.openSession();

        session.beginTransaction();
        session.save(object);
        session.getTransaction().commit();
        session.close();
    }

    public void update(Object object) {
        Session session = sessionFactory.openSession();

        session.beginTransaction();
        session.update(object);
        session.getTransaction().commit();
        session.close();
    }
}
