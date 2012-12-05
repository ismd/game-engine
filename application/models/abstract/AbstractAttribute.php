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
            'value' => $this->value,
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
