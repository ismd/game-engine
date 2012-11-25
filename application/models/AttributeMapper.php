<?php
/**
 * Модель аттрибута
 *
 * @author ismd
 */

class AttributeMapper {

    /**
     * Возвращает массив аттрибутов вещи
     *
     * @param int $idItem - id вещи
     * @return array Массив объектов класса Attribute
     */
    public function getItemAttributes($idItem) {
        $idItem = (int)$idItem;

        $query = mysql_query("SELECT ItemAttribute.value, Attribute.id, Attribute.title "
            . "FROM ItemAttribute INNER JOIN Attribute ON ItemAttribute.idAttribute=Attribute.id "
            . "WHERE ItemAttribute.idItem=$idItem");

        $attributes = array();
        while ($attribute = mysql_fetch_assoc($query)) {
            $attributes[] = new Attribute($attribute);
        }

        return $attributes;
    }
}
