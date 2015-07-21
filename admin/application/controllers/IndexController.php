<?php
/**
 * Главная страница
 * @author ismd
 */

class IndexController extends AbstractAuthController {

    public function indexAction() {
        $this->getHelper('index')->init($this->registry, $this->view);
    }
}
