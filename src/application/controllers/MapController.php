<?php

class MapController extends DefaultAuthController {

    public function index() {
        header('Location: /');
        die;
    }

    /**
     * Вызывается через ajax, отдаёт содержимое текущей клетки
     */
    public function cell() {
        $content = $this->_session->map->currentCell->getContent();

        // Убираем текущего играющего персонажа из списка
        foreach ($content['characters'] as $i => $character) {
            if ($character['id'] == $this->_session->character->id) {
                unset($content['characters'][$i]);
                break;
            }
        }

        die(json_encode($content));
    }
}
