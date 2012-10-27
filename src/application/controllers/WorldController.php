<?php
/**
 * Контроллер мира
 *
 * @author ismd
 */

class WorldController extends DefaultAuthController {

    public function init() {
        // У пользователя должен быть выбран персонаж
        if (!isset($this->_session->character)) {
            header('Location: /');
            die;
        }
    }

    public function index() {
        $this->_template->setTitle('Мир');

        $this->_template->css(array(
            'world'
        ));

        $this->_template->js(array(
            'world/world',
            'world/actions'
        ));

        // FIXME: изображение карты по-другому сделать
        //$this->_template->mapImage      = $this->_session->map->image;
        $this->_template->coordinateX = $this->_session->character->coordinateX;
        $this->_template->coordinateY = $this->_session->character->coordinateY;
    }

    public function inventory() {
        $this->_template->items = $this->_session->character->getItems();
    }
}
