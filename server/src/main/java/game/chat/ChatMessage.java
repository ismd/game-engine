package game.chat;

import com.google.gson.annotations.Expose;
import game.character.Character;
import java.io.Serializable;
import java.util.Date;
import javax.persistence.Entity;
import javax.persistence.FetchType;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.JoinColumn;
import javax.persistence.ManyToOne;
import javax.persistence.Temporal;
import javax.persistence.Transient;

/**
 * @author ismd
 */
@Entity
public class ChatMessage implements Serializable {

    @ManyToOne(fetch=FetchType.EAGER) @JoinColumn(name="idSender", insertable=false, updatable=false) @Expose
    Character sender;
    @Expose @Transient
    Character receiver;

    @Id @GeneratedValue(strategy=GenerationType.AUTO)
    private int id;
    private Integer idSender;
    private Integer idReceiver;
    @Expose
    private String message;
    @Expose @Temporal(javax.persistence.TemporalType.TIMESTAMP)
    private Date sended;

    protected ChatMessage() {
    }

    public ChatMessage(Character senderCharacter, Character receiverCharacter, String message) {
        sender = senderCharacter;
        idSender = sender.getId();

        receiver = receiverCharacter;
        if (null != receiver) {
            idReceiver = receiver.getId();
        }

        this.message = message;
        sended = new Date();
    }

    public Character getSender() {
        return sender;
    }

    public ChatMessage setSender(Character character) {
        sender = character;
        return this;
    }

    public Character getReceiver() {
        return receiver;
    }

    public ChatMessage setReceiver(Character character) {
        receiver = character;
        return this;
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
