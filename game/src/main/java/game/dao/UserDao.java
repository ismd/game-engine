package game.dao;

import game.user.User;
import java.io.UnsupportedEncodingException;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.util.List;
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

    public User getByLoginAndPassword(String login, String password) throws NoSuchAlgorithmException, UnsupportedEncodingException {
        byte[] digest = MessageDigest.getInstance("MD5").digest(password.getBytes());

        StringBuilder sb = new StringBuilder();
        for (byte b : digest) {
            sb.append(Integer.toHexString((int) (b & 0xff)));
        }

        List result = sessionFactory.openSession().createCriteria(User.class)
            .add(Restrictions.eq("login", login))
            .add(Restrictions.eq("password", sb.toString()))
            .setMaxResults(1)
            .list();

        return 1 == result.size() ? (User)result.get(0) : null;
    }

    public User addUser(User user) {
        Session session = sessionFactory.openSession();

        session.beginTransaction();
        session.save(user);
        session.getTransaction().commit();

        session.close();
        return user;
    }
}
