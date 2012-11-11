<?php
/**
 * Модель вещи
 *
 * @author ismd
 */

class ItemMapper {

    /**
     * Возвращает вещь по id
     *
     * @param int $id
     */
    public function getById($id) {
        $id = (int)$id;

        $query = mysql_query("SELECT Item.id, Item.title, Item.idType, Item.price, Item.description, ItemType.title AS type "
                           . "FROM Item INNER JOIN ItemType ON Item.idType=ItemType.id WHERE Item.id=$id LIMIT 1");

        if (mysql_num_rows($query) == 0) {
            return null;
        }

        $item = mysql_fetch_assoc($query);

        $mapper = AttributeMapper;
        $item['attributes'] = $mapper->getItemAttributes($id);

        return new Item($item);
    }

    /**
     * Возвращает массив вещей персонажа
     *
     * @param int $idCharacter - id персонажа
     * @return array(Item)
     */
    public function getCharacterItems($idCharacter) {
        $idCharacter = (int)$idCharacter;

        $query = mysql_query("SELECT Item.id, Item.title, Item.idType, Item.price, Item.description, ItemType.title AS type "
                           . "FROM CharacterItem INNER JOIN Item ON CharacterItem.idItem=Item.id "
                           . "INNER JOIN ItemType ON Item.idType=ItemType.id "
                           . "WHERE CharacterItem.idCharacter=$idCharacter");

        $items = array();
        $mapper = new AttributeMapper;
        
        while ($item = mysql_fetch_assoc($query)) {
            $item['attributes'] = $mapper->getItemAttributes($item['id']);
            $items[] = new Item($item);
        }

        return $items;
    }
}
