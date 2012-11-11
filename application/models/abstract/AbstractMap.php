<?php
/**
 * Абстрактный класс карты
 *
 * @author ismd
 */

abstract class AbstractMap extends AbstractModel {

    protected $_id;
    protected $_title;

    public function getId() {
        return $this->_id;
    }

    public function getTitle() {
        return $this->_title;
    }

    public function setId($id) {
        $this->_id = (int)$id;
        return $this;
    }

    public function setTitle($title) {
        $this->_title = (string)$title;
        return $this;
    }
}
