<?php
/**
 * @author ismd
 */

class ErrorController extends PsController {

    public function indexAction() {
        $this->getHelper('index')->init($this->registry, $this->view);
    }
}
