package game.mob;

import com.google.gson.annotations.Expose;
import game.layout.Cell;
import game.layout.CellContent;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.Transient;

/**
 * Конкретный моб на карте
 * @author ismd
 */
@Entity
public class Mob extends CellContent {

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    @Expose
    private int id;
    private int idMob;
    private int idLayout;
    private int x;
    private int y;
    @Expose
    private int hp;

    @Transient
    @Expose
    private String name;
    @Transient
    @Expose
    private int level;
    @Transient
    @Expose
    private int maxHp;
    @Transient
    @Expose
    private int minDamage;
    @Transient
    @Expose
    private int maxDamage;
    @Transient
    @Expose
    private int experience;
    @Transient
    @Expose
    private String image;
    @Transient
    @Expose
    private int strength;
    @Transient
    @Expose
    private int dexterity;
    @Transient
    @Expose
    private int endurance;

    public Mob() {
    }

    public Mob(MobInfo mob) {
        idMob = mob.getId();

        setHp(mob.getMaxHp());
        name = mob.getName();
        level = mob.getLevel();
        maxHp = mob.getMaxHp();
        minDamage = mob.getMinDamage();
        maxDamage = mob.getMaxDamage();
        experience = mob.getExperience();
        image = mob.getImage();
        strength = mob.getStrength();
        dexterity = mob.getDexterity();
        endurance = mob.getEndurance();
    }

    public Mob(MobInfo mob, Cell cell) {
        this(mob);

        idLayout = cell.getLayout().getId();
        x = cell.getX();
        y = cell.getY();

        setCell(cell);
    }

    public int getId() {
        return id;
    }

    public int getIdMob() {
        return idMob;
    }

    public int getHp() {
        return hp;
    }

    public final Mob setHp(int hp) {
        this.hp = hp;
        return this;
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

    public int getExperience() {
        return experience;
    }

    public String getImage() {
        return image;
    }

    public int getStrength() {
        return strength;
    }

    public int getDexterity() {
        return dexterity;
    }

    public int getEndurance() {
        return endurance;
    }

    public Mob setIdLayout(int idLayout) {
        this.idLayout = idLayout;
        return this;
    }

    public Mob setX(int x) {
        this.x = x;
        return this;
    }

    public Mob setY(int y) {
        this.y = y;
        return this;
    }
}
