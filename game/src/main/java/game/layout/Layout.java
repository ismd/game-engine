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

    public Cell getCell(int x, int y) throws BadCoordinatesException {
        try {
            return cells[y][x];
        } catch (ArrayIndexOutOfBoundsException e) {
            throw new BadCoordinatesException();
        }
    }

    public final Layout setCells(int[][][] layout) {
        cells = new Cell[layout.length][];

        for (int i = 0; i < layout.length; i++) {
            cells[i] = new Cell[layout[i].length];

            for (int j = 0; j < layout[i].length; j++) {
                cells[i][j] = new Cell(this, j, i, new SpriteCoordinate(layout[i][j][0], layout[i][j][1]));
            }
        }

        for (int i = 0; i < cells.length; i++) {
            for (int j = 0; j < cells[i].length; j++) {
                cells[i][j].setVicinity(getVicinity(cells[i][j]));
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

    public SpriteCoordinate[][] getVicinity(Cell cell) {
        SpriteCoordinate[][] vicinity = new SpriteCoordinate[7][5];

        int x = cell.getX();
        int y = cell.getY();

        for (int i = 0; i < 7; i++) {
            for (int j = 0; j < 5; j++) {
                try {
                    vicinity[i][j] = getCell(x + i - 3, y + j - 2).getSpriteCoordinate();
                } catch (BadCoordinatesException ex) {
                    vicinity[i][j] = null;
                }
            }
        }

        return vicinity;
    }
}
