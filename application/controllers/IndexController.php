<?php
class IndexController extends AbstractController {

    public function index() {
        $this->_template->logged = !empty($this->_session->user);
    }
}
