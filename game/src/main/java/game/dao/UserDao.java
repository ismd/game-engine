package game.dao;

import game.user.User;
import org.hibernate.Session;
import org.hibernate.criterion.Restrictions;

/**
 * @author ismd
 */
public class UserDao extends Dao {

    UserDao() {
    }

    public User getById(int id) {
        return (User)getById(User.class, id);
    }

    public User getByLoginAndPassword(String login, String password) {
        Session session = sessionFactory.openSession();

        return (User)session.createCriteria(User.class)
            .add(Restrictions.eq("login", login))
            .add(Restrictions.eq("password", password))
            .setMaxResults(1)
            .list();
    }
}
