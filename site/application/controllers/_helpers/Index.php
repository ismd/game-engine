<?php
/**
 * @author ismd
 */

class IndexActionHelper {

    public function init($registry, $view) {
        $view->controller = $registry->router->getController();

        $config = PsConfig::getInstance()->websocket;
        $view->ws = [
            'host' => $config->host,
            'port' => $config->port,
        ];
    }
}
