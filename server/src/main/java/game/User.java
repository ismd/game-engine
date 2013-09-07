package game;

import game.character.Character;
import game.dao.DaoFactory;
import java.util.List;

/**
 * @author ismd
 */
public class User extends game.user.User {

    private Character currentCharacter;

    public User setCurrentCharacter(Character character) {
        this.currentCharacter = character;
        return this;
    }

    public Character getCurrentCharacter() {
        return currentCharacter;
    }

    public List<Character> getCharacters() {
        return DaoFactory.getInstance().getCharacterDao().getByIdUser(id);
    }
}
