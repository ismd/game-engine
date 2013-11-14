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
     * Возвращает конкретного моба по id из таблицы Mob
     * @param int $id
     * @return Mob
     * @throws MobNotFoundException
     */
    public function getById($id) {
        $id = (int)$id;

        $query = $this->db->query("SELECT m.id, m.idLayout, "
            . "m.x, m.y, m.hp, m.idMob, "
            . "mi.name, m.level, mi.maxHp, mi.minDamage, "
            . "mi.maxDamage, mi.experience, mi.image, mi.strength, "
            . "mi.dexterity, mi.endurance "
            . "FROM Mob m "
            . "INNER JOIN MobInfo mi ON m.idMob = mi.id "
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
        $query = $this->db->query("SELECT m.id, m.idLayout, m.x, "
            . "m.y, m.hp, m.idMob, "
            . "mi.name, mi.level, mi.maxHp, mi.minDamage, mi.maxDamage, "
            . "mi.experience, mi.image, mi.strength, "
            . "mi.dexterity, mi.endurance "
            . "FROM Mob m "
            . "INNER JOIN MobInfo mi ON m.idMob = mi.id "
            . "WHERE m.idLayout = " . $cell->getLayout()->getId() . " AND m.x = " . $cell->getX()
            . "AND m.y = " . $cell->getY());

        $mobs = [];
        while ($mob = $query->fetch_assoc()) {
            $mobs[] = new Mob($mob);
        }

        return $mobs;
    }
}
