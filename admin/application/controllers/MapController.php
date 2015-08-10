<?php
/**
 * @author ismd
 */

class MapController extends AbstractAuthController {

    public function indexAction() {
        $this->view->siteUrl  = PsConfig::getInstance()->site->url;
        $this->view->vicinity = json_decode(file_get_contents(APPLICATION_PATH . '/../../layouts/1.txt'));

        $this->view->cellsSprite = new CellsSprite(PsConfig::getInstance()->site->application_path . '/../public/img/world/cells.png');
    }
}
