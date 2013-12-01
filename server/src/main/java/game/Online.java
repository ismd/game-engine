package game;

import game.character.Character;
import game.layout.CellContent;
import game.layout.ContentType;
import game.server.Notifier;
import game.server.Response;
import java.util.ArrayList;
import java.util.List;

/**
 * @author ismd
 */
public class Online {

    public static final List<Character> characters = new ArrayList<>();
    private static final Notifier notifier = new Notifier();

    public static void addCharacter(Character character) {
        characters.add(character);

        notifier.notifyByCharacter(getCharactersExcept(character.getCell().getContent().get(ContentType.CHARACTER), character),
            new Response(true, true, "cell-update").appendData("cell", character.getCell()));

        notifier.notifyAll(new Response(true, true, "chat-update-members").
            appendData("members", characters));
    }

    public static void removeCharacter(Character character) {
        character.getCell().removeContent(character);
        characters.remove(character);

        notifier.notifyByCharacter(getCharactersExcept(character.getCell().getContent().get(ContentType.CHARACTER), character),
            new Response(true, true, "cell-update").appendData("cell", character.getCell()));

        notifier.notifyAll(new Response(true, true, "chat-update-members").
            appendData("members", characters));
    }

    private static List<Character> getCharactersExcept(List<CellContent> characters, Character character) {
        List<Character> c = new ArrayList<>();

        for (Object ch : characters) {
            Character ch1 = (Character)ch;

            if (ch1 == character) {
                continue;
            }

            c.add(ch1);
        }

        return c;
    }
}
