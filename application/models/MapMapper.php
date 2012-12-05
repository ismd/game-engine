<?php
/**
 * Модель карты
 *
 * @author ismd
 */

class MapMapperNotFoundException extends Exception {};

class MapMapper {

    /**
     * Возвращает карту по id
     *
     * @param int $id
     * @return Map
     * @throws MapMapperNotFoundException
     */
    public function getById($id) {
        $id = (int)$id;

        $query = mysql_query("SELECT id, title "
            . "FROM `Map` "
            . "WHERE id = $id "
            . "LIMIT 1");

        if ($query->num_rows == 0) {
            throw new MapMapperNotFoundException;
        }

        return new Map($query->fetch_assoc());
    }
}
