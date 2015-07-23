package game.dao;

import game.mob.MobAvailableCell;

/**
 * @author ismd
 */
public class MobAvailableCellDao extends Dao {

    public MobAvailableCellDao() {
    }

    public MobAvailableCell getById(int id) {
        return (MobAvailableCell)getById(MobAvailableCell.class, id);
    }
}
