package game.mob;

import java.io.Serializable;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;

/**
 * @author ismd
 */
@Entity
public class MobInfo implements Serializable {

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private int id;
    private String name;
    private int level;
    private int maxHp;
    private int minDamage;
    private int maxDamage;
    private int maxInWorld;
    private int experience;
    private String image;
    private int strength;
    private int dexterity;
    private int endurance;

    public int getId() {
        return id;
    }

    public MobInfo setId(int id) {
        this.id = id;
        return this;
    }

    public String getName() {
        return name;
    }

    public MobInfo setName(String name) {
        this.name = name;
        return this;
    }

    public int getLevel() {
        return level;
    }

    public MobInfo setLevel(int level) {
        this.level = level;
        return this;
    }

    public int getMaxHp() {
        return maxHp;
    }

    public MobInfo setMaxHp(int maxHp) {
        this.maxHp = maxHp;
        return this;
    }

    public int getMinDamage() {
        return minDamage;
    }

    public MobInfo setMinDamage(int minDamage) {
        this.minDamage = minDamage;
        return this;
    }

    public int getMaxDamage() {
        return maxDamage;
    }

    public MobInfo setMaxDamage(int maxDamage) {
        this.maxDamage = maxDamage;
        return this;
    }

    public int getMaxInWorld() {
        return maxInWorld;
    }

    public MobInfo setMaxInWorld(int maxInWorld) {
        this.maxInWorld = maxInWorld;
        return this;
    }

    public int getExperience() {
        return experience;
    }

    public MobInfo setExperience(int experience) {
        this.experience = experience;
        return this;
    }

    public String getImage() {
        return image;
    }

    public MobInfo setImage(String image) {
        this.image = image;
        return this;
    }

    public int getStrength() {
        return strength;
    }

    public MobInfo setStrength(int strength) {
        this.strength = strength;
        return this;
    }

    public int getDexterity() {
        return dexterity;
    }

    public MobInfo setDexterity(int dexterity) {
        this.dexterity = dexterity;
        return this;
    }

    public int getEndurance() {
        return endurance;
    }

    public MobInfo setEndurance(int endurance) {
        this.endurance = endurance;
        return this;
    }
}
