<?php
/**
 * Класс персонажей
 *
 * @author ismd
 */

class Character extends AbstractCharacter {

    protected $_lastMove = 0;   // Используется для проверки задержки между перещениями персонажа
                                // Отсутствует в базе, только в сессии

    const CREATE_ERR_NAME_EXISTS       = 1;
    const CREATE_ERR_NAME_LENGTH_MAX   = 2;
    const CREATE_ERR_NAME_LENGTH_MIN   = 3;

    /**
     * Перемещение персонажа по карте
     *
     * @param int $x
     * @param int $y
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
        if ((($x == $this->_coordinateX && abs($y - $this->_coordinateY) == 1)
                || ($y == $this->_coordinateY && abs($x - $this->_coordinateX) == 1))
                && $x >= 0 && $y >= 0) {
            $mapper = new CharacterMapper;
            $mapper->move($this->_id, $x, $y);

            $this->_coordinateX = $x;
            $this->_coordinateY = $y;

            return true;
        }

        return false;
    }

    /**
     * Возвращает массив вещей персонажа
     *
     * @return array(Item)
     */
    public function getItems() {
        $mapper = new ItemMapper;
        return $mapper->getCharacterItems($this->_id);
    }

    /**
     * Установка начальных значений
     */
    public function setDefaultValues() {
        $this->_level       = 1;
        $this->_money       = 0;
        $this->_idMap       = 1;
        $this->_coordinateX = 2;
        $this->_coordinateY = 2;
        $this->_strength    = 5;
        $this->_dexterity   = 5;
        $this->_endurance   = 5;
        $this->_hp          = 25;
        $this->_maxHp       = 25;
        $this->_minDamage   = 5;
        $this->_maxDamage   = 10;
        $this->_image       = 'player.png';
        $this->_experience  = 0;
    }
}
