package game;

import game.dao.DaoFactory;
import java.util.ArrayList;
import java.util.List;

/**
 * @author ismd
 */
public class User extends game.user.User {

    private Character currentCharacter;

    public User(game.user.User user) {
        super(user);
    }

    public User setCurrentCharacter(Character character) {
        for (Character c : getCharacters()) {
            if (c.getId() == character.getId()) {
                this.currentCharacter = character;
                return this;
            }
        }

        return null;
    }

    public Character getCurrentCharacter() {
        return currentCharacter;
    }

    public List<Character> getCharacters() {
        List<Character> result = new ArrayList<>();

        for (game.character.Character character : DaoFactory.getInstance().getCharacterDao().getByIdUser(id)) {
            result.add(new Character(character));
        }

        return result;
    }
}
