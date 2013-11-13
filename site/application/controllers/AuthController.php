<?php
/**
 * Класс авторизации
 * @author ismd
 */

class AuthController extends PsController {

    /**
     * Залогиниваемся
     * @post username
     * @post password
     */
    public function loginAction() {
        $post = $this->getRequest()->getPost();

        $username = $post->username;
        $password = $post->password;

        $mapper = UserMapper::getInstance();

        try {
            $user = $mapper->getByLoginAndPassword($username, $password);
            $this->getSession()->user = $user;

            $this->view->json(array(
                'status'  => 'ok',
                'message' => '',
                'user'    => $user->toArray(),
            ));
        } catch (UserBadLoginOrPasswordException $e) {
            $this->view->json(array(
                'status'  => 'error',
                'message' => $e->getMessage(),
            ));
        } catch (Exception $e) {
            $this->view->json(array(
                'status'  => 'error',
                'message' => 'Ошибка',
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

        $this->getSession()->clear();

        $this->view->json(array(
            'status' => 'ok',
        ));
    }
}
