<?php
/**
 * Модель моба
 *
 * @author ismd
 */

class MobMapperNotFoundException extends Exception {};

class MobMapper extends AbstractDbMapper {

    /**
     * Возвращает моба по id из таблицы MobMap
     *
     * @param int $id
     * @return Mob
     * @throws MobMapperNotFoundException
     */
    public function getById($id) {
        $id = (int)$id;

        $query = $this->db->query("SELECT mm.id, mm.idMap, "
            . "mm.coordinateX, mm.coordinateY, mm.hp, "
            . "m.id as idMob, m.name, m.level, m.maxHp, m.minDamage, "
            . "m.maxDamage, m.experience, m.image, m.strength, "
            . "m.dexterity, m.endurance "
            . "FROM MobMap mm "
            . "INNER JOIN Mob m ON mm.idMob = m.id "
            . "LIMIT 1");

        if ($query->num_rows == 0) {
            throw new MobMapperNotFoundException;
        }

        return new Mob($query->fetch_assoc());
    }

    /**
     * Возвращает мобов на клетке
     *
     * @param MapCell $cell
     * @return array Массив объектов класса Mob
     */
    public function getByCell(MapCell $cell) {
        $query = $this->db->query("SELECT mm.id, mm.idMap, mm.coordinateX, "
            . "mm.coordinateY, mm.hp, m.id as idMob, "
            . "m.name, m.level, m.maxHp, m.minDamage, m.maxDamage, "
            . "m.experience, m.image, m.strength, "
            . "m.dexterity, m.endurance "
            . "FROM MobMap mm "
            . "INNER JOIN Mob m ON mm.idMob = m.id "
            . "WHERE mm.idMap = $cell->idMap AND mm.coordinateX = $cell->x "
            . "AND mm.coordinateY = $cell->y");

        $mobs = array();
        while ($mob = $query->fetch_assoc()) {
            $mobs[] = new Mob($mob);
        }

        return $mobs;
    }
}
