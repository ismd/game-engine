<?php
/**
 * Класс персонажей
 *
 * @author ismd
 */

class Character extends AbstractCharacter {

    protected $_lastMove = 0; // Используется для проверки задержки между перещениями персонажа
                              // Отсутствует в базе, только в сессии

    const CREATE_ERR_NAME_EXISTS     = 1;
    const CREATE_ERR_NAME_LENGTH_MAX = 2;
    const CREATE_ERR_NAME_LENGTH_MIN = 3;

    /**
     * Перемещение персонажа по карте
     *
     * @param int $x Новая координата x
     * @param int $y Новая координата y
     * @return boolean
     */
    public function move($x, $y) {
        $x = (int)$x;
        $y = (int)$y;

        // Лимит - секунда
        if (microtime(true) - $this->_lastMove < 1) {
            die(microtime(true) - $this->_lastMove);
        }

        $this->_lastMove = microtime(true);

        // Проверяем, может ли персонаж переместиться на заданную клетку
        if ((($x == $this->coordinateX && abs($y - $this->coordinateY) != 1)
                || ($y == $this->coordinateY && abs($x - $this->coordinateX) != 1))
                || ($x == $this->coordinateX && $y == $this->coordinateY)
                || $x < 0 || $y < 0) {
            return false;
        }

        $mapper = new CharacterMapper;
        $mapper->move($this->id, $x, $y);

        $this->coordinateX = $x;
        $this->coordinateY = $y;

        return true;
    }

    /**
     * Возвращает массив вещей персонажа
     *
     * @return array Массив объектов класса Item
     */
    public function getItems() {
        $mapper = new ItemMapper;
        return $mapper->getCharacterItems($this->id);
    }

    /**
     * Установка начальных значений для персонажа
     */
    public function setDefaultValues() {
        $this->level       = 1;
        $this->money       = 0;
        $this->idMap       = 1;
        $this->coordinateX = 2;
        $this->coordinateY = 2;
        $this->strength    = 5;
        $this->dexterity   = 5;
        $this->endurance   = 5;
        $this->hp          = 25;
        $this->maxHp       = 25;
        $this->minDamage   = 5;
        $this->maxDamage   = 10;
        $this->image       = 'player.png';
        $this->experience  = 0;
    }
}
