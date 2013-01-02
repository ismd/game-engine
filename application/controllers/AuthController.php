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
     * @post username
     * @post password
     */
    public function login() {
        $username = $this->request->post->username;
        $password = $this->request->post->password;

        $mapper = new UserMapper;

        try {
            $user = $mapper->getByLoginAndPassword($username, $password);
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
