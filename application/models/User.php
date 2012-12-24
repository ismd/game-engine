<?php
/**
 * Класс пользователя
 *
 * @author ismd
 */

class User extends AbstractUser {
    
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
            $mapper           = new CharacterMapper;
            $this->characters = $mapper->getByUser($this);
        }

        return $this->_characters;
    }

    /**
     * Проверяет, есть ли у пользователя персонаж
     *
     * @todo Подумать, может переделать или убрать этот метод
     * @param int $idCharacter
     * @return bool
     */
    public function hasCharacter($idCharacter) {
        $idCharacter = (int)$idCharacter;
        $characters  = $this->characters;

        foreach ($characters as $character) {
            if ($character->id == $idCharacter) {
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
