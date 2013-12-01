package game.chat;

import com.google.gson.annotations.Expose;
import game.character.Character;
import java.io.Serializable;
import java.util.Date;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.Temporal;

/**
 * @author ismd
 */
@Entity
public class ChatMessage implements Serializable {

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private int id;
    private Integer idSender;
    private Integer idReceiver;
    @Expose
    private String message;
    @Expose
    @Temporal(javax.persistence.TemporalType.TIMESTAMP)
    private Date sended;

    protected ChatMessage() {
    }

    public ChatMessage(Character senderCharacter, Character receiverCharacter, String message) {
        this.idSender = senderCharacter.getId();

        if (null != receiverCharacter) {
            this.idReceiver = receiverCharacter.getId();
        }

        this.message = message;
        sended = new Date();
    }

    // Геттеры

    public int getId() {
        return id;
    }

    public int getIdSender() {
        return idSender;
    }

    public int getIdReceiver() {
        return idReceiver;
    }

    public String getMessage() {
        return message;
    }

    public Date getSended() {
        return sended;
    }
    
    // Сеттеры

    public ChatMessage setIdSender(int idSender) {
        this.idSender = idSender;
        return this;
    }

    public ChatMessage setIdReceiver(int idReceiver) {
        this.idReceiver = idReceiver;
        return this;
    }

    public ChatMessage setMesage(String message) {
        this.message = message;
        return this;
    }

    public ChatMessage setSended(Date sended) {
        this.sended = sended;
        return this;
    }
}
