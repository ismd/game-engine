<?php
/**
 * Контроллер регистрации
 */

class RegistrationController extends AbstractController {

    public function init() {
        if (isset($this->_session->user)) {
            header('Location: /');
            die;
        }
    }

    public function index() {
        if (empty ($_POST)) {
            return;
        }

        $user = array(
            'login'     => !empty($_POST['login']) ? $_POST['login'] : '',
            'password'  => !empty($_POST['password']) ? $_POST['password'] : '',
            'password1' => !empty($_POST['password1']) ? $_POST['password1'] : '',
            'email'     => !empty($_POST['email']) ? $_POST['email'] : '',
            'info'      => !empty($_POST['info']) ? $_POST['info'] : '',
            'site'      => !empty($_POST['site']) ? $_POST['site'] : '',
        );

        $user   = new User($user);
        $mapper = new UserMapper;

        $this->_template->error = $mapper->save($user);
    }
}
