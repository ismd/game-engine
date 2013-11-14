package game.user;

import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;

/**
 * @author ismd
 */
@Entity
public class User {

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    protected int id;
    protected String login;
    protected String password;
    protected String email;
    protected String info;
    protected String site;
//    @Temporal(TemporalType.TIMESTAMP)
//    private Timestamp registered;

    public User() {
    }

    public User(User user) {
        id = user.getId();
        login = user.getLogin();
        email = user.getEmail();
        info = user.getInfo();
        site = user.getSite();
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

//    public Timestamp getRegistered() {
//        return registered;
//    }
//
//    public User setRegistered(Timestamp registered) {
//        this.registered = registered;
//        return this;
//    }
}
