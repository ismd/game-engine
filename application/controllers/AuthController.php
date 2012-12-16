<?php
/**
 * Класс авторизации
 *
 * @author ismd
 */

class AuthController extends AbstractController {
    
    public function init() {
        $this->view->layout = 'empty';
    }

    public function index() {
        $this->redirect('/');
    }

    /**
     * Залогиниваемся
     * 
     * @post login
     * @post password
     */
    public function login() {
        if (empty($_POST['login']) || empty($_POST['password'])) {
            $this->view->result = 'error';
            return;
        }

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
        $this->redirect('/');
    }
}
