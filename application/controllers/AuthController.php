<?php
/**
 * Класс авторизации
 *
 * @author ismd
 */

class AuthController extends AbstractController {

    public function init() {
        $this->view->setLayout('empty');
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
        $login    = $this->request->post->login;
        $password = $this->request->post->password;

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
