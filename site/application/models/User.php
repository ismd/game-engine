<?php
/**
 * Класс пользователя
 * @author ismd
 */

class User extends Abstract_User {

    /**
     * Персонажи пользователя
     * @var Character[]
     */
    protected $_characters;

    /**
     * Нужно для проверки совпадения паролей
     * @var string
     */
    protected $_password1;

    public function setCharacters($value) {
        $this->_characters = (array)$value;
        return $this;
    }

    /**
     * Возвращает массив персонажей пользователя
     * @return Character[]
     */
    public function getCharacters() {
        if (null == $this->_characters) {
            $this->setCharacters(CharacterMapper::getInstance()->getByUser($this));
        }

        return $this->_characters;
    }

    /**
     * Проверяет, есть ли у пользователя персонаж
     * @todo Подумать, может переделать или убрать этот метод
     * @param int $idCharacter
     * @return bool
     */
    public function hasCharacter($idCharacter) {
        $idCharacter = (int)$idCharacter;

        foreach ($this->getCharacters() as $character) {
            if ($character->getId() == $idCharacter) {
                return true;
            }
        }

        return false;
    }

    public function setPassword1($value) {
        $this->_password1 = (string)$value;
        return $this;
    }

    public function getPassword1() {
        return $this->_password1;
    }
}
