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
import javax.persistence.Transient;

/**
 * @author ismd
 */
@Entity
public class ChatMessage implements Serializable {

    @Transient
    private Character senderCharacter;
    @Transient
    private Character receiverCharacter;

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    @Expose
    private int id;
    @Expose
    private Integer idSender;
    @Expose
    private Integer idReceiver;
    @Expose
    private String message;
    @Expose
    @Temporal(javax.persistence.TemporalType.TIMESTAMP)
    private Date sended;

    @Expose
    @Transient
    private String senderName;

    protected ChatMessage() {
    }

    public ChatMessage(Character senderCharacter, Character receiverCharacter, String message) {
        this.senderCharacter = senderCharacter;
        this.receiverCharacter = receiverCharacter;
        this.idSender = senderCharacter.getId();

        if (null != receiverCharacter) {
            this.idReceiver = receiverCharacter.getId();
        }

        this.message = message;
        senderName = senderCharacter.getName();
        sended = new Date();
    }

    public Character getSenderCharacter() {
        return senderCharacter;
    }

    public Character getReceiverCharacter() {
        return receiverCharacter;
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

    public Date getSended() {
        return sended;
    }

    public ChatMessage setSended(Date sended) {
        this.sended = sended;
        return this;
    }
}
