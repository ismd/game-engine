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

    public function toArray() {
        return array(
            'id'    => $this->id,
            'title' => $this->title,
            'value' => $this->value
        );
    }

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

    public function setValue($value) {
        $this->_value = (float)$value;
        return $this;
    }

    public function getValue() {
        return $this->_value;
    }
}
