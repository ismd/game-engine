<?php
/**
 * Абстрактный класс клетки карты
 * @author ismd
 */

abstract class Abstract_Cell extends PsModel {

    /**
     * @var Layout
     */
    private $_layout;
    private $_x;
    private $_y;

    /**
     * Создал неунаследованный конструктор,
     * потому что координаты необходимо указывать в обязательном порядке
     * @param Layout $layout
     * @param int $x
     * @param int $y
     */
    public function __construct(Layout $layout, $x, $y) {
        $x = (int)$x;
        $y = (int)$y;

        $options = [
            'layout' => $layout,
            'x'      => $x,
            'y'      => $y,
        ];

        parent::__construct($options);
    }

    public function setLayout(Layout $value) {
        $this->_layout = $value;
        return $this;
    }

    /**
     * @return Layout
     */
    public function getLayout() {
        return $this->_layout;
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
