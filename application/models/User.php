<?php
/**
 * Класс пользователя
 *
 * @author ismd
 */

class User extends AbstractUser {

    protected $_characters;

    public function setCharacters($value) {
        $this->_characters = (array)$value;
        return $this;
    }

    /**
     * Возвращает массив персонажей пользователя
     *
     * @return array Массив объектов класса Character
     */
    public function getCharacters() {
        if (null == $this->_characters) {
            $mapper           = new CharacterMapper;
            $this->characters = $mapper->getByUser($this->id);
        }

        return $this->_characters;
    }

    /**
     * Проверяет, есть ли у пользователя персонаж
     *
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
}
