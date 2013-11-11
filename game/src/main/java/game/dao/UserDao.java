package game.dao;

import game.user.User;
import java.io.UnsupportedEncodingException;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
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

        return (User)sessionFactory.openSession().createCriteria(User.class)
            .add(Restrictions.eq("login", login))
            .add(Restrictions.eq("password", sb.toString()))
            .setMaxResults(1)
            .list().get(0);
    }
}
