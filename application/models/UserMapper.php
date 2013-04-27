<?php
/**
 * Модель пользователя
 * @author ismd
 */

class UserMapperNotFoundException extends Exception {
    protected $message = 'Персонаж не найден';
};

class UserMapperBadLoginOrPasswordException extends Exception {
    protected $message = 'Неверный логин или пароль';
}

class UserMapperLongLogin extends Exception {
    protected $message = 'Логин не может быть длиннее 30 символов';
};

class UserMapperShortLogin extends Exception {
    protected $message = 'Логин не может быть короче 4 символов';
};

class UserMapperLoginExists extends Exception {
    protected $message = 'Введённый логин уже занят';
};

class UserMapperShortPassword extends Exception {
    protected $message = 'Пароль не может быть короче 6 символов';
};

class UserMapperPasswordsDontMatch extends Exception {
    protected $message = 'Введённые пароли не совпадают';
};

class UserMapper extends PsAbstractDbMapper {

    /**
     * Возвращает пользователя по id
     * @param int $id
     * @return User
     * @throws UserMapperNotFoundException
     */
    public function getById($id) {
        $id = (int)$id;

        $query = $this->db->query("SELECT id, login, email, info, site, "
            . "registered "
            . "FROM User "
            . "WHERE id = $id "
            . "LIMIT 1");

        if ($query->num_rows == 0) {
            throw new UserMapperNotFoundException;
        }

        return new User($query->fetch_assoc());
    }

    /**
     * Возвращает пользователя по логину
     * Не рекомендуется использовать данный метод
     * Необходимо использовать только в случае проверки на занятость логина
     * @param string $login
     * @return User
     * @throws UserMapperNotFoundException
     */
    public function getByLogin($login) {
        $login = $this->db->real_escape_string($login);

        $query = $this->db->query("SELECT id, login, email, info, site, "
            . "registered "
            . "FROM `User` "
            . "WHERE login = '$login' "
            . "LIMIT 1");

        if ($query->num_rows == 0) {
            throw new UserMapperNotFoundException;
        }

        return new User($query->fetch_assoc());
    }

    /**
     * Создаёт либо изменяет пользователя
     * @param User $user
     * @throws UserMapperLongLogin
     * @throws UserMapperShortLogin
     * @throws UserMapperLoginExists
     * @throws UserMapperLongPassword
     * @throws UserMapperShortPassword
     * @throws UserMapperPasswordsDontMatch
     */
    public function save(User $user) {
        // FIXME: валидация
        if (mb_strlen($user->login) > 30) {
            throw new UserMapperLongLogin;
        }

        if (mb_strlen($user->login) < 4) {
            throw new UserMapperShortLogin;
        }

        // Проверяем, не занят ли логин
        try {
            $this->getByLogin($user->login);
            throw new UserMapperLoginExists;
        } catch (UserMapperNotFoundException $e) {
        }

        if (mb_strlen($user->password) < 6) {
            throw new UserMapperShortPassword;
        }

        if ($user->password != $user->password1) {
            throw new UserMapperPasswordsDontMatch;
        }

        $user->login    = htmlspecialchars($this->db->real_escape_string($user->login));
        $user->password = md5($user->password);
        $user->email    = htmlspecialchars($this->db->real_escape_string($user->email));
        $user->info     = htmlspecialchars($this->db->real_escape_string($user->info));
        $user->site     = htmlspecialchars($this->db->real_escape_string($user->site));

        if (null == $user->id) {
            $this->db->query("INSERT INTO User "
                . "(login, password, email, info, site, registered) "
                . "VALUES "
                . "('$user->login', '$user->password', '$user->email', "
                . "'$user->info', '$user->site', NOW())");
        } else {
            $this->db->query("UPDATE User "
                . "SET password = '$user->password', email = '$user->email', "
                . "info = '$user->info', site = '$user->site'");
        }
    }

    /**
     * Возвращает пользователя по логину и паролю
     * Необходимо использовать только при аутентификации
     * @param string $login
     * @param string $password
     * @return User
     * @throws UserMapperBadLoginOrPasswordException
     */
    public function getByLoginAndPassword($login, $password) {
        $login    = $this->db->real_escape_string($login);
        $password = md5($password);

        $query = $this->db->query("SELECT id, login, email, info, site, "
            . "registered "
            . "FROM `User` "
            . "WHERE login = '$login' AND password = '$password' "
            . "LIMIT 1");

        if ($query->num_rows == 0) {
            throw new UserMapperBadLoginOrPasswordException;
        }

        return new User($query->fetch_assoc());
    }
}
