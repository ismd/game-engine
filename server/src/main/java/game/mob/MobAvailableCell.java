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
public class MobAvailableCell implements Serializable {

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private int id;
    private int idMob;
    private int idLayout;
    private int x;
    private int y;
    
    public MobAvailableCell() {
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

    // Сеттеры

    public MobAvailableCell setIdMob(int idMob) {
        this.idMob = idMob;
        return this;
    }

    public MobAvailableCell setIdLayout(int idLayout) {
        this.idLayout = idLayout;
        return this;
    }

    public MobAvailableCell setX(int x) {
        this.x = x;
        return this;
    }

    public MobAvailableCell setY(int y) {
        this.y = y;
        return this;
    }
}
