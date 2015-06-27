<?php
/**
 * Главная страница
 * @author ismd
 */

class IndexController extends PsController {

    public function indexAction() {
        $this->getHelper('index')->init($this->registry, $this->view);
    }
}
