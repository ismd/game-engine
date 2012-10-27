<?php

class ChatController extends DefaultAuthController {

    public function index() {
        die;
    }

    /**
     * Возвращает новые сообщения
     */
    public function get() {
        $id = $_SESSION['user']['character']['id'];

        die(json_encode($this->model->newMessages($id)));
    }

    public function send() {
        $id           = $_SESSION['user']['character']['id'];
        $message      = $_POST['message'];
        $type         = $_POST['type'];
        $idReceiver   = $_POST['idReceiver'];

        $this->_model->send($id, $message, $type, $idReceiver);
        die;
    }
}
