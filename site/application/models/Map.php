<?php
/**
 * Модель карты
 * @author ismd
 */

class Map extends Abstract_Map {

    private $_map = array();

    public function __construct($options = null) {
        parent::__construct($options);

        $file = file_get_contents('img/world/maps/' . $this->getId() . '.txt');
        $this->_map = json_decode($file);
    }

    public function getMap() {
        return $this->_map;
    }

    public function getWidth() {
        return count($this->getMap());
    }

    public function getHeight() {
        return count($this->getMap()[0]);
    }
}
