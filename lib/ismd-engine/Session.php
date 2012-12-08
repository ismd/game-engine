<?php
/**
 * Реализация сессии. Автоматическая сериализация
 *
 * @author ismd
 */

class Session {

    public function __construct() {
        array_walk($_SESSION, function(&$value, $key) {
            $value = unserialize($value);
        });
    }

    public function __destruct() {
        array_walk($_SESSION, function(&$value, $key) {
            $value = serialize($value);
        });
    }

    public function clear() {
        $_SESSION = array();
    }
    
    public function __set($name, $value) {
        $_SESSION[$name] = $value;
    }
    
    public function __get($name) {
        if (!isset($_SESSION[$name])) {
            return null;
        }
        
        return $_SESSION[$name];
    }
    
    public function __isset($name) {
        return isset($_SESSION[$name]);
    }
    
    public function __unset($name) {
        unset($_SESSION[$name]);
    }
}
