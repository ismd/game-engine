<?php
/**
 * Модель аттрибута
 *
 * @author ismd
 */

class AttributeMapper extends AbstractDbMapper {

    /**
     * Возвращает аттрибуты вещи
     *
     * @param Item $item
     * @return array Массив объектов класса Attribute
     */
    public function getByItem($item) {
        $query = $this->db->query("SELECT ia.value, a.id, a.title "
            . "FROM ItemAttribute ia "
            . "INNER JOIN Attribute a ON ia.idAttribute = a.id "
            . "WHERE ia.idItem = $item->id");

        $attributes = array();
        while ($attribute = $query->fetch_assoc()) {
            $attributes[] = new Attribute($attribute);
        }

        return $attributes;
    }
}
