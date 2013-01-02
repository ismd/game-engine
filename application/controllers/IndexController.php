<?php
class IndexController extends AbstractController {

    public function index() {
        $this->view->appendJs('require', array(
            'data-main' => 'js/main',
        ));
    }
}
