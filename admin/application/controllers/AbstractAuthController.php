<?php
/**
 * @author ismd
 */

require_once APPLICATION_PATH . '/../lib/autoload.php';

use WebSocket\Client;

abstract class AbstractAuthController extends PsController {

    public function init() {
        $this->getHelper('index')->init($this->registry, $this->view);

        if (empty($_COOKIE['user_id']) || empty($_COOKIE['user_authKey'])) {
            $this->getHelper('redirector')->redirect('/auth/login');
        }

        if (!$this->_checkAuth($_COOKIE['user_id'], $_COOKIE['user_authKey'])) {
            $this->getHelper('redirector')->redirect('/auth/login');
        }
    }

    private function _checkAuth($id, $authKey) {
        $config = PsConfig::getInstance();

        $client = new Client('ws://' . $config->websocket->host . ':' . $config->websocket->port);

        $client->send(json_encode([
            'controller' => 'User',
            'action' => 'loginByAuthKey',
            'args' => [
                'id' => $id,
                'authKey' => $authKey,
                'admin' => true,
            ],
        ]));

        try {
            $json = json_decode($client->receive());
        } catch (WebSocket\ConnectionException $e) {
            die('Не удалось подключиться к серверу');
        }

        if (!$json->status) {
            return false;
        }

        setcookie('user_id', $json->data->user->id, 0, '/');
        setcookie('user_authKey', $json->data->user->authKey, 0, '/');
        return true;
    }
}
