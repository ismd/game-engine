<?php
/**
 * Контроллер регистрации
 * @author ismd
 */

class RegistrationController extends PsController {

    public function init() {
        if (null != $this->getSession()->user) {
            die;
        }
    }

    public function indexPartial() {
    }
}
