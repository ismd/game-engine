package game.layout;

import com.google.gson.annotations.Expose;

/**
 * @author ismd
 */
public class SpriteCoordinate {

    @Expose
    private int x;
    @Expose
    private int y;

    SpriteCoordinate(int x, int y) {
        this.x = x;
        this.y = y;
    }
}
