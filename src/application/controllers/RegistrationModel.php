<?php
/**
 * Модель регистрации
 */

class RegistrationModel extends DefaultModel {

    /**
     * Проверяет правильность введённых данных
     *
     * @param mixed $data - массив из формы (post)
     */
    public function check($data) {
        $login       = mysql_real_escape_string($data['login']);
        $password    = md5($data['password']);
        $password1   = md5($data['password1']);

        if (!preg_match('/[[:alpha:]][[:alnum:]]{2,14}/Ui', $login) || $login != $data['login']) {
            return 1;
        }

        if (mb_strlen($data['password']) < 8) {
            return 3;
        }

        if ($password != $password1) {
            return 4;
        }

        // Проверяем не зарегистрирован ли уже пользователь с таким логином
        $result = mysql_query("SELECT * FROM `User` WHERE `login`='$login' LIMIT 1");

        if (mysql_num_rows($result) == 0) {
            return 0;
        } else {
            return 2;
        }
    }

    public function register($data) {
        $login      = mysql_real_escape_string($data['login']);
        $password   = md5($data['password']);

        mysql_query("INSERT INTO `User` (`login`, `password`) VALUES ('$login', '$password')");
    }
}
