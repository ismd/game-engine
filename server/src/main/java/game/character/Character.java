package game.character;

import com.google.gson.annotations.Expose;
import game.layout.CellContent;
import game.user.User;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.Transient;

/**
 * @author ismd
 */
@Entity
public class Character extends CellContent {

    @Transient
    private User user;

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    @Expose
    private int id;
    @Expose
    private int idUser;
    @Expose
    private String name;
    @Expose
    private int level;
    @Expose
    private int money;
    @Expose
    private int idLayout;
    @Expose
    private int x;
    @Expose
    private int y;
    @Expose
    private int strength;
    @Expose
    private int dexterity;
    @Expose
    private int endurance;
    @Expose
    private int hp;
    @Expose
    private int maxHp;
    @Expose
    private int minDamage;
    @Expose
    private int maxDamage;
    @Expose
    private String image;
    @Expose
    private int experience;

    public Character() {
    }

    public User getUser() {
        return user;
    }

    public Character setUser(User user) {
        this.user = user;
        return this;
    }

    public int getId() {
        return id;
    }

    public String getName() {
        return name;
    }

    public Character setName(String name) {
        this.name = name;
        return this;
    }

    public int getIdUser() {
        return idUser;
    }

    public Character setIdUser(int idUser) {
        this.idUser = idUser;
        return this;
    }

    public int getLevel() {
        return level;
    }

    public Character setLevel(int level) {
        this.level = level;
        return this;
    }

    public int getMoney() {
        return money;
    }

    public Character setMoney(int money) {
        this.money = money;
        return this;
    }

    public int getStrength() {
        return strength;
    }

    public Character setStrength(int strength) {
        this.strength = strength;
        return this;
    }

    public int getDexterity() {
        return dexterity;
    }

    public Character setDexterity(int dexterity) {
        this.dexterity = dexterity;
        return this;
    }

    public int getEndurance() {
        return endurance;
    }

    public Character setEndurance(int endurance) {
        this.endurance = endurance;
        return this;
    }

    public int getHp() {
        return hp;
    }

    public Character setHp(int hp) {
        this.hp = hp;
        return this;
    }

    public int getMaxHp() {
        return maxHp;
    }

    public Character setMaxHp(int maxHp) {
        this.maxHp = maxHp;
        return this;
    }

    public int getMinDamage() {
        return minDamage;
    }

    public Character setMinDamage(int minDamage) {
        this.minDamage = minDamage;
        return this;
    }

    public int getMaxDamage() {
        return maxDamage;
    }

    public Character setMaxDamage(int maxDamage) {
        this.maxDamage = maxDamage;
        return this;
    }

    public String getImage() {
        return image;
    }

    public Character setImage(String image) {
        this.image = image;
        return this;
    }

    public int getExperience() {
        return experience;
    }

    public Character setExperience(int experience) {
        this.experience = experience;
        return this;
    }

    public Character setIdLayout(int idLayout) {
        this.idLayout = idLayout;
        return this;
    }

    public int getIdLayout() {
        return idLayout;
    }

    public Character setX(int x) {
        this.x = x;
        return this;
    }

    public int getX() {
        return x;
    }

    public Character setY(int y) {
        this.y = y;
        return this;
    }

    public int getY() {
        return y;
    }
}
