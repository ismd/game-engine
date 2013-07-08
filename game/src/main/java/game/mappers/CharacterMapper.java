package game.mappers;

import game.character.UserCharacter;
import static game.mappers.Mapper.em;
import java.util.List;

/**
 * @author ismd
 */
public class CharacterMapper extends Mapper {

    public UserCharacter getById(int id) {
        return em.find(UserCharacter.class, id);
    }

    public void save(UserCharacter character) {
        em.getTransaction().begin();
        em.persist(character);
        em.getTransaction().commit();
    }

    public List<UserCharacter> getAll() {
        return em.createQuery("from UserCharacter", UserCharacter.class).getResultList();
    }
}
