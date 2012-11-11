<?php
/**
 * Класс Registry используется для передачи глобальных значений между отдельными объектами
 *
 * @author ismd
 */

class Registry {

    private $data = array();

    public function __set($key, $value) {
        $this->data[$key] = $value;
    }

    public function __get($key) {
        if (!isset($this->data[$key])) {
            return null;
        }

        return $this->data[$key];
    }

    public function __unset($key) {
        if (isset($this->data[$key])) {
            unset($this->data[$key]);
        }
    }

    public function __isset($key) {
        return isset($this->_data[$key]);
    }
}
