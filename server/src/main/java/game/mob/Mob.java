package game.mob;

import com.google.gson.annotations.Expose;
import game.fight.FightMember;
import game.layout.Cell;
import java.io.Serializable;

/**
 * Конкретный моб на карте
 * @author ismd
 */
public class Mob extends FightMember implements Serializable {

    @Expose
    MobInfo mobInfo;

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

    public Mob(int id, MobInfo mob) {
        this.id = id;
        idMob = mob.getId();
        hp = mob.getMaxHp();
        mobInfo = mob;
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

    public String getName() {
        return mobInfo.getName();
    }

    public MobInfo getMobInfo() {
        return mobInfo;
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

