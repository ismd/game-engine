<?php
/**
 * Класс вещи
 *
 * @author ismd
 */

class Item extends AbstractItem {

    protected $_type;       // Тип вещи из таблицы ItemType
    protected $_attributes; // Атрибуты вещи. Берутся из таблиц ItemAttribute и Attribute

    public function setType($value) {
        $this->_type = (string)$value;
        return $this;
    }

    public function getType() {
        return $this->_type;
    }

    public function setAttributes($value) {
        $this->_attributes = (array)$value;
        return $this;
    }

    public function getAttributes() {
        if (null == $this->_attributes) {
            $mapper           = AttributeMapper;
            $this->attributes = $mapper->getItemAttributes($this->id);
        }

        return $this->_attributes;
    }
}
