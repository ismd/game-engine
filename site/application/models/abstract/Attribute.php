<?php
/**
 * Абстрактный класс аттрибута
 * @author ismd
 */

abstract class Abstract_Attribute extends PsModel {

    private $_id;
    private $_title;
    private $_value;

    public function toArray() {
        return array(
            'id'    => $this->getId(),
            'title' => $this->getTitle(),
            'value' => $this->getValue(),
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

    public function setValue($value) {
        $this->_value = (int)$value;
        return $this;
    }

    public function getValue() {
        return $this->_value;
    }
}
