<?php
/**
 * Модель карты
 *
 * @author ismd
 */

class MapMapper {

    /**
     * Возвращает карту по id
     *
     * @param int $id
     */
    public function getById($id) {
        $id = (int)$id;

        $query = mysql_query("SELECT id, title FROM `Map` WHERE id=$id LIMIT 1");

        if (mysql_num_rows($query) == 0) {
            return null;
        }

        return new Map(mysql_fetch_assoc($query));
    }
}
