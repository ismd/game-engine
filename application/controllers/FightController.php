<?php

class FightController extends DefaultAuthController {

    public function index() {
        die;
    }

    /**
     * Инициализирует бой
     */
    public function init($args) {
        if (isset($_SESSION['user']['character']['fight'])) {
            die('already in fight');
        }

        $type    = $_GET['type'];
        $idEnemy = $_GET['id'];

        $fight = $this->_model->init($_SESSION['user']['character'], $type, $idEnemy);

        if (!$fight) {
            die('error');
        }

        $_SESSION['user']['character']['fight'] = $fight;
        die('ok');
    }

    /**
     * Выводит json, в котором новая инфа о текущем бое
     */
    public function status() {
        if (!isset($_SESSION['user']['character']['fight'])) {
            die('not in fight');
        }

        $status = $this->_model->status($_SESSION['user']['character']['fight'], $_SESSION['user']['character']);

        if (!empty($status['character']['hp'])) {
            $_SESSION['user']['character']['hp'] = $status['character']['hp'];
        }

        die(json_encode($status));
    }
}
