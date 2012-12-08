<?php
/**
 * Контроллер мира
 *
 * @author ismd
 */

class WorldController extends AbstractAuthController {

    public function init() {
        // У пользователя должен быть выбран персонаж
        if (null == $this->session->character) {
            $this->redirect('/');
        }
    }

    /**
     * Главная страница мира
     */
    public function index() {
        $this->view->setTitle('Мир');

        $this->view->css(array(
            'world'
        ));

        $this->view->js(array(
            'world/world',
            'world/actions',
        ));
        
        $character = $this->session->character;

        $this->view->map  = $character->map;
        $this->view->cell = $character->cell;
    }

    /**
     * Страница инвентаря
     */
    public function inventory() {
        $this->view->items = $this->session->character->items;
    }
}
