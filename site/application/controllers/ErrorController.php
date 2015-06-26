<?php
/**
 * @author ismd
 */

class ErrorController extends PsController {

    public function indexAction() {
        $this->getHelper('redirector')->redirect('/');
    }
}
