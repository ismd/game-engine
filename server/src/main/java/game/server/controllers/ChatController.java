package game.server.controllers;

import game.Online;
import game.character.Character;
import game.chat.ChatMessage;
import game.dao.DaoFactory;
import game.server.controllers.common.AbstractAuthController;
import game.server.request.Request;
import game.server.response.Response;
import game.user.User;
import java.util.ArrayList;
import java.util.List;

/**
 * @author ismd
 */
public class ChatController extends AbstractAuthController {

    public Response sendAction(Request request, User user) {
        Character receiverCharacter = null;
        String msg = request.getArgs().get("message").toString();

        if (null == msg) {
            return new Response(false);
        }

        ChatMessage message = new ChatMessage(user.getCurrentCharacter(), receiverCharacter, msg);

        DaoFactory.getInstance().chatMessageDao.add(message);

        List<ChatMessage> messages = new ArrayList();
        messages.add(message.setMesage(msg));

        Online.notifier.notifyAll(new Response(true, true, "chat-new-messages")
                .appendData("messages", messages));

        return new Response(true);
    }

    public Response initAction(Request request, User user) {
        return new Response(true)
                .appendData("members", Online.characters)
                .appendData("messages", DaoFactory.getInstance().chatMessageDao.getLastMessages());
    }

    public Response getMembersAction(Request request, User user) {
        return new Response(true, true, "chat-update-members")
                .appendData("members", Online.characters);
    }
}
