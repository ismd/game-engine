<?php
/**
 * Модель пользователя
 *
 * @author ismd
 */

class UserMapper {

    /**
     * Возвращает пользователя по id
     *
     * @param int $id
     */
    public function getById($id) {
        $id = (int)$id;

        $query = mysql_query("SELECT id, login, email, info, site, registered "
                           . "FROM `User` WHERE id=$id LIMIT 1");

        if (mysql_num_rows($query) == 0) {
            return null;
        }

        return new User(mysql_fetch_assoc($query));
    }

    /**
     * Возвращает пользователя по логину
     * Не рекомендуется использовать данный метод
     * Необходимо использовать только в случае проверки на занятость логина
     *
     * @param string $login
     */
    public function getByLogin($login) {
        $login = htmlspecialchars(mysql_real_escape_string($login));

        $query = mysql_query("SELECT id, login, email, info, site, registered "
                           . "FROM `User` WHERE login='$login' LIMIT 1");

        if (mysql_num_rows($query) == 0) {
            return null;
        }

        return new User(mysql_fetch_assoc($query));
    }

    /**
     * Возвращает массив персонажей пользователя
     *
     * @param int $id
     * @return array
     */
    public function getUserCharacters($id) {
        $id = (int)$id;

        $query = mysql_query("SELECT id, idUser, name, level, money, idMap, coordinateX, coordinateY, "
                           . "strength, dexterity, endurance, hp, maxHp, minDamage, maxDamage, image, experience "
                           . "FROM `Character` WHERE idUser=$id");

        $characters = array();
        while ($character = mysql_fetch_assoc($query)) {
            $characters[] = new Character($character);
        }

        return $characters;
    }

    public function save(User $user) {
        // TODO: валидация

        if (mb_strlen($user->login) > 30) {
            return User::REG_ERR_LOGIN_LENGTH_MAX;
        }

        if (mb_strlen($user->login) < 4) {
            return User::REG_ERR_LOGIN_LENGTH_MIN;
        }

        // FIXME: preg_match
        if (false) {
            return User::REG_ERR_LOGIN_BAD;
        }

        // Проверяем, не занят ли логин
        if ( $this->getByLogin($user->login) != null ) {
            return User::REG_ERR_LOGIN_EXISTS;
        }

        if (mb_strlen($user->password) > 30) {
            return User::REG_ERR_PASSWORD_LENGTH_MAX;
        }

        if (mb_strlen($user->password) < 8) {
            return User::REG_ERR_PASSWORD_LENGTH_MIN;
        }

        // FIXME: preg_match
        if (false) {
            return User::REG_ERR_PASSWORD_BAD;
        }

        if ($user->password != $user->password1) {
            return User::REG_ERR_PASSWORD_UNMATCH;
        }

        $user->login      = htmlspecialchars(mysql_real_escape_string($user->login));
        $user->password   = md5($user->password);
        $user->email      = htmlspecialchars(mysql_real_escape_string($user->email));
        $user->info       = htmlspecialchars(mysql_real_escape_string($user->info));
        $user->site       = htmlspecialchars(mysql_real_escape_string($user->site));

        if ( empty($user->id) ) {
            mysql_query("INSERT INTO User (login, password, email, info, site, registered) "
                    . "VALUES ('$user->login', '$user->password', '$user->email', '$user->info', '$user->site', NOW())");
        } else {
            mysql_query("UPDATE User SET password='$user->password', email='$user->email', info='$user->info', "
                      . "site='$user->site'");
        }

        return true;
    }
}
