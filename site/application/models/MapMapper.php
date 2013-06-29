<?php
/**
 * Модель карты
 * @author ismd
 */

class MapNotFoundException extends Exception {
    protected $message = 'Карта не найдена';
};

class MapMapper extends PsDbMapper {

    /**
     * Возвращает карту по id
     * @param int $id
     * @return Map
     * @throws MapNotFoundException
     */
    public function getById($id) {
        $id = (int)$id;

        $stmt = $this->db->prepare("SELECT id, title "
            . "FROM `Map` "
            . "WHERE id = ? "
            . "LIMIT 1");

        $stmt->bind_param('d', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if (0 == $result->num_rows) {
            throw new MapNotFoundException;
        }

        return new Map($result->fetch_assoc());
    }
}
