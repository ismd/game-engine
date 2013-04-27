<?php
/**
 * Класс авторизации
 * @author ismd
 */

class AuthController extends PsAbstractController {

    /**
     * Залогиниваемся
     * @post username
     * @post password
     */
    public function loginAction() {
        if (!$this->request->isPost()) {
            $this->view->json(array(
                'status' => 'error',
            ));
            return;
        }

        $post = $this->request->post;

        $username = $post->username;
        $password = $post->password;

        $mapper = new UserMapper;

        try {
            $user = $mapper->getByLoginAndPassword($username, $password);
            $this->session->user = $user;

            $this->view->json(array(
                'status' => 'ok',
                'user'   => $this->session->user->toArray(),
            ));
        } catch (UserMapperNotFoundException $e) {
            $this->view->json(array(
                'status' => 'error',
            ));
        }
    }

    /**
     * Разлогиниваемся
     */
    public function logoutAction() {
        // Проверяем, не в бою ли персонаж
        // FIXME: сделать проверку
        //if () {
        //}

        $this->session->clear();

        $this->view->json(array(
            'status' => 'ok',
        ));
    }
}
