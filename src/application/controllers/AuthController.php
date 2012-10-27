<?php
/**
 * Класс авторизации
 *
 * @author ismd
 */

class AuthController extends DefaultController {

    public function index() {
        header('Location: /');
        die;
    }

    /**
     * Залогиниваемся
     * Вызывается через ajax
     */
    public function login() {
        if (empty($_POST['login']) || empty($_POST['password'])) {
            die('error');
        }

        $login      = $_POST['login'];
        $password   = $_POST['password'];

        $auth   = new Auth;
        $id     = $auth->login($login, $password);
        
        if ($id) {
            $mapper = new UserMapper;
            $this->_session->user = $mapper->getById($id);
            die('ok');
        }

        die('error');
    }

    /**
     * Разлогиниваемся
     */
    public function logout() {
        // Проверяем, не в бою ли персонаж
        // FIXME: сделать проверку
        //if () {
        //}

        $this->_session->clear();

        header('Location: /');
        die;
    }
}
