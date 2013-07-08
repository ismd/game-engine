<?php
/**
 * Модель карты
 * @author ismd
 */

class LayoutNotFoundException extends Exception {
    protected $message = 'Карта не найдена';
};

class LayoutMapper extends PsDbMapper {

    /**
     * Возвращает карту по id
     * @param int $id
     * @return Layout
     * @throws LayoutNotFoundException
     */
    public function getById($id) {
        $id = (int)$id;

        $stmt = $this->db->prepare("SELECT id, title "
            . "FROM `Layout` "
            . "WHERE id = ? "
            . "LIMIT 1");

        $stmt->bind_param('d', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if (0 == $result->num_rows) {
            throw new LayoutNotFoundException;
        }

        return new Layout($result->fetch_assoc());
    }
}
