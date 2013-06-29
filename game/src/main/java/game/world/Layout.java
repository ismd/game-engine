package game.world;

/**
 * @author ismd
 */
public class Layout {

    private Cell[][] cells;

    Layout(int[][] map) {
        cells = new Cell[map.length][];

        for (int i = 0; i < map.length; i++) {
            cells[i] = new Cell[map[i].length];

            for (int j = 0; j < map[i].length; j++) {
                cells[i][j] = new Cell(CellType.getById(map[i][j]));
            }
        }
    }
}
