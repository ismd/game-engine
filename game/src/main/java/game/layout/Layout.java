package game.layout;

import game.world.exceptions.BadCoordinatesException;
import java.io.Serializable;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.Transient;

/**
 * @author ismd
 */
@Entity
public class Layout implements Serializable {

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private int id;

    private String title;

    @Transient
    private Cell[][] cells; // Значения хранятся как [y, x]

    public Layout() {
    }

    public Layout(int[][] layout) {
        setCells(layout);
    }

    public Cell getCell(int x, int y) throws BadCoordinatesException {
        try {
            return cells[y][x];
        } catch (ArrayIndexOutOfBoundsException e) {
            throw new BadCoordinatesException();
        }
    }

    public final Layout setCells(int[][] layout) {
        cells = new Cell[layout.length][];

        for (int i = 0; i < layout.length; i++) {
            cells[i] = new Cell[layout[i].length];

            for (int j = 0; j < layout[i].length; j++) {
                cells[i][j] = new Cell(this, CellType.getById(layout[i][j]), j, i);
            }
        }

        return this;
    }

    public int getId() {
        return id;
    }

    public String getTitle() {
        return title;
    }

    public Layout setTitle(String title) {
        this.title = title;
        return this;
    }

    /*public Map<int, Map<int, int>> getVicinity(Cell cell) {
        
    }*/
}
