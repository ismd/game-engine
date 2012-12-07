<?php
/**
 * Реализация сессии. Автоматическая сериализация
 *
 * @author ismd
 */

class Session extends Object {

    public function __construct() {
        foreach ($_SESSION as $key => $value) {
            $this->$key = unserialize($value);
        }
    }

    public function __destruct() {
        $_SESSION = array();
        $iterator = $this->getIterator();

        while ($iterator->valid()) {
            $_SESSION[$iterator->key()] = serialize($iterator->current());
            $iterator->next();
        }
    }

    public function clear() {
        $_SESSION = array();
        $this->exchangeArray(array());
    }
}
