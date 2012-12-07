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

    public function index() {
        $this->view->setTitle('Мир');

        $this->view->css(array(
            'world'
        ));

        $this->view->js(array(
            'world/world',
            'world/actions',
        ));

        // FIXME: изображение карты по-другому сделать
        //$this->_template->mapImage      = $this->_session->map->image;
        $this->view->x = $this->session->character->cell->x;
        $this->view->y = $this->session->character->cell->y;
    }

    public function inventory() {
        $this->view->items = $this->session->character->getItems();
    }
}
