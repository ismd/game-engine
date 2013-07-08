package game.character;

import game.layout.CellContent;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;

/**
 * @author ismd
 */
@Entity
public class UserCharacter extends CellContent {

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private int id;
    private long idUser;
    private String name;
    private int lvl;
    private long money;
    private int idLayout;
    private int x;
    private int y;
    private int strength;
    private int dexterity;
    private int endurance;
    private int hp;
    private int maxHp;
    private int minDamage;
    private int maxDamage;
    private String image;
    private long experience;

    public UserCharacter() {
    }

    public long getId() {
        return id;
    }

    public String getName() {
        return name;
    }

    public UserCharacter setName(String name) {
        this.name = name;
        return this;
    }

    public long getIdUser() {
        return idUser;
    }

    public UserCharacter setIdUser(long idUser) {
        this.idUser = idUser;
        return this;
    }

    public int getLevel() {
        return lvl;
    }

    public UserCharacter setLevel(int level) {
        this.lvl = level;
        return this;
    }

    public long getMoney() {
        return money;
    }

    public UserCharacter setMoney(long money) {
        this.money = money;
        return this;
    }

    public int getIdLayout() {
        return idLayout;
    }

    public UserCharacter setIdLayout(int idLayout) {
        this.idLayout = idLayout;
        return this;
    }

    public int getX() {
        return x;
    }

    public UserCharacter setX(int x) {
        this.x = x;
        return this;
    }

    public int getY() {
        return y;
    }

    public UserCharacter setY(int y) {
        this.y = y;
        return this;
    }

    public int getStrength() {
        return strength;
    }

    public UserCharacter setStrength(int strength) {
        this.strength = strength;
        return this;
    }

    public int getDexterity() {
        return dexterity;
    }

    public UserCharacter setDexterity(int dexterity) {
        this.dexterity = dexterity;
        return this;
    }

    public int getEndurance() {
        return endurance;
    }

    public UserCharacter setEndurance(int endurance) {
        this.endurance = endurance;
        return this;
    }

    public int getHp() {
        return hp;
    }

    public UserCharacter setHp(int hp) {
        this.hp = hp;
        return this;
    }

    public int getMaxHp() {
        return maxHp;
    }

    public UserCharacter setMaxHp(int maxHp) {
        this.maxHp = maxHp;
        return this;
    }

    public int getMinDamage() {
        return minDamage;
    }

    public UserCharacter setMinDamage(int minDamage) {
        this.minDamage = minDamage;
        return this;
    }

    public int getMaxDamage() {
        return maxDamage;
    }

    public UserCharacter setMaxDamage(int maxDamage) {
        this.maxDamage = maxDamage;
        return this;
    }

    public String getImage() {
        return image;
    }

    public UserCharacter setImage(String image) {
        this.image = image;
        return this;
    }

    public long getExperience() {
        return experience;
    }

    public UserCharacter setExperience(long experience) {
        this.experience = experience;
        return this;
    }
}
