package game.mob;

import java.io.Serializable;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;

/**
 * Класс доступной мобу клетки
 * @author ismd
 */
@Entity
public class MobCell implements Serializable {

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private long id;
    private long idMob;
    private int idLayout;
    private int x;
    private int y;

    public long getId() {
        return id;
    }

    public MobCell setId(long id) {
        this.id = id;
        return this;
    }

    public long getIdMob() {
        return idMob;
    }

    public MobCell setIdMob(long idMob) {
        this.idMob = idMob;
        return this;
    }

    public int getIdLayout() {
        return idLayout;
    }

    public MobCell setIdLayout(int idLayout) {
        this.idLayout = idLayout;
        return this;
    }

    public int getX() {
        return x;
    }

    public MobCell setX(int x) {
        this.x = x;
        return this;
    }

    public int getY() {
        return y;
    }

    public MobCell setY(int y) {
        this.y = y;
        return this;
    }
}