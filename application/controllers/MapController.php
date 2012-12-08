<?php

class MapController extends AbstractAuthController {

    public function index() {
        $this->redirect('/');
    }

    /**
     * ajax: Выводит содержимое текущей клетки
     */
    public function cell() {
        $content = $this->session->character->cell->getContent();

        // Убираем текущего играющего персонажа из списка
        foreach ($content['characters'] as $i => $character) {
            if ($character['id'] == $this->session->character->id) {
                unset($content['characters'][$i]);
                break;
            }
        }

        die(json_encode($content));
    }
}
