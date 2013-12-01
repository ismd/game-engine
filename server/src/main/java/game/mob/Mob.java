package game.mob;

import com.google.gson.annotations.Expose;
import game.layout.Cell;
import game.layout.CellContent;
import java.io.Serializable;
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
public class Mob extends CellContent implements Serializable {

    @Expose @Transient
    MobInfo mobInfo;

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

    protected Mob() {
    }

    public Mob(MobInfo mob) {
        idMob = mob.getId();
        hp = mob.getMaxHp();
        mobInfo = mob;
    }

    public Mob(MobInfo mob, Cell cell) {
        this(mob);
        setCell(cell);
    }

    // Геттеры

    public int getId() {
        return id;
    }

    public int getIdMob() {
        return idMob;
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

    public int getHp() {
        return hp;
    }

    // Сеттеры

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

    public Mob setHp(int hp) {
        this.hp = hp;
        return this;
    }
}

