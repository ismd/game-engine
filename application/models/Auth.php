<?php
/**
 * Модель авторизации
 */

class Auth {

    /**
     * Аутентификация пользователя
     *
     * @param string $login
     * @param string $password
     * @return id пользователя либо null
     */
    public function login($login, $password) {
        $login      = htmlspecialchars(mysql_real_escape_string($login));
        $password   = md5($password);

        $query      = mysql_query("SELECT id FROM `User` "
                                . "WHERE `login`='" . $login . "' AND `password`='" . $password . "' LIMIT 1");

        if (mysql_num_rows($query) == 0) {
            return null;
        }

        $user = mysql_fetch_assoc($query);
        return $user['id'];
    }
}
