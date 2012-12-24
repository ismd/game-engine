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
        if (false == $this->request->isPost()) {
            return;
        }

        $user = new User(array(
            'login'     => $this->request->post->login,
            'password'  => $this->request->post->password,
            'password1' => $this->request->post->password1,
            'email'     => $this->request->post->email,
            'info'      => $this->request->post->info,
            'site'      => $this->request->post->site,
        ));
        
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
