<?php
/**
 * @author ismd
 */

class IndexActionHelper {

    public function init($registry, $view) {
        $config = PsConfig::getInstance()->websocket;

        $view->ws = [
            'host' => $config->host,
            'port' => $config->port,
        ];
    }
}
