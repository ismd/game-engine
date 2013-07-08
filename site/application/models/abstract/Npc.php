<?php
/**
 * Абстрактный класс NPC
 * @author ismd
 */

abstract class Abstract_Npc extends PsModel {

    private $_id;    // id в таблице NpcLayout (конкретный NPC на карте)
    private $_idNpc; // id в таблице Npc (класс NPC)
    private $_name;
    private $_greeting;
    private $_image;
    private $_idLayout;
    private $_x;
    private $_y;

    public function toArray() {
        return array(
            'id'       => $this->getId(),
            'idNpc'    => $this->getIdNpc(),
            'name'     => $this->getName(),
            'greeting' => $this->getGreeting(),
            'image'    => $this->getImage(),
            'idLayout' => $this->getIdLayout(),
            'x'        => $this->getX(),
            'y'        => $this->getY(),
        );
    }

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

    public function setIdLayout($value) {
        $this->_idLayout = (int)$value;
        return $this;
    }

    public function getIdLayout() {
        return $this->_idLayout;
    }

    public function setX($value) {
        $this->_x = (int)$value;
        return $this;
    }

    public function getX() {
        return $this->_x;
    }

    public function setY($value) {
        $this->_y = (int)$value;
        return $this;
    }

    public function getY() {
        return $this->_y;
    }
}
