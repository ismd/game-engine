<?php
/**
 * Контроллер мира
 *
 * @author ismd
 */

class WorldController extends PsAuthController {

    public function init() {
        // У пользователя должен быть выбран персонаж
        if (null == $this->getSession()->character) {
            die;
        }
    }

    /**
     * Главная страница мира
     */
    public function indexPartial() {
        $this->view->cell = $this->getSession()->character->getCell();
    }

    /**
     * Страница инвентаря
     */
    public function inventoryPartial() {
        $this->view->items = $this->getSession()->character->getItems();
    }
}
