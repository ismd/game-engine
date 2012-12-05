<?php
/**
 * Модель авторизации
 */

class Auth extends AbstractDbMapper {

    /**
     * Аутентификация пользователя
     * FIXME: deprecated may be
     *
     * @param string $login
     * @param string $password
     * @return id пользователя|null
     */
    public function login($login, $password) {
        $login    = $this->db->real_escape_string($login);
        $password = md5($password);

        $query = $this->db->query("SELECT id FROM `User` "
            . "WHERE `login` = '$login' AND `password` = '$password' "
            . "LIMIT 1");

        if ($query->num_rows == 0) {
            return;
        }

        $user = $query->fetch_assoc();
        return $user['id'];
    }
}
