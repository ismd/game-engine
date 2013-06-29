package game.world;

import game.world.exceptions.BadCoordinatesException;

/**
 * @author ismd
 */
public class Layout {

    private Cell[][] cells; // Значения хранятся как [y, x]

    Layout(int[][] map) {
        cells = new Cell[map.length][];

        for (int i = 0; i < map.length; i++) {
            cells[i] = new Cell[map[i].length];

            for (int j = 0; j < map[i].length; j++) {
                cells[i][j] = new Cell(CellType.getById(map[i][j]));
            }
        }
    }

    public Cell getCell(int x, int y) throws BadCoordinatesException {
        try {
            return cells[y][x];
        } catch (ArrayIndexOutOfBoundsException e) {
            throw new BadCoordinatesException();
        }
    }
}
