<?php
/**
 * Модель карты
 * @author ismd
 */

class Map extends AbstractMap {

    private $_map = array();

    public function __construct($options = null) {
        parent::__construct($options);

        $file = file_get_contents('img/world/maps/' . $this->id . '.txt');
        $this->_map = json_decode($file);
    }

    public function getMap() {
        return $this->_map;
    }

    public function getWidth() {
        return count($this->map);
    }

    public function getHeight() {
        return count($this->map[0]);
    }
}
