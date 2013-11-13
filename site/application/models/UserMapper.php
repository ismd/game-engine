<?php
/**
 * @author ismd
 */

class UserNotFoundException extends Exception {
    protected $message = 'Пользователь не найден';
};

class UserBadLoginOrPasswordException extends Exception {
    protected $message = 'Неверный логин или пароль';
}

class UserLongLoginException extends Exception {
    protected $message = 'Логин не может быть длиннее 30 символов';
};

class UserShortLoginException extends Exception {
    protected $message = 'Логин не может быть короче 4 символов';
};

class UserLoginExistsException extends Exception {
    protected $message = 'Введённый логин уже занят';
};

class UserShortPasswordException extends Exception {
    protected $message = 'Пароль не может быть короче 6 символов';
};

class UserPasswordsDontMatchException extends Exception {
    protected $message = 'Введённые пароли не совпадают';
};

class UserMapper extends PsDbMapper {

    /**
     * Возвращает пользователя по id
     * @param int $id
     * @return User
     * @throws UserNotFoundException
     */
    public function getById($id) {
        $id = (int)$id;

        $stmt = $this->db->prepare("SELECT id, login, email, info, site, registered "
            . "FROM User "
            . "WHERE id = ? "
            . "LIMIT 1");

        $stmt->bind_param('d', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if (0 == $result->num_rows) {
            throw new UserNotFoundException;
        }

        return new User($result->fetch_assoc());
    }

    /**
     * Возвращает пользователя по логину
     * Не рекомендуется использовать данный метод
     * Необходимо использовать только в случае проверки на занятость логина
     * @param string $login
     * @return User
     * @throws UserNotFoundException
     */
    public function getByLogin($login) {
        $stmt = $this->db->prepare("SELECT id, login, email, info, site, registered "
            . "FROM `User` "
            . "WHERE login = ? "
            . "LIMIT 1");

        $stmt->bind_param('s', $login);
        $stmt->execute();
        $result = $stmt->get_result();

        if (0 == $result->num_rows) {
            throw new UserNotFoundException;
        }

        return new User($result->fetch_assoc());
    }

    /**
     * Создаёт либо изменяет пользователя
     * @param User $user
     * @throws UserLongLoginException
     * @throws UserShortLoginException
     * @throws UserLoginExistsException
     * @throws UserMapperLongPassword
     * @throws UserShortPasswordException
     * @throws UserPasswordsDontMatchException
     */
    public function save(User $user) {
        $login = $user->getLogin();

        // FIXME: валидация
        if (mb_strlen($login) > 30) {
            throw new UserLongLoginException;
        }

        if (mb_strlen($login) < 4) {
            throw new UserShortLoginException;
        }

        // Проверяем, не занят ли логин
        try {
            $this->getByLogin($login);
            throw new UserLoginExistsException;
        } catch (UserNotFoundException $e) {
        }

        if (mb_strlen($user->getPassword()) < 6) {
            throw new UserShortPasswordException;
        }

        if ($user->getPassword() != $user->getPassword1()) {
            throw new UserPasswordsDontMatchException;
        }

        $user->setPassword(md5($user->getPassword()));

        if (null == $user->getId()) {
            $stmt = $this->db->prepare("INSERT INTO `User` "
                . "(login, password, email, info, site, registered) VALUES "
                . "(?, ?, ?, ?, ?, NOW())");

            $stmt->bind_param('sssss',
                $user->getLogin(),
                $user->getPassword(),
                $user->getEmail(),
                $user->getInfo(),
                $user->getSite());
        } else {
            $stmt = $this->db->prepare("UPDATE User "
                . "SET password = ?, email = ?, info = ?, site = ? "
                . "WHERE id = ?");

            $stmt->bind_param('ssssd',
                $user->getPassword(),
                $user->getEmail(),
                $user->getInfo(),
                $user->getSite(),
                $user->getId());
        }

        $stmt->execute();
    }

    /**
     * Возвращает пользователя по логину и паролю
     * Необходимо использовать только при аутентификации
     * @param string $login
     * @param string $password
     * @return User
     * @throws UserBadLoginOrPasswordException
     */
    public function getByLoginAndPassword($login, $password) {
        $password = md5($password);

        $stmt = $this->db->prepare("SELECT id, login, email, info, site, registered "
            . "FROM `User` "
            . "WHERE login = ? AND password = ? "
            . "LIMIT 1");

        $stmt->bind_param('ss', $login, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if (0 == $result->num_rows) {
            throw new UserBadLoginOrPasswordException;
        }

        return new User($result->fetch_assoc());
    }
}
