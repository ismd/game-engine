package game.server.controllers;

import game.Notifier;
import game.Online;
import game.character.Character;
import game.chat.ChatMessage;
import game.dao.DaoFactory;
import game.server.controllers.common.AbstractAuthController;
import game.server.request.Request;
import game.server.response.Response;
import java.util.ArrayList;
import java.util.List;

/**
 * @author ismd
 */
public class ChatController extends AbstractAuthController {

    public Response sendAction(Request request, Character character) {
        Character receiverCharacter = null;
        String msg = (String)request.getArgs().get("message");

        ChatMessage message = new ChatMessage(character, receiverCharacter, msg);

        DaoFactory.getInstance().chatMessageDao.add(message);

        List<ChatMessage> messages = new ArrayList<>();
        messages.add(message.setMesage(msg));

        new Notifier().notifyAll(new Response(true, true, "chat-new-messages")
                .appendData("messages", messages));

        return new Response(true);
    }

    public Response initAction(Request request, Character character) {
        return new Response(true)
                .appendData("members", Online.characters)
                .appendData("messages", DaoFactory.getInstance().chatMessageDao.getLastMessages());
    }

    public Response getMembersAction(Request request, Character character) {
        return new Response(true, true, "chat-update-members")
                .appendData("members", Online.characters);
    }
}
