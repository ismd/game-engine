<?php
/**
 * Модель карты
 *
 * @author ismd
 */

class Map extends AbstractMap {

    protected $_currentCell; // Клетка, на которой находится персонаж
    
    /**
     * Возвращает текущую клетку, на которой находится персонаж
     * 
     * @return MapCell
     */
    public function getCurrentCell() {
        return $this->_currentCell;
    }
    
    public function setCurrentCell(MapCell $cell) {
        $this->_currentCell = $cell;
        return $this;
    }
}
