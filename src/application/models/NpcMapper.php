<?php
/**
 * Модель NPC
 *
 * @author ismd
 */

class NpcMapper {

    /**
     * Возвращает NPC по id из таблицы NpcMap
     *
     * @param int $id
     */
    public function getById($id) {
        $id = (int)$id;

        $result = mysql_query("SELECT NpcMap.id, NpcMap.idMap, NpcMap.coordinateX, NpcMap.coordinateY, Npc.id as idNpc, "
                            . "Npc.name, Npc.greeting Npc.image "
                            . "FROM NpcMap INNER JOIN Npc ON NpcMap.idNpc=Npc.id LIMIT 1");

        if (mysql_num_rows($result) == 0) {
            return null;
        }

        return new Npc(mysql_fetch_assoc($result));
    }

    /**
     * Возвращает NPC на клетке
     *
     * @param int $idMap
     * @param int $x
     * @param int $y
     * @return array Массив NPC
     */
    public function getOnCell($idMap, $x, $y) {
        $idMap   = (int)$idMap;
        $x       = (int)$x;
        $y       = (int)$y;

        $query = mysql_query("SELECT NpcMap.id, NpcMap.idMap, NpcMap.coordinateX, NpcMap.coordinateY, Npc.id as idNpc, "
                           . "Npc.name, Npc.greeting, Npc.image "
                           . "FROM NpcMap INNER JOIN Npc ON NpcMap.idNpc=Npc.id "
                           . "WHERE idMap=$idMap AND coordinateX=$x AND coordinateY=$y");

        $npcs = array();
        while ($npc = mysql_fetch_assoc($query)) {
            $npcs[] = new Npc($npc);
        }

        return $npcs;
    }
}
