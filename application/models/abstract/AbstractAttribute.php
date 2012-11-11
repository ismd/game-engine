<?php
/**
 * Абстрактный класс аттрибута
 *
 * @author ismd
 */

abstract class AbstractAttribute extends AbstractModel {

    protected $_id;
    protected $_title;
    protected $_value;

    public function getId() {
        return $this->_id;
    }

    public function getTitle() {
        return $this->_title;
    }

    public function getValue() {
        return $this->_value;
    }

    public function setId($id) {
        $this->_id = (int)$id;
        return $this;
    }

    public function setTitle($title) {
        $this->_title = (string)$title;
        return $this;
    }

    public function setValue($value) {
        $this->_value = $value;
        return $this;
    }

    public function toArray() {
        return array(
            'id'      => $this->_id,
            'title'   => $this->_title,
            'value'   => $this->_value
        );
    }
}
