<?php
/**
 * Абстрактный класс клетки карты
 *
 * @author ismd
 */

abstract class AbstractMapCell extends DefaultModel {

    protected $_idMap;
    protected $_coordinateX;
    protected $_coordinateY;
    
    public function __construct($idMap, $x, $y) {
        $idMap   = (int)$idMap;
        $x       = (int)$x;
        $y       = (int)$y;
        
        $options = array(
            'idMap'       => $idMap,
            'coordinateX' => $x,
            'coordinateY' => $y
        );
        
        parent::__construct($options);
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
}
