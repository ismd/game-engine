package game.mappers;

import game.character.Character;
import static game.mappers.Mapper.em;
import game.world.exceptions.BadCoordinatesException;
import java.util.List;

/**
 * @author ismd
 */
public class CharacterMapper extends Mapper {

    public Character getById(int id) throws BadCoordinatesException {
        return em.find(Character.class, id);
    }

    public void save(Character character) {
        em.getTransaction().begin();
        em.merge(character);
        em.getTransaction().commit();
    }

    public List<Character> getAll() {
        return em.createQuery("from Character", Character.class).getResultList();
    }
}
