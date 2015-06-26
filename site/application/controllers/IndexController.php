<?php
/**
 * Главная страница
 * @author ismd
 */

class IndexController extends PsController {

    public function indexAction() {
        $this->view->controller = $this->registry->router->getController();

        $config = PsConfig::getInstance()->websocket;
        $this->view->ws = [
            'host' => $config->host,
            'port' => $config->port,
        ];
    }
}
