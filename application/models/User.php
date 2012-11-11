<?php
/**
 * Класс пользователя
 *
 * @author ismd
 */

class User extends AbstractUser {

    const REG_ERR_LOGIN_EXISTS          = 1;
    const REG_ERR_LOGIN_LENGTH_MAX      = 2;
    const REG_ERR_LOGIN_LENGTH_MIN      = 3;
    const REG_ERR_LOGIN_BAD             = 4;
    const REG_ERR_PASSWORD_LENGTH_MAX   = 5;
    const REG_ERR_PASSWORD_LENGTH_MIN   = 6;
    const REG_ERR_PASSWORD_BAD          = 7;
    const REG_ERR_PASSWORD_UNMATCH      = 8;

    /**
     * Возвращает массив персонажей пользователя
     *
     * @return array(Character)
     */
    public function getCharacters() {
        $mapper = new UserMapper;
        return $mapper->getUserCharacters($this->_id);
    }

    /**
     * Проверяет, есть ли у пользователя персонаж
     *
     * @param int $idCharacter
     */
    public function hasCharacter($idCharacter) {
        $this->getCharacters();

        foreach ($this->_characters as $character) {
            if ($character->id == $idCharacter) {
                return true;
            }
        }

        return false;
    }
}
