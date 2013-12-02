package game.user;

import com.google.gson.annotations.Expose;
import game.character.Character;
import game.dao.DaoFactory;
import java.io.Serializable;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.Temporal;
import javax.persistence.Transient;
import org.java_websocket.WebSocket;

/**
 * @author ismd
 */
@Entity
public class User implements Serializable {

    @Transient
    private Character currentCharacter;

    @Transient
    private WebSocket ws;

    @Expose @Transient
    private List<Character> characters;

    @Id @GeneratedValue(strategy = GenerationType.AUTO) @Expose
    private int id;
    @Expose
    private String login;
    private String password;
    @Expose
    private String email;
    @Expose
    private String info;
    @Expose
    private String site;
    @Expose @Temporal(javax.persistence.TemporalType.TIMESTAMP)
    private Date registered;
    @Expose
    private String authKey;

    public User() {
    }

    public Character getCurrentCharacter() {
        return currentCharacter;
    }

    public boolean setCurrentCharacter(Character character) {
        for (Character c : getCharacters()) {
            if (c.getId() == character.getId()) {
                currentCharacter = character;
                return true;
            }
        }

        return false;
    }

    public WebSocket getWebSocket() {
        return ws;
    }

    public User setWebSocket(WebSocket ws) {
        this.ws = ws;
        return this;
    }

    public List<Character> getCharacters() {
        if (null == characters) {
            characters = new ArrayList<>();

            for (Character character : DaoFactory.getInstance().characterDao.getByIdUser(getId())) {
                character.setUser(this);
                characters.add(character);
            }
        }

        return characters;
    }

    public List<Character> addCharacter(Character character) {
        character.setUser(this);

        characters.add(character);
        return characters;
    }

    // Геттеры

    public int getId() {
        return id;
    }

    public String getLogin() {
        return login;
    }

    public String getPassword() {
        return password;
    }

    public String getEmail() {
        return email;
    }

    public String getInfo() {
        return info;
    }

    public String getSite() {
        return site;
    }

    public Date getRegistered() {
        return registered;
    }

    public String getAuthKey() {
        return authKey;
    }
    
    // Сеттеры
    
    public User setLogin(String login) {
        this.login = login;
        return this;
    }
    
    public User setPassword(String password) {
        this.password = password;
        return this;
    }
    
    public User setEmail(String email) {
        this.email = email;
        return this;
    }
    
    public User setInfo(String info) {
        this.info = info;
        return this;
    }
    
    public User setSite(String site) {
        this.site = site;
        return this;
    }

    public User setRegistered(Date registered) {
        this.registered = registered;
        return this;
    }

    public User setAuthKey(String authKey) {
        this.authKey = authKey;
        return this;
    }
}
