package game.npc;

import com.google.gson.annotations.Expose;
import game.layout.CellContent;
import java.io.Serializable;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;

/**
 * @author ismd
 */
@Entity
public class Npc extends CellContent implements Serializable {

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    @Expose
    private int id;
    @Expose
    private String name;
    @Expose
    private String greeting;
    @Expose
    private String image;
    private int idLayout;
    private int x;
    private int y;

    public Npc() {
    }

    // Геттеры

    public int getId() {
        return id;
    }

    public String getName() {
        return name;
    }

    public String getGreeting() {
        return greeting;
    }

    public String getImage() {
        return image;
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

    public Npc setIdLayout(int idLayout) {
        this.idLayout = idLayout;
        return this;
    }

    public Npc setX(int x) {
        this.x = x;
        return this;
    }

    public Npc setY(int y) {
        this.y = y;
        return this;
    }
}
