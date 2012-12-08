<?php
/**
 * Класс персонажей
 *
 * @author ismd
 */

class CharacterFastMove extends Exception {};
class CharacterCantMoveHere extends Exception {};

class Character extends AbstractCharacter {

    protected $_user;         // Пользователь, владеющий персонажем
    protected $_map;          // Карта, на которой находится персонаж
    protected $_cell;         // Клетка, на которой находится персонаж
    protected $_items;        // Вещи персонажа
    protected $_lastMove = 0; // Используется для проверки задержки между перещениями персонажа
                              // Отсутствует в базе, только в сессии

    public function toArray() {
        return array(
            'id'         => $this->id,
            'idUser'     => $this->user->id,
            'name'       => $this->name,
            'level'      => $this->level,
            'money'      => $this->money,
            'hp'         => $this->hp,
            'maxHp'      => $this->maxHp,
            'minDamage'  => $this->minDamage,
            'maxDamage'  => $this->maxDamage,
            'experience' => $this->experience,
            'image'      => $this->image,
            'strength'   => $this->strength,
            'dexterity'  => $this->dexterity,
            'endurance'  => $this->endurance,
            'idMap'      => $this->map->id,
            'x'          => $this->cell->x,
            'y'          => $this->cell->y,
        );
    }

    /**
     * Установка начальных значений для персонажа
     */
    public function setDefaultValues() {
        $this->level      = 1;
        $this->money      = 0;
        $this->idMap      = 1;
        $this->x          = 2;
        $this->y          = 2;
        $this->strength   = 5;
        $this->dexterity  = 5;
        $this->endurance  = 5;
        $this->hp         = 25;
        $this->maxHp      = 25;
        $this->minDamage  = 5;
        $this->maxDamage  = 10;
        $this->image      = 'player.png';
        $this->experience = 0;

        return $this;
    }

    /**
     * Перемещение персонажа по карте
     *
     * @param Cell $cell
     * @param int $y Новая координата y
     */
    public function move(Cell $cell) {
        // Лимит - секунда
        if (microtime(true) - $this->_lastMove < 1) {
            throw new CharacterFastMove;
        }

        $this->_lastMove = microtime(true);

        // Проверяем, может ли персонаж переместиться на заданную клетку
        if ((($x == $this->x && abs($y - $this->y) != 1)
                || ($y == $this->y && abs($x - $this->x) != 1))
                || ($x == $this->x && $y == $this->y)
                || $x < 0 || $y < 0) {
            throw new CharacterCantMoveHere;
        }

        $mapper = new CharacterMapper;
        $mapper->move($this->id, $x, $y);

        $this->x = $x;
        $this->y = $y;
    }

    public function setItems($value) {
        $this->_items = (array)$value;
        return $this;
    }

    /**
     * Возвращает массив вещей персонажа
     *
     * @return array Массив объектов класса Item
     */
    public function getItems() {
        if (null == $this->_items) {
            $mapper      = new ItemMapper;
            $this->items = $mapper->getByCharacter($this->id);
        }

        return $this->_items;
    }

    public function setMap(Map $value) {
        $this->_map = $value;
        return $this;
    }

    public function getMap() {
        if (null == $this->_map) {
            $mapper    = new MapMapper;
            $this->map = $mapper->getById($this->idMap);
        }

        return $this->_map;
    }

    public function setCell(Cell $value) {
        $this->_cell = $value;
        return $this;
    }

    /**
     * Возвращает текущую клетку, на которой находится персонаж
     *
     * @return Cell
     */
    public function getCell() {
        if (null == $this->_cell) {
            $this->cell = new Cell($this->map, $this->x, $this->y);
        }

        return $this->_cell;
    }

    public function setX($value) {
        if (null != $this->cell) {
            $this->cell->x = $value;
        }

        parent::setX($value);
    }

    public function getX() {
        return $this->cell->x;
    }

    public function setY($value) {
        if (null != $this->cell) {
            $this->cell->y = $value;
        }

        parent::setY($value);
    }

    public function getY() {
        return $this->cell->y;
    }

    public function setUser(User $value) {
        $this->_user = $value;
        return $this;
    }

    public function getUser() {
        if (null == $this->_user) {
            $mapper     = new UserMapper;
            $this->user = $mapper->getById($this->idUser);
        }

        return $this->_user;
    }
}
