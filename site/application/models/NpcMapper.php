<?php
/**
 * Модель NPC
 * @author ismd
 */

class NpcNotFoundException extends Exception {
    protected $message = 'NPC не найден';
};

class NpcMapper extends PsDbMapper {

    /**
     * Возвращает NPC по id
     * @param int $id
     * @return Npc
     * @throws NpcNotFoundException
     */
    public function getById($id) {
        $id = (int)$id;

        $query = $this->db->query("SELECT id, idLayout, x, "
            . "y, name, greeting, image "
            . "FROM Npc "
            . "LIMIT 1");

        if ($query->num_rows == 0) {
            throw new NpcNotFoundException;
        }

        return new Npc($query->fetch_assoc());
    }

    /**
     * Возвращает NPC на клетке
     * @param Cell $cell
     * @return Npc[]
     */
    public function getByCell(Cell $cell) {
        $query = $this->db->query("SELECT id, idMap, x, "
            . "y, name, greeting, image "
            . "FROM Npc "
            . "WHERE idMap = " . $cell->getLayout()->getId() . " AND x = " . $cell->getX()
            . "AND y = " . $cell->getY());

        $npcs = [];
        while ($npc = $query->fetch_assoc()) {
            $npcs[] = new Npc($npc);
        }

        return $npcs;
    }
}
