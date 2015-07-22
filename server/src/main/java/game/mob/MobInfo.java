package game.mob;

import com.google.gson.annotations.Expose;
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

    @Id @GeneratedValue(strategy=GenerationType.AUTO)
    private int id;
    @Expose
    private String name;
    private int level;
    @Expose
    private int maxHp;
    private int minDamage;
    private int maxDamage;
    private int maxInWorld;
    private int experience;
    @Expose
    private String image;

    public MobInfo() {
    }

    // Геттеры

    public int getId() {
        return id;
    }

    public String getName() {
        return name;
    }

    public int getLevel() {
        return level;
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

    public int getMaxInWorld() {
        return maxInWorld;
    }

    public int getExperience() {
        return experience;
    }

    public String getImage() {
        return image;
    }

    // Сеттеры

    public MobInfo setName(String name) {
        this.name = name;
        return this;
    }

    public MobInfo setLevel(int level) {
        this.level = level;
        return this;
    }

    public MobInfo setMaxHp(int maxHp) {
        this.maxHp = maxHp;
        return this;
    }

    public MobInfo setMinDamage(int minDamage) {
        this.minDamage = minDamage;
        return this;
    }

    public MobInfo setMaxDamage(int maxDamage) {
        this.maxDamage = maxDamage;
        return this;
    }

    public MobInfo setMaxInWorld(int maxInWorld) {
        this.maxInWorld = maxInWorld;
        return this;
    }

    public MobInfo setExperience(int experience) {
        this.experience = experience;
        return this;
    }

    public MobInfo setImage(String image) {
        this.image = image;
        return this;
    }
}
