<?php
/**
 * Модель карты
 * @author ismd
 */

class Layout extends Abstract_Layout {

    private $_layout = array();

    public function __construct($options = null) {
        parent::__construct($options);

        $file = file_get_contents('img/world/layouts/' . $this->getId() . '.txt');
        $this->_layout = json_decode($file);
    }

    public function getLayout() {
        return $this->_layout;
    }

    public function getWidth() {
        return count($this->getLayout());
    }

    public function getHeight() {
        return count($this->getLayout()[0]);
    }
}
