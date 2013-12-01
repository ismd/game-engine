package game.dao;

import game.character.Character;
import game.world.exceptions.BadCoordinatesException;
import java.util.List;
import org.hibernate.Session;
import org.hibernate.criterion.Restrictions;

/**
 * @author ismd
 */
public class CharacterDao extends Dao {

    CharacterDao() {
    }

    public Character getById(int id) throws BadCoordinatesException {
        return (Character)getById(Character.class, id);
    }

    public List<Character> getByIdUser(int id) {
        Session session = sessionFactory.openSession();
        List<Character> characters = session.createCriteria(Character.class)
                .add(Restrictions.eq("idUser", id))
                .list();

        session.close();
        return characters;
    }
}
