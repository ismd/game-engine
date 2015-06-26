<?php
/**
 * @author ismd
 */

class RedirectorActionHelper {

    public function redirect($url) {
        header('Location: ' . $url);
        die;
    }
}
