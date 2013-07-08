<?php
/**
 * Класс персонажей
 * @author ismd
 */

class FastMoveException extends Exception {
    protected $message = 'Слишком быстрое передвижение';
};

class CantMoveHereException extends Exception {
    protected $message = 'Невозможно переместиться на заданную клетку';
};

class Character extends Abstract_Character {

    /**
     * Пользователь, владеющий персонажем
     * @var User
     */
    private $_user;

    /**
     * Клетка, на которой находится персонаж
     * @var Cell
     */
    private $_cell;

    /**
     * Вещи персонажа
     * @var Item[]
     */
    private $_items;

    /**
     * Используется для проверки задержки между перещениями персонажа
     * @var int
     */
    private $_lastMove = 0;

    /**
     * Установка начальных значений для персонажа
     */
    public function setDefaultValues() {
        $this->setLevel(1);
        $this->setMoney(0);
        $this->setIdLayout(1);
        $this->setX(2);
        $this->setY(2);
        $this->setStrength(5);
        $this->setDexterity(5);
        $this->setEndurance(5);
        $this->setHp(25);
        $this->setMaxHp(25);
        $this->setMinDamage(5);
        $this->setMaxDamage(10);
        $this->setImage('player.png');
        $this->setExperience(0);

        return $this;
    }

    /**
     * Перемещение персонажа по карте
     * @param Cell $cell
     * @throws FastMoveException
     * @throws CantMoveHereException
     */
    public function move(Cell $cell) {
        // Лимит - секунда
        if (microtime(true) - $this->_lastMove < 1) {
            throw new FastMoveException;
        }

        $this->_lastMove = microtime(true);

        // Проверяем, может ли персонаж переместиться на заданную клетку
        if ($cell->getX() < 3 || $cell->getY() < 2
            || $cell->getX() > $cell->getLayout()->getWidth() - 3
            || $cell->getY() > $cell->getLayout()->getHeight() - 2) {
            throw new CantMoveHereException;
        }

        if ($cell->getX() == $this->getCell()->getX()) {
            if (abs($cell->getY() - $this->getCell()->getY()) != 1) {
                throw new CantMoveHereException;
            }
        } elseif ($cell->getY() == $this->getCell()->getY()) {
            if (abs($cell->getX() - $this->getCell()->getX()) != 1) {
                throw new CantMoveHereException;
            }
        } else {
            throw new CantMoveHereException;
        }

        CharacterMapper::getInstance()->move($this, $cell);
        $this->setCell($cell);
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
            $this->setItems(ItemMapper::getInstance()->getByCharacter($this));
        }

        return $this->_items;
    }

    public function setCell(Cell $value) {
        $this->_cell = $value;
        $this->setIdLayout($value->getLayout()->getId());

        return $this;
    }

    /**
     * Возвращает текущую клетку, на которой находится персонаж
     * @return Cell
     */
    public function getCell() {
        if (null == $this->_cell) {
            $this->setCell(new Cell(
                LayoutMapper::getInstance()->getById($this->getIdLayout()),
                $this->_x,
                $this->_y));
        }

        return $this->_cell;
    }

    public function setX($value) {
        if (null != $this->getCell()) {
            $this->getCell()->setX($value);
        }

        parent::setX($value);
    }

    public function getX() {
        return $this->getCell()->getX();
    }

    public function setY($value) {
        if (null != $this->getCell()) {
            $this->getCell()->setY($value);
        }

        parent::setY($value);
    }

    public function getY() {
        return $this->getCell()->getY();
    }

    /**
     * Устанавливает пользователя персонажа
     * @param User $value
     * @return Character
     */
    public function setUser(User $value) {
        $this->_user = $value;
        $this->setIdUser($value->getId());

        return $this;
    }

    public function getUser() {
        if (null == $this->_user) {
            $this->setUser(UserMapper::getInstance()->getById($this->getIdUser()));
        }

        return $this->_user;
    }
}
