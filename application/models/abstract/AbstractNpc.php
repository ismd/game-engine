<?php
/**
 * Абстрактный класс NPC
 * @author ismd
 */

abstract class AbstractNpc extends PsAbstractModel {

    protected $_id;    // id в таблице NpcMap (конкретный NPC на карте)
    protected $_idNpc; // id в таблице Npc (класс NPC)
    protected $_name;
    protected $_greeting;
    protected $_image;
    protected $_idMap;
    protected $_x;
    protected $_y;

    public function setId($value) {
        $this->_id = (int)$value;
        return $this;
    }

    public function getId() {
        return $this->_id;
    }

    public function setIdNpc($value) {
        $this->_idNpc = (int)$value;
        return $this;
    }

    public function getIdNpc() {
        return $this->_idNpc;
    }

    public function setName($value) {
        $this->_name = (string)$value;
        return $this;
    }

    public function getName() {
        return $this->_name;
    }

    public function setGreeting($value) {
        $this->_greeting = (string)$value;
        return $this;
    }

    public function getGreeting() {
        return $this->_greeting;
    }

    public function setImage($value) {
        $this->_image = (string)$value;
        return $this;
    }

    public function getImage() {
        return $this->_image;
    }

    public function setIdMap($value) {
        $this->_idMap = (int)$value;
        return $this;
    }

    public function getIdMap() {
        return $this->_idMap;
    }

    public function setCoordinateX($value) {
        $this->_x = (int)$value;
        return $this;
    }

    public function getCoordinateX() {
        return $this->_x;
    }

    public function setCoordinateY($value) {
        $this->_y = (int)$value;
        return $this;
    }

    public function getCoordinateY() {
        return $this->_y;
    }
}
