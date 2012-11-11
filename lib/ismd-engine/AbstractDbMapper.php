<?php
/**
 * Родительский класс для mapper'ов с подключением к БД
 */

abstract class AbstractDbMapper extends AbstractModel {

    protected $_db;

    public function __construct(array $options = null) {
        parent::__construct($options);

        global $registry;
        $this->_db = $registry->db;
    }

    public function setDb(mysqli $db) {
        $this->_db = $db;
        return $this;
    }

    public function getDb() {
        return $this->_db;
    }
}
