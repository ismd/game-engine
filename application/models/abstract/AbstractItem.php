<?php
/**
 * Абстрактный класс вещи
 *
 * @author ismd
 */

abstract class AbstractItem extends AbstractModel {

    protected $_id;
    protected $_title;
    protected $_idType;
    protected $_price;
    protected $_description;
    protected $_type;       // Тип вещи из таблицы ItemType
    protected $_attributes; // Атрибуты вещи. Берутся из таблиц ItemAttribute и Attribute

    public function setId($id) {
        $this->_id = (int)$id;
        return $this;
    }

    public function getId() {
        return $this->_id;
    }

    public function setTitle($title) {
        $this->_title = (string)$title;
        return $this;
    }

    public function getTitle() {
        return $this->_title;
    }

    public function setIdType($idType) {
        $this->_idType = (int)$idType;
        return $this;
    }

    public function getIdType() {
        return $this->_idType;
    }

    public function setPrice($price) {
        $this->_price = (int)$price;
        return $this;
    }

    public function getPrice() {
        return $this->_price;
    }

    public function setDescription($description) {
        $this->_description = (string)$description;
        return $this;
    }

    public function getDescription() {
        return $this->_description;
    }

    public function setType($type) {
        $this->_type = (string)$type;
        return $this;
    }

    public function getType() {
        return $this->_type;
    }

    public function setAttributes($attributes) {
        $this->_attributes = (array)$attributes;
        return $this;
    }

    public function getAttributes() {
        return $this->_attributes;
    }















    public function toArray() {
        $attributes = array();
        foreach ($this->_attributes as $attribute) {
            $attributes[] = $attribute->toArray();
        }

        return array(
            'id'            => $this->_id,
            'title'         => $this->_title,
            'idType'        => $this->_idType,
            'price'         => $this->_price,
            'description'   => $this->_description,
            'type'          => $this->_type,
            'attributes'    => $attributes
        );
    }
}
