<?php
/**
 * @author ismd
 */

class AuthController extends PsController {

    public function loginAction() {
        $this->view->setLayout('empty');
        $this->getHelper('index')->init($this->registry, $this->view);
    }

    public function logoutAction() {
        unset($_COOKIE['user_id']);
        unset($_COOKIE['user_authKey']);

        setcookie('user_id', '', time() - 3600, '/');
        setcookie('user_authKey', '', time() - 3600, '/');

        $this->getHelper('redirector')->redirect('/');
    }
}
