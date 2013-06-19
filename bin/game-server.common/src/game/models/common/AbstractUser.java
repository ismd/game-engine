package game.models.common;

/**
 * @author ismd
 */
public class AbstractUser {

    private int _id;
    private String _login;
    private String _password;
    private String _password1;
    private String _email;
    private String _info;
    private String _site;
    private String _registered;

    public int getId() {
        return _id;
    }

    public AbstractUser setId(int id) {
        this._id = id;
        return this;
    }

    public String getLogin() {
        return _login;
    }

    public AbstractUser setLogin(String login) {
        this._login = login;
        return this;
    }

    public String getPassword() {
        return _password;
    }

    public AbstractUser setPassword(String password) {
        this._password = password;
        return this;
    }

    public String getPassword1() {
        return _password1;
    }

    public AbstractUser setPassword1(String password1) {
        this._password1 = password1;
        return this;
    }

    public String getEmail() {
        return _email;
    }

    public AbstractUser setEmail(String email) {
        this._email = email;
        return this;
    }

    public String getInfo() {
        return _info;
    }

    public AbstractUser setInfo(String info) {
        this._info = info;
        return this;
    }

    public String getSite() {
        return _site;
    }

    public AbstractUser setSite(String site) {
        this._site = site;
        return this;
    }

    public String getRegistered() {
        return _registered;
    }

    public AbstractUser setRegistered(String registered) {
        this._registered = registered;
        return this;
    }
}
