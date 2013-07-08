<?php
/**
 * Абстрактный класс карты
 * @author ismd
 */

abstract class Abstract_Layout extends PsModel {

    private $_id;
    private $_title;

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
}
