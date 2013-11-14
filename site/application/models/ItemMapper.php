<?php
/**
 * Модель инвентаря
 * @author ismd
 */

class ItemNotFoundException extends Exception {
    protected $message = 'Вещь не найдена';
};

class ItemMapper extends PsDbMapper {

    /**
     * Возвращает вещь по id
     * @param int $id
     * @return Item
     * @throws ItemNotFoundException
     */
    public function getById($id) {
        $id = (int)$id;

        $stmt = $this->db->prepare("SELECT i.id, i.title, i.idType, "
            . "i.price, i.description, it.title AS type "
            . "FROM Item i "
            . "INNER JOIN ItemType it ON i.idType = it.id "
            . "WHERE i.id = ? "
            . "LIMIT 1");

        $stmt->bind_param('d', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if (0 == $result->num_rows) {
            throw new ItemNotFoundException;
        }

        return new Item($result->fetch_assoc());
    }

    /**
     * Возвращает массив вещей персонажа
     * @param Character $character
     * @return Item[]
     */
    public function getByCharacter(Character $character) {
        $stmt = $this->db->prepare("SELECT i.id, i.title, i.idType, "
            . "i.price, i.description, it.title AS type "
            . "FROM CharacterItem ci "
            . "INNER JOIN Item i ON ci.idItem = i.id "
            . "INNER JOIN ItemType it ON i.idType = it.id "
            . "WHERE ci.idCharacter = ?");

        $stmt->bind_param('d', $character->id);
        $stmt->execute();
        $result = $stmt->get_result();

        $items = [];
        while ($item = $result->fetch_assoc()) {
            $items[] = new Item($item);
        }

        return $items;
    }
}
