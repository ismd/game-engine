package game.fight;

import game.layout.CellContent;

abstract public class FightMember extends CellContent {

    abstract public String getName();
    abstract public int getHp();

    abstract public FightMember setHp(int hp);

    protected Fight fight;

    public Fight getFight() {
        return fight;
    }

    public FightMember setFight(Fight fight) {
        this.fight = fight;
        return this;
    }
}
