<?php
/**
 * Контроллер мира
 *
 * @author ismd
 */

class WorldController extends PsAbstractAuthController {

    public function init() {
        // У пользователя должен быть выбран персонаж
        if (null == $this->session->character) {
            die;
        }
    }

    /**
     * Главная страница мира
     */
    public function indexPartial() {
        $this->view->cell = $this->session->character->cell;
    }

    /**
     * Страница инвентаря
     */
    public function inventoryPartial() {
        $this->view->items = $this->session->character->items;
    }
}
