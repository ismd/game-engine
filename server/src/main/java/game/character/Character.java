package game.character;

import com.google.gson.annotations.Expose;
import game.layout.CellContent;
import game.user.User;
import java.io.Serializable;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.Transient;

/**
 * @author ismd
 */
@Entity
public class Character extends CellContent implements Serializable {

    @Transient
    private User user;

    @Id @GeneratedValue(strategy=GenerationType.AUTO) @Expose
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
    private int speed;
    @Expose
    private int endurance;
    @Expose
    private int perception;
    @Expose
    private int intelligence;
    @Expose
    private int will;
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
    private String biography;
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

    // Геттеры

    public int getId() {
        return id;
    }

    public String getName() {
        return name;
    }

    public int getIdUser() {
        return idUser;
    }

    public int getLevel() {
        return level;
    }

    public int getMoney() {
        return money;
    }

    public int getStrength() {
        return strength;
    }

    public int getSpeed() {
        return speed;
    }

    public int getEndurance() {
        return endurance;
    }

    public int getPerception() {
        return perception;
    }

    public int getIntelligence() {
        return intelligence;
    }

    public int getWill() {
        return will;
    }

    public int getHp() {
        return hp;
    }

    public int getMaxHp() {
        return maxHp;
    }

    public int getMinDamage() {
        return minDamage;
    }

    public int getMaxDamage() {
        return maxDamage;
    }

    public String getImage() {
        return image;
    }

    public String getBiography() {
        return biography;
    }

    public int getExperience() {
        return experience;
    }

    public int getIdLayout() {
        return idLayout;
    }

    public int getX() {
        return x;
    }

    public int getY() {
        return y;
    }

    // Сеттеры

    public Character setName(String name) {
        this.name = name;
        return this;
    }

    public Character setIdUser(int idUser) {
        this.idUser = idUser;
        return this;
    }

    public Character setLevel(int level) {
        this.level = level;
        return this;
    }

    public Character setMoney(int money) {
        this.money = money;
        return this;
    }

    public Character setStrength(int strength) {
        this.strength = strength;
        return this;
    }

    public Character setSpeed(int speed) {
        this.speed = speed;
        return this;
    }

    public Character setEndurance(int endurance) {
        this.endurance = endurance;
        return this;
    }

    public Character setPerception(int perception) {
        this.perception = perception;
        return this;
    }

    public Character setIntelligence(int intelligence) {
        this.intelligence = intelligence;
        return this;
    }

    public Character setWill(int will) {
        this.will = will;
        return this;
    }

    public Character setHp(int hp) {
        this.hp = hp;
        return this;
    }

    public Character setMaxHp(int maxHp) {
        this.maxHp = maxHp;
        return this;
    }

    public Character setMinDamage(int minDamage) {
        this.minDamage = minDamage;
        return this;
    }

    public Character setMaxDamage(int maxDamage) {
        this.maxDamage = maxDamage;
        return this;
    }

    public Character setImage(String image) {
        this.image = image;
        return this;
    }

    public Character setBiography(String biography) {
        this.biography = biography;
        return this;
    }

    public Character setExperience(int experience) {
        this.experience = experience;
        return this;
    }

    public Character setIdLayout(int idLayout) {
        this.idLayout = idLayout;
        return this;
    }

    public Character setX(int x) {
        this.x = x;
        return this;
    }

    public Character setY(int y) {
        this.y = y;
        return this;
    }
}
