package game.server.controllers;

import game.World;
import game.character.Character;
import game.chat.ChatMessage;
import game.dao.DaoFactory;
import game.server.Notifier;
import game.server.Request;
import game.server.Response;
import game.server.controllers.common.AbstractAuthController;
import java.util.ArrayList;
import java.util.List;

/**
 * @author ismd
 */
public class ChatController extends AbstractAuthController {

    public Response sendAction(Request request) {
        Character senderCharacter = World.users.get(request.getWs()).getCurrentCharacter();
        Character receiverCharacter = null;
        String msg = (String)request.getArgs().get("message");

        ChatMessage message = new ChatMessage(senderCharacter, receiverCharacter, msg);

        DaoFactory.getInstance().getChatMessageDao().addMessage(message);

        List<ChatMessage> messages = new ArrayList<>();
        messages.add(message.setMesage(msg));

        new Notifier().notifyAll(new Response(true, true, "chat-new-messages").
            appendData("messages", messages));

        return new Response(true);
    }
}
