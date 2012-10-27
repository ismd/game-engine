<?php
/**
 * Класс для логирования. Синглтон
 *
 * @author ismd
 */
class Logger {

    private static $instance;
    private $_logPath = '/tmp/ismd-game.log';

    private function __construct() {
    }

    private function __clone() {
    }

    private function __wakeup() {
    }

    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new Logger;
        }
        
        return self::$instance;
    }

    public function log($text) {
        $file = fopen($this->_logPath, 'a');

        if (!is_string($text)) {
            $text = print_r($text, true);
        }

        $text = date('r') . "\t" .  $text . "\n";
        
        fwrite($file, $text);
        fclose($file);
    }
}
