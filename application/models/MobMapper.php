<?php
/**
 * Модель моба
 *
 * @author ismd
 */

class MobMapper {

    /**
     * Возвращает моба по id из таблицы MobMap
     *
     * @param int $id
     */
    public function getById($id) {
        $id = (int)$id;

        $query = mysql_query("SELECT MobMap.id, MobMap.idMap, MobMap.coordinateX, MobMap.coordinateY, MobMap.hp, Mob.id as idMob, "
                           . "Mob.name, Mob.level, Mob.maxHp, Mob.minDamage, Mob.maxDamage, Mob.experience, Mob.image, Mob.strength, "
                           . "Mob.dexterity, Mob.endurance "
                           . "FROM MobMap INNER JOIN Mob ON MobMap.idMob=Mob.id LIMIT 1");

        if (mysql_num_rows($query) == 0) {
            return null;
        }

        return new Mob(mysql_fetch_assoc($query));
    }

    /**
     * Возвращает мобов на клетке
     *
     * @param int $idMap
     * @param int $x
     * @param int $y
     * @return array Массив мобов
     */
    public function getOnCell($idMap, $x, $y) {
        $idMap   = (int)$idMap;
        $x       = (int)$x;
        $y       = (int)$y;

        $query = mysql_query("SELECT MobMap.id, MobMap.idMap, MobMap.coordinateX, MobMap.coordinateY, MobMap.hp, Mob.id as idMob, "
                           . "Mob.name, Mob.level, Mob.maxHp, Mob.minDamage, Mob.maxDamage, Mob.experience, Mob.image, Mob.strength, "
                           . "Mob.dexterity, Mob.endurance "
                           . "FROM MobMap INNER JOIN Mob ON MobMap.idMob=Mob.id "
                           . "WHERE idMap=$idMap AND coordinateX=$x AND coordinateY=$y");

        $mobs = array();
        while ($mob = mysql_fetch_assoc($query)) {
            $mobs[] = new Mob($mob);
        }

        return $mobs;
    }
}
