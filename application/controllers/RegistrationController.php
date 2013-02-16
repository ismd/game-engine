<?php
/**
 * Контроллер регистрации
 */

class RegistrationController extends PsAbstractController {

    public function init() {
        if (null != $this->session->user) {
            $this->redirect('/');
        }
    }

    public function indexPartial() {
        $request = $this->getRequest();
        
        if (false == $request->isPost()) {
            return;
        }

        $this->view->request = $request;

        $user = new User(array(
            'login'     => $request->post->login,
            'password'  => $request->post->password,
            'password1' => $request->post->password1,
            'email'     => $request->post->email,
            'info'      => $request->post->info,
            'site'      => $request->post->site,
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
            $this->view->error = 'Ошибка';
        }
    }
}
