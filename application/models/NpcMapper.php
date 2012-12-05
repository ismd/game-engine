<?php
/**
 * Модель NPC
 *
 * @author ismd
 */

class NpcMapperNotFoundException extends Exception {};

class NpcMapper extends AbstractDbMapper {

    /**
     * Возвращает NPC по id из таблицы NpcMap
     *
     * @param int $id
     * @return Npc
     * @throws NpcMapperNotFoundException
     */
    public function getById($id) {
        $id = (int)$id;

        $query = $this->db->query("SELECT nm.id, nm.idMap, nm.coordinateX, "
            . "nm.coordinateY, n.id as idNpc, "
            . "n.name, n.greeting, n.image "
            . "FROM NpcMap nm "
            . "INNER JOIN Npc n ON nm.idNpc = n.id "
            . "LIMIT 1");

        if ($query->num_rows == 0) {
            throw new NpcMapperNotFoundException;
        }

        return new Npc($query->fetch_assoc());
    }

    /**
     * Возвращает NPC на клетке
     *
     * @param MapCell $cell
     * @return array Массив объектов класса Npc
     */
    public function getOnCell(MapCell $cell) {
        $query = $this->db->query("SELECT nm.id, nm.idMap, nm.coordinateX, "
            . "nm.coordinateY, n.id as idNpc, "
            . "n.name, nm.greeting, n.image "
            . "FROM NpcMap nm "
            . "INNER JOIN Npc n ON nm.idNpc = n.id "
            . "WHERE nm.idMap = $cell->idMap AND nm.coordinateX = $cell->x "
            . "AND nm.coordinateY = $cell->y");

        $npcs = array();
        while ($npc = $query->fetch_assoc()) {
            $npcs[] = new Npc($npc);
        }

        return $npcs;
    }
}
