<?php
/**
 * @author ismd
 */

class MobsController extends AbstractAuthController {

    public function indexAction() {
        $this->view->siteUrl = PsConfig::getInstance()->site->url;
    }
}
