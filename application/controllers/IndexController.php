<?php
/**
 * Главная страница
 * @author ismd
 */

class IndexController extends PsAbstractController {

    public function index() {
        $this->view->controller = $this->registry->router->getController();

        if (null != $this->session->user) {
            $this->view->user = $this->session->user;
        }

        if (null != $this->session->character) {
            $this->view->character = $this->session->character;
        }
    }
}
