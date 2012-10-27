<?php
/**
 * Реализация сессии. Автоматическая сериализация
 *
 * @author ismd
 */

class Session {

    public function __construct() {
        foreach ($_SESSION as $key => $value) {
            $_SESSION[$key] = unserialize($value);
        }
    }

    public function __destruct() {
        foreach ($_SESSION as $key => $value) {
            $_SESSION[$key] = serialize($value);
        }
    }

    public function __set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public function __get($key) {
        if (!isset($_SESSION[$key])) {
            return null;
        }

        return $_SESSION[$key];
    }

    public function __unset($key) {
        unset($_SESSION[$key]);
    }

    public function __isset($key) {
        return isset($_SESSION[$key]);
    }

    public function clear() {
        $_SESSION = array();
    }
}
