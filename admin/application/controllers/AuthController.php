<?php
/**
 * @author ismd
 */

class AuthController extends PsController {

    public function loginAction() {
        $this->view->setLayout('empty');
        $this->getHelper('index')->init($this->registry, $this->view);
    }
}
