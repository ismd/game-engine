package game.mappers;

import static game.mappers.Mapper.em;
import game.user.User;
import java.util.List;

/**
 * @author ismd
 */
public class UserMapper extends Mapper {

    public User getById(long id) {
        return em.find(User.class, id);
    }

    public void save(User user) {
        em.getTransaction().begin();
        em.persist(user);
        em.getTransaction().commit();
    }

    public List<User> getAll() {
        return em.createQuery("from User", User.class).getResultList();
    }
}
