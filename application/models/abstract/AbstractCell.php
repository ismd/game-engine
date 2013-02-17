<?php
/**
 * Абстрактный класс клетки карты
 * @author ismd
 */

abstract class AbstractCell extends PsAbstractModel {

    protected $_map;
    protected $_x;
    protected $_y;

    /**
     * Создал неунаследованный конструктор,
     *   потому что координаты необходимо указывать в обязательном порядке
     * @param Map $map
     * @param int $x
     * @param int $y
     */
    public function __construct(Map $map, $x, $y) {
        $x = (int)$x;
        $y = (int)$y;

        $options = array(
            'map' => $map,
            'x'   => $x,
            'y'   => $y,
        );

        parent::__construct($options);
    }

    public function setMap(Map $value) {
        $this->_map = $value;
        return $this;
    }

    public function getMap() {
        return $this->_map;
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
