<?php
/**
 * Класс авторизации
 * @author ismd
 */

class AuthController extends PsAbstractController {

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
        $post = $this->getRequest()->getPost();

        $username = $post->username;
        $password = $post->password;

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
