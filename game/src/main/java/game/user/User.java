package game.user;

import com.google.gson.annotations.Expose;
import game.character.Character;
import game.dao.DaoFactory;
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
public class User {

    @Transient
    private Character currentCharacter;

    @Transient
    private WebSocket ws;

    @Expose
    @Transient
    private List<Character> characters;

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    @Expose
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
    @Temporal(javax.persistence.TemporalType.DATE)
    private Date registered;
    @Expose
    private String authKey;

    public User() {
    }

    public Character getCurrentCharacter() {
        return currentCharacter;
    }

    public User setCurrentCharacter(Character character) {
        for (Character c : getCharacters()) {
            if (c.getId() == character.getId()) {
                currentCharacter = character;
                return this;
            }
        }

        return null;
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

            for (Character character : DaoFactory.getInstance().getCharacterDao().getByIdUser(getId())) {
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

    public int getId() {
        return id;
    }

    public User setId(int id) {
        this.id = id;
        return this;
    }

    public String getLogin() {
        return login;
    }

    public User setLogin(String login) {
        this.login = login;
        return this;
    }

    public String getPassword() {
        return password;
    }

    public User setPassword(String password) {
        this.password = password;
        return this;
    }

    public String getEmail() {
        return email;
    }

    public User setEmail(String email) {
        this.email = email;
        return this;
    }

    public String getInfo() {
        return info;
    }

    public User setInfo(String info) {
        this.info = info;
        return this;
    }

    public String getSite() {
        return site;
    }

    public User setSite(String site) {
        this.site = site;
        return this;
    }

    public Date getRegistered() {
        return registered;
    }

    public User setRegistered(Date registered) {
        this.registered = registered;
        return this;
    }

    public String getAuthKey() {
        return authKey;
    }

    public User setAuthKey(String authKey) {
        this.authKey = authKey;
        return this;
    }
}
