<?php
/**
 * Контроллер регистрации
 */

class RegistrationController extends DefaultController {

    public function init() {
        if ( isset($this->_session->user) ) {
            header('Location: /');
            die;
        }
    }

    public function index() {
        if ( !empty ($_POST) ) {
            $user = array();

            $user['login']       = (!empty($_POST['login'])) ? $_POST['login'] : '';
            $user['password']    = (!empty($_POST['password'])) ? $_POST['password'] : '';
            $user['password1']   = (!empty($_POST['password1'])) ? $_POST['password1'] : '';
            $user['email']       = (!empty($_POST['email'])) ? $_POST['email'] : '';
            $user['info']        = (!empty($_POST['info'])) ? $_POST['info'] : '';
            $user['site']        = (!empty($_POST['site'])) ? $_POST['site'] : '';

            $user = new User($user);

            $mapper = new UserMapper;
            $this->_template->error = $mapper->save($user);
        }
    }
}
