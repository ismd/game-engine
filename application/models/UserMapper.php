<?php
/**
 * Модель пользователя
 *
 * @author ismd
 */

class UserMapperNotFoundException extends Exception {
    protected $message = 'Персонаж не найден';
};

class UserMapperLongName extends Exception {
    protected $message = 'Имя слишком длинное';
};

class UserMapperShortName extends Exception {
    protected $message = 'Имя слишком короткое';
};

class UserMapperNameExists extends Exception {
    protected $message = 'Персонаж с таким именем уже существует';
};

class UserMapperLongPassword extends Exception {
    protected $message = 'Пароль слишком длинный';
};

class UserMapperShortPassword extends Exception {
    protected $message = 'Пароль слишком короткий';
};

class UserMapperPasswordsDontMatch extends Exception {
    protected $message = 'Пароли не совпадают';
};

class UserMapper extends AbstractDbMapper {

    /**
     * Возвращает пользователя по id
     *
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
     *
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
     *
     * @param User $user
     * @throws UserMapperLongName
     * @throws UserMapperShortName
     * @throws UserMapperNameExists
     * @throws UserMapperLongPassword
     * @throws UserMapperShortPassword
     * @throws UserMapperPasswordsDontMatch
     */
    public function save(User $user) {
        // FIXME: валидация

        if (mb_strlen($user->login) > 30) {
            throw new UserMapperLongName;
        }

        if (mb_strlen($user->login) < 4) {
            throw new UserMapperShortName;
        }

        // Проверяем, не занят ли логин
        try {
            $this->getByLogin($user->login);
            throw new UserMapperNameExists;
        } catch (UserMapperNotFoundException $e) {
        }

        if (mb_strlen($user->password) > 30) {
            throw new UserMapperLongPassword;
        }

        if (mb_strlen($user->password) < 8) {
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
}
