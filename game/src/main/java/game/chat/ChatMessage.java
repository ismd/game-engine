package game.chat;

import com.google.gson.annotations.Expose;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;

/**
 * @author ismd
 */
@Entity
public class ChatMessage {

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    @Expose
    private int id;
    @Expose
    private int idSender;
    @Expose
    private int idReceiver;
    @Expose
    private String message;

    private ChatMessage() {
    }

    public ChatMessage(int idSender, String message) {
        this.idSender = idSender;
        this.message = message;
    }

    public int getId() {
        return id;
    }

    public int getIdSender() {
        return idSender;
    }

    public ChatMessage setIdSender(int idSender) {
        this.idSender = idSender;
        return this;
    }

    public int getIdReceiver() {
        return idReceiver;
    }

    public ChatMessage setIdReceiver(int idReceiver) {
        this.idReceiver = idReceiver;
        return this;
    }

    public String getMessage() {
        return message;
    }

    public ChatMessage setMesage(String message) {
        this.message = message;
        return this;
    }
}
