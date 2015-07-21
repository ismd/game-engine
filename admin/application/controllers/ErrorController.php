<?php
/**
 * @author ismd
 */

class ErrorController extends PsController {

    public function indexAction() {
        $this->view->setLayout('empty');
        $this->getHelper('index')->init($this->registry, $this->view);
    }
}
