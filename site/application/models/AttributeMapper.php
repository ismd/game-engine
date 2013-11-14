<?php
/**
 * Mapper атрибута
 * @author ismd
 */

class AttributeMapper extends PsDbMapper {

    /**
     * Возвращает атрибуты вещи
     * @param Item $item
     * @return Attribute[]
     */
    public function getByItem(Item $item) {
        $stmt = $this->db->prepare("SELECT ia.value, a.id, a.title "
            . "FROM ItemAttribute ia "
            . "INNER JOIN Attribute a ON ia.idAttribute = a.id "
            . "WHERE ia.idItem = ?");

        $stmt->bind_param('d', $item->id);
        $stmt->execute();
        $result = $stmt->get_result();

        $attributes = [];
        while ($attribute = $result->fetch_assoc()) {
            $attributes[] = new Attribute($attribute);
        }

        return $attributes;
    }
}
