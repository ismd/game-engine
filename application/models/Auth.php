<?php
/**
 * Модель авторизации
 */

class Auth extends AbstractDbMapper {

    /**
     * Аутентификация пользователя
     *
     * @param string $login
     * @param string $password
     * @return id пользователя либо null
     */
    public function login($login, $password) {
        $login      = htmlspecialchars($this->db->real_escape_string($login));
        $password   = md5($password);

        $query = $this->db->query("SELECT id FROM `User` "
            . "WHERE `login`='" . $login . "' AND `password`='" . $password . "' LIMIT 1");

        if ($query->num_rows($query) == 0) {
            return null;
        }

        $user = $this->db->fetch_assoc($query);
        return $user['id'];
    }
}
