<?php
/**
 * Контроллер регистрации
 */

class RegistrationController extends PsAbstractController {

    public function init() {
        if (null != $this->session->user) {
            die;
        }
    }

    public function indexPartial() {
    }

    /**
     * Регистрация пользователя
     */
    public function registerAction() {
        $post = $this->request->post;

        $user = new User(array(
            'login'     => $post->login,
            'password'  => $post->password,
            'password1' => $post->password1,
            'email'     => $post->email,
            'info'      => $post->info,
            'site'      => $post->site,
        ));

        $mapper = new UserMapper;

        try {
            $mapper->save($user);
            $this->view->json(array(
                'status'  => 'ok',
                'message' => '',
            ));
        } catch (UserMapperLongLogin $e) {
            $this->view->json(array(
                'status'  => 'error',
                'message' => $e->getMessage(),
            ));
        } catch (UserMapperLoginExists $e) {
            $this->view->json(array(
                'status'  => 'error',
                'message' => $e->getMessage(),
            ));
        } catch (UserMapperPasswordsDontMatch $e) {
            $this->view->json(array(
                'status'  => 'error',
                'message' => $e->getMessage(),
            ));
        } catch (UserMapperShortLogin $e) {
            $this->view->json(array(
                'status'  => 'error',
                'message' => $e->getMessage(),
            ));
        } catch (UserMapperShortPassword $e) {
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
}
