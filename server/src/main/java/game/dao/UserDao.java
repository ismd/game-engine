package game.dao;

import game.user.User;
import game.util.Md5;
import java.io.UnsupportedEncodingException;
import java.security.NoSuchAlgorithmException;
import java.util.List;
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

    public User getByLogin(String login) throws NoSuchAlgorithmException, UnsupportedEncodingException {
        List result = sessionFactory.openSession().createCriteria(User.class)
                .add(Restrictions.eq("login", login))
                .setMaxResults(1)
                .list();

        return 1 == result.size() ? (User)result.get(0) : null;
    }

    public User getByLoginAndPassword(String login, String password) throws NoSuchAlgorithmException, UnsupportedEncodingException {
        List result = sessionFactory.openSession().createCriteria(User.class)
                .add(Restrictions.eq("login", login))
                .add(Restrictions.eq("password", Md5.get(password)))
                .setMaxResults(1)
                .list();

        return 1 == result.size() ? (User)result.get(0) : null;
    }

    public User getByIdAndAuthKey(int id, String authKey) {
        List result = sessionFactory.openSession().createCriteria(User.class)
                .add(Restrictions.eq("id", id))
                .add(Restrictions.eq("authKey", authKey))
                .setMaxResults(1)
                .list();

        return 1 == result.size() ? (User)result.get(0) : null;
    }
}
