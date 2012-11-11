<?php
/**
 * Абстрактный класс NPC
 *
 * @author ismd
 */

abstract class AbstractNpc extends AbstractModel {

    protected $_id;      // id в таблице NpcMap (конкретный NPC на карте)
    protected $_idNpc;   // id в таблице Npc (класс NPC)
    protected $_name;
    protected $_greeting;
    protected $_image;
    protected $_idMap;
    protected $_coordinateX;
    protected $_coordinateY;

    public function getId() {
        return $this->_id;
    }

    public function getIdNpc() {
        return $this->_idNpc;
    }

    public function getName() {
        return $this->_name;
    }

    public function getGreeting() {
        return $this->_greeting;
    }

    public function getImage() {
        return $this->_image;
    }

    public function getIdMap() {
        return $this->_idMap;
    }

    public function getCoordinateX() {
        return $this->_coordinateX;
    }

    public function getCoordinateY() {
        return $this->_coordinateY;
    }

    public function setId($id) {
        $this->_id = (int)$id;
        return $this;
    }

    public function setIdNpc($idNpc) {
        $this->_idNpc = (int)$idNpc;
        return $this;
    }

    public function setName($name) {
        $this->_name = (string)$name;
        return $this;
    }

    public function setGreeting($greeting) {
        $this->_greeting = (string)$greeting;
        return $this;
    }

    public function setImage($image) {
        $this->_image = (string)$image;
        return $this;
    }

    public function setIdMap($idMap) {
        $this->_idMap = (int)$idMap;
        return $this;
    }

    public function setCoordinateX($coordinateX) {
        $this->_coordinateX = (int)$coordinateX;
        return $this;
    }

    public function setCoordinateY($coordinateY) {
        $this->_coordinateY = (int)$coordinateY;
        return $this;
    }

    public function toArray() {
        return array(
            'id'             => $this->_id,
            'idNpc'          => $this->_idNpc,
            'name'           => $this->_name,
            'greeting'       => $this->_greeting,
            'image'          => $this->_image,
            'idMap'          => $this->_idMap,
            'coordinateX'    => $this->_coordinateX,
            'coordinateY'    => $this->_coordinateY
        );
    }
}
