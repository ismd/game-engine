<?php

const M_COMMON  = 1;
const M_PRIVATE = 2;
const M_SYSTEM  = 3;
const M_GLOBAL  = 4;

class ChatModel extends DefaultModel {
    public function newMessages($id) {
        $id = intval($id);

        $query = mysql_query("SELECT message, type, idSender, sended FROM Chat"
                . " WHERE idReceiver=$id OR type=" . M_COMMON . " OR type=" . M_SYSTEM . " OR type=" . M_GLOBAL);

        $messages = array();
        while ($message = mysql_fetch_assoc($query)) {
            $messages[] = $message;
        }

        return $messages;
    }

    public function send($id, $message, $type, $idReceiver = null) {
        $id        = intval($id);
        $message   = strip_tags(mysql_real_escape_string($message));
        $type      = intval($type);

        mysql_query("INSERT INTO Chat (message, type, idSender, sended) VALUES ($message, $type, $id, " . time() . ")");
    }
}
