<?php
class IndexController extends AbstractController {

    public function index() {
        $this->view->logged = !empty($this->session->user);
    }
}
