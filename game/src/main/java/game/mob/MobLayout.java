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
public class MobLayout extends CellContent {

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    @Expose
    private long id;
    private long idMob;
    private int idLayout;
    private int x;
    private int y;

    @Transient
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
    private long experience;
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

    public MobLayout() {
    }

    public MobLayout(Mob mob) {
        setIdMob(mob.getId());

        setHp(mob.getMaxHp());
        setTitle(mob.getName());
        setLevel(mob.getLevel());
        setMaxHp(mob.getMaxHp());
        setMinDamage(mob.getMinDamage());
        setMaxDamage(mob.getMaxDamage());
        setExperience(mob.getExperience());
        setImage(mob.getImage());
        setStrength(mob.getStrength());
        setDexterity(mob.getDexterity());
        setEndurance(mob.getEndurance());
    }

    public MobLayout(Mob mob, Cell cell) {
        this(mob);

        setIdLayout(cell.getLayout().getId());
        setX(cell.getX());
        setY(cell.getY());

        setCell(cell);
    }

    public long getId() {
        return id;
    }

    public MobLayout setId(long id) {
        this.id = id;
        return this;
    }

    public long getIdMob() {
        return idMob;
    }

    public MobLayout setIdMob(long idMob) {
        this.idMob = idMob;
        return this;
    }

    public int getIdLayout() {
        return idLayout;
    }

    public MobLayout setIdLayout(int idLayout) {
        this.idLayout = idLayout;
        return this;
    }

    public int getX() {
        return x;
    }

    public MobLayout setX(int x) {
        this.x = x;
        return this;
    }

    public int getY() {
        return y;
    }

    public MobLayout setY(int y) {
        this.y = y;
        return this;
    }

    public int getHp() {
        return hp;
    }

    public MobLayout setHp(int hp) {
        this.hp = hp;
        return this;
    }

    public String getTitle() {
        return name;
    }

    public MobLayout setTitle(String title) {
        this.name = title;
        return this;
    }

    public int getLevel() {
        return level;
    }

    public MobLayout setLevel(int level) {
        this.level = level;
        return this;
    }

    public int getMaxHp() {
        return maxHp;
    }

    public MobLayout setMaxHp(int maxHp) {
        this.maxHp = maxHp;
        return this;
    }

    public int getMinDamage() {
        return minDamage;
    }

    public MobLayout setMinDamage(int minDamage) {
        this.minDamage = minDamage;
        return this;
    }

    public int getMaxDamage() {
        return maxDamage;
    }

    public MobLayout setMaxDamage(int maxDamage) {
        this.maxDamage = maxDamage;
        return this;
    }

    public long getExperience() {
        return experience;
    }

    public MobLayout setExperience(long experience) {
        this.experience = experience;
        return this;
    }

    public String getImage() {
        return image;
    }

    public MobLayout setImage(String image) {
        this.image = image;
        return this;
    }

    public int getStrength() {
        return strength;
    }

    public MobLayout setStrength(int strength) {
        this.strength = strength;
        return this;
    }

    public int getDexterity() {
        return dexterity;
    }

    public MobLayout setDexterity(int dexterity) {
        this.dexterity = dexterity;
        return this;
    }

    public int getEndurance() {
        return endurance;
    }

    public MobLayout setEndurance(int endurance) {
        this.endurance = endurance;
        return this;
    }
}
