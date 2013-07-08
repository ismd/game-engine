package game.user;

import java.sql.Timestamp;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.Temporal;
import javax.persistence.TemporalType;

/**
 * @author ismd
 */
@Entity
public class User {

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private long id;
    private String login;
    private String email;
    private String info;
    private String site;
//    @Temporal(TemporalType.TIMESTAMP)
//    private Timestamp registered;
    private String authKey;

    public User() {
    }

    public long getId() {
        return id;
    }

    public User setId(long id) {
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

//    public Timestamp getRegistered() {
//        return registered;
//    }
//
//    public User setRegistered(Timestamp registered) {
//        this.registered = registered;
//        return this;
//    }

    public String getAuthKey() {
        return authKey;
    }

    public User setAuthKey(String authKey) {
        this.authKey = authKey;
        return this;
    }
}
