<?php
/**
 * Модель NPC
 *
 * @author ismd
 */

class NpcMapperNotFoundException extends Exception {};

class NpcMapper extends PsAbstractDbMapper {

    /**
     * Возвращает NPC по id из таблицы NpcMap
     *
     * @param int $id
     * @return Npc
     * @throws NpcMapperNotFoundException
     */
    public function getById($id) {
        $id = (int)$id;

        $query = $this->db->query("SELECT nm.id, nm.idMap, nm.x, "
            . "nm.y, n.id as idNpc, "
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
     * @param Cell $cell
     * @return Npc[]
     */
    public function getByCell(Cell $cell) {
        $query = $this->db->query("SELECT nm.id, nm.idMap, nm.x, "
            . "nm.y, n.id as idNpc, "
            . "n.name, n.greeting, n.image "
            . "FROM NpcMap nm "
            . "INNER JOIN Npc n ON nm.idNpc = n.id "
            . "WHERE nm.idMap = " . $cell->map->id . " AND nm.x = $cell->x "
            . "AND nm.y = $cell->y");

        $npcs = array();
        while ($npc = $query->fetch_assoc()) {
            $npcs[] = new Npc($npc);
        }

        return $npcs;
    }
}
