<?php
/**
 * Класс авторизации
 *
 * @author ismd
 */

class AuthController extends AbstractController {

    public function index() {
        $this->redirect('/');
    }

    /**
     * Залогиниваемся
     * Вызывается через ajax
     */
    public function login() {
        if (empty($_POST['login']) || empty($_POST['password'])) {
            die('error');
        }
        
        $this->view->setEmpty(true);

        $login    = $_POST['login'];
        $password = $_POST['password'];

        $mapper = new UserMapper;
        
        try {
            $user = $mapper->getByLoginAndPassword($login, $password);
            $this->session->user = $user;
            
            $this->view->result = 'ok';
        } catch (UserMapperNotFoundException $e) {
            $this->view->result = 'error';
        }
    }

    /**
     * Разлогиниваемся
     */
    public function logout() {
        // Проверяем, не в бою ли персонаж
        // FIXME: сделать проверку
        //if () {
        //}

        $this->session->clear();

        header('Location: /');
        die;
    }
}
