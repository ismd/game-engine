<?php
/**
 * Класс Registry используется для передачи глобальных значений между отдельными объектами
 *
 * @author ismd
 */

class Registry {

    protected $_data = array();

    public function __set($key, $value) {
        $this->_data[$key] = $value;
    }

    public function __get($key) {
        if (!isset($this->_data[$key])) {
            return null;
        }

        return $this->_data[$key];
    }

    public function __unset($key) {
        if (isset($this->_data[$key])) {
            unset($this->_data[$key]);
        }
    }

    public function __isset($key) {
        return isset($this->_data[$key]);
    }
}
