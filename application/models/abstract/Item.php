<?php
/**
 * Абстрактный класс вещи
 * @author ismd
 */

abstract class Abstract_Item extends PsModel {

    protected $_id;
    protected $_title;
    protected $_idType;
    protected $_price;
    protected $_description;

    public function toArray() {
        return array(
            'id'          => $this->getId(),
            'title'       => $this->getTitle(),
            'idType'      => $this->getIdType(),
            'price'       => $this->getPrice(),
            'description' => $this->getDescription(),
        );
    }

    public function setId($value) {
        $this->_id = (int)$value;
        return $this;
    }

    public function getId() {
        return $this->_id;
    }

    public function setTitle($value) {
        $this->_title = (string)$value;
        return $this;
    }

    public function getTitle() {
        return $this->_title;
    }

    public function setIdType($value) {
        $this->_idType = (int)$value;
        return $this;
    }

    public function getIdType() {
        return $this->_idType;
    }

    public function setPrice($value) {
        $this->_price = (int)$value;
        return $this;
    }

    public function getPrice() {
        return $this->_price;
    }

    public function setDescription($value) {
        $this->_description = (string)$value;
        return $this;
    }

    public function getDescription() {
        return $this->_description;
    }
}
