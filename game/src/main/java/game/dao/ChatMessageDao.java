package game.dao;

import game.chat.ChatMessage;
import org.hibernate.Session;

/**
 * @author ismd
 */
public class ChatMessageDao extends Dao {

    ChatMessageDao() {
    }

    public ChatMessage addMessage(ChatMessage message) {
        Session session = sessionFactory.openSession();

        session.beginTransaction();
        session.save(message);
        session.getTransaction().commit();

        session.close();
        return message;
    }
}
