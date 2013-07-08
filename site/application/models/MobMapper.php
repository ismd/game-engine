<?php
/**
 * Модель моба
 * @author ismd
 */

class MobNotFoundException extends Exception {
    protected $message = 'Моб не найден';
};

class MobMapper extends PsDbMapper {

    /**
     * Возвращает моба по id из таблицы MobLayout
     * @param int $id
     * @return Mob
     * @throws MobNotFoundException
     */
    public function getById($id) {
        $id = (int)$id;

        $query = $this->db->query("SELECT mm.id, mm.idLayout, "
            . "mm.x, mm.y, mm.hp, "
            . "m.id as idMob, m.name, m.lvl, m.maxHp, m.minDamage, "
            . "m.maxDamage, m.experience, m.image, m.strength, "
            . "m.dexterity, m.endurance "
            . "FROM MobLayout mm "
            . "INNER JOIN Mob m ON mm.idMob = m.id "
            . "LIMIT 1");

        if ($query->num_rows == 0) {
            throw new MobNotFoundException;
        }

        return new Mob($query->fetch_assoc());
    }

    /**
     * Возвращает мобов на клетке
     * @param Cell $cell
     * @return Mob[]
     */
    public function getByCell(Cell $cell) {
        $query = $this->db->query("SELECT mm.id, mm.idLayout, mm.x, "
            . "mm.y, mm.hp, m.id as idMob, "
            . "m.name, m.lvl, m.maxHp, m.minDamage, m.maxDamage, "
            . "m.experience, m.image, m.strength, "
            . "m.dexterity, m.endurance "
            . "FROM MobLayout mm "
            . "INNER JOIN Mob m ON mm.idMob = m.id "
            . "WHERE mm.idLayout = " . $cell->getLayout()->getId() . " AND mm.x = " . $cell->getX()
            . "AND mm.y = " . $cell->getY());

        $mobs = array();
        while ($mob = $query->fetch_assoc()) {
            $mobs[] = new Mob($mob);
        }

        return $mobs;
    }
}
