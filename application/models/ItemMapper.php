<?php
/**
 * Модель вещи
 *
 * @author ismd
 */

class ItemMapperNotFoundException extends Exception {};

class ItemMapper extends AbstractDbMapper {

    /**
     * Возвращает вещь по id
     *
     * @param int $id
     * @return Item
     * @throws ItemMapperNotFoundException
     */
    public function getById($id) {
        $id = (int)$id;

        $query = $this->db->query("SELECT Item.id, Item.title, Item.idType, "
            . "Item.price, Item.description, ItemType.title AS type "
            . "FROM Item "
            . "INNER JOIN ItemType ON Item.idType = ItemType.id "
            . "WHERE Item.id = $id "
            . "LIMIT 1");

        if ($query->num_rows == 0) {
            throw new ItemMapperNotFoundException;
        }

        return new Item($query->fetch_assoc());
    }

    /**
     * Возвращает массив вещей персонажа
     *
     * @param Character $character
     * @return Item[]
     */
    public function getByCharacter(Character $character) {
        $query = $this->db->query("SELECT i.id, i.title, i.idType, "
            . "i.price, i.description, it.title AS type "
            . "FROM CharacterItem ci "
            . "INNER JOIN Item i ON ci.idItem = i.id "
            . "INNER JOIN ItemType it ON i.idType = it.id "
            . "WHERE ci.idCharacter = $character->id");

        $items = array();
        while ($item = $query->fetch_assoc()) {
            $items[] = new Item($item);
        }

        return $items;
    }
}
