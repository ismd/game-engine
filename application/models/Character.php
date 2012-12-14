<?php
/**
 * Класс персонажей
 *
 * @author ismd
 */

class CharacterFastMove extends Exception {};
class CharacterCantMoveHere extends Exception {};

class Character extends AbstractCharacter {

    /**
     * Пользователь, владеющий персонажем
     * @var User
     */
    protected $_user;

    /**
     * Клетка, на которой находится персонаж
     * @var Cell
     */
    protected $_cell;

    /**
     * Вещи персонажа
     * @var Item[]
     */
    protected $_items;

    /**
     * Используется для проверки задержки между перещениями персонажа
     * @var int
     */
    protected $_lastMove = 0;

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
            'idMap'      => $this->cell->map->id,
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
     * @throws CharacterFastMove
     * @throws CharacterCantMoveHere
     */
    public function move(Cell $cell) {
        // Лимит - секунда
        if (microtime(true) - $this->_lastMove < 1) {
            throw new CharacterFastMove;
        }

        $this->_lastMove = microtime(true);

        // Проверяем, может ли персонаж переместиться на заданную клетку
        if (($cell->x == $this->cell->x && abs($cell->y - $this->cell->y) != 1)
                || ($cell->y == $this->cell->y && abs($cell->x - $this->cell->x) != 1)
                || ($cell->x == $this->cell->x && $cell->y == $this->cell->y)
                || $cell->x < 0 || $cell->y < 0) {
            throw new CharacterCantMoveHere;
        }

        $mapper = new CharacterMapper;
        $mapper->move($this, $cell);

        $this->cell = $cell;
    }

    public function setItems($value) {
        $this->_items = (array)$value;
        return $this;
    }

    /**
     * Возвращает массив вещей персонажа
     * @return Item[]
     */
    public function getItems() {
        if (null == $this->_items) {
            $mapper      = new ItemMapper;
            $this->items = $mapper->getByCharacter($this);
        }

        return $this->_items;
    }

    public function setCell(Cell $value) {
        $this->_cell = $value;
        return $this;
    }

    /**
     * Возвращает текущую клетку, на которой находится персонаж
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

    /**
     * Устанавливает пользователя первонажа
     *
     * @param User $value
     * @return Character
     */
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
