package game.layout;

import com.google.gson.annotations.Expose;

/**
 * @author ismd
 */
public class SpriteCoordinate {

    @Expose
    private final int x;
    @Expose
    private final int y;

    SpriteCoordinate(int x, int y) {
        this.x = x;
        this.y = y;
    }

    public int getX() {
        return x;
    }

    public int getY() {
        return y;
    }
}
