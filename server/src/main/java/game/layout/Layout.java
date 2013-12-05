package game.layout;

import com.google.gson.annotations.Expose;
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

    @Id @GeneratedValue(strategy=GenerationType.AUTO) @Expose
    private int id;

    @Expose
    private String title;

    @Transient
    private Cell[][] cells; // Значения хранятся как [y, x]

    @Transient
    private final int cellsHorizontal = 9;
    @Transient
    private final int cellsVertical = 9;

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

        for (Cell[] cell : cells) {
            for (Cell cell1 : cell) {
                cell1.setVicinity(getVicinity(cell1));
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

    private SpriteCoordinate[][] getVicinity(Cell cell) {
        SpriteCoordinate[][] vicinity = new SpriteCoordinate[cellsHorizontal][cellsVertical];

        int x = cell.getX();
        int y = cell.getY();

        for (int i = 0; i < cellsVertical; i++) {
            for (int j = 0; j < cellsHorizontal; j++) {
                try {
                    vicinity[i][j] = getCell(x + i - cellsHorizontal / 2,
                            y + j - cellsVertical / 2).getSpriteCoordinate();
                } catch (BadCoordinatesException e) {
                    vicinity[i][j] = null;
                }
            }
        }

        return vicinity;
    }
}
