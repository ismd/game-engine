<?php
/**
 * Контроллер регистрации
 */

class RegistrationController extends AbstractController {

    public function init() {
        if (null != $this->session->user) {
            $this->redirect('/');
        }
    }

    public function index() {
        if (empty($_POST)) {
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

        try {
            $mapper->save($user);
            $this->view->registered = true;
        } catch (UserMapperLongName $e) {
            $this->view->error = $e->getMessage();
        } catch (UserMapperLongPassword $e) {
            $this->view->error = $e->getMessage();
        } catch (UserMapperNameExists $e) {
            $this->view->error = $e->getMessage();
        } catch (UserMapperPasswordsDontMatch $e) {
            $this->view->error = $e->getMessage();
        } catch (UserMapperShortName $e) {
            $this->view->error = $e->getMessage();
        } catch (UserMapperShortPassword $e) {
            $this->view->error = $e->getMessage();
        } catch (Exception $e) {
            $this->view_error = 'Ошибка';
        }
    }
}
