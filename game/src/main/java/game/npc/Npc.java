package game.npc;

import game.layout.CellContent;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;

/**
 * @author ismd
 */
@Entity
public class Npc extends CellContent {

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private int id;
    private String name;
    private String greeting;
    private String image;
    private int idLayout;
    private int x;
    private int y;

    public Npc() {
    }

    public int getId() {
        return id;
    }

    public Npc setId(int id) {
        this.id = id;
        return this;
    }

    public String getName() {
        return name;
    }

    public Npc setName(String name) {
        this.name = name;
        return this;
    }

    public String getGreeting() {
        return greeting;
    }

    public Npc setGreeting(String greeting) {
        this.greeting = greeting;
        return this;
    }

    public String getImage() {
        return image;
    }

    public Npc setImage(String image) {
        this.image = image;
        return this;
    }

    public int getIdLayout() {
        return idLayout;
    }

    public Npc setIdLayout(int idLayout) {
        this.idLayout = idLayout;
        return this;
    }

    public int getX() {
        return x;
    }

    public Npc setX(int x) {
        this.x = x;
        return this;
    }

    public int getY() {
        return y;
    }

    public Npc setY(int y) {
        this.y = y;
        return this;
    }
}
