<?php
/**
 * @author ismd
 */

class NpcsController extends AbstractAuthController {

    public function indexAction() {
        $this->view->siteUrl  = PsConfig::getInstance()->site->url;
        $this->view->vicinity = json_decode(file_get_contents(APPLICATION_PATH . '/../../layouts/1.txt'));
    }
}
