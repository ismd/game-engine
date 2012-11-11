<?php
class IndexController extends DefaultController {

    public function index() {
        $this->_template->logged = !empty($this->_session->user);
    }
}
