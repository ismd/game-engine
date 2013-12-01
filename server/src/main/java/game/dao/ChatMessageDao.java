package game.dao;

import game.chat.ChatMessage;
import java.util.Date;
import java.util.List;
import org.hibernate.Session;
import org.hibernate.criterion.Restrictions;

/**
 * @author ismd
 */
public class ChatMessageDao extends Dao {

    private final int timeout = 60 * 60 * 1000;

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

    public List<ChatMessage> getLastMessages() {
        Session session = sessionFactory.openSession();
        List<ChatMessage> messages = session.createCriteria(ChatMessage.class)
            .add(Restrictions.gt("sended", new Date(new Date().getTime() - timeout)))
            .list();

        session.close();
        return messages;
    }
}
