<?php
/**
 * Главная страница
 * @author ismd
 */

class IndexController extends PsController {

    public function index() {
        $this->view->controller = $this->registry->router->getController();

        $session = $this->getSession();
        if (null != $session->user) {
            $this->view->user = $session->user;

            $userCharacters = $session->user->getCharacters();

            $characters = array();
            foreach ($userCharacters as $character) {
                $characters[] = $character->toArray();
            }

            $this->view->userCharacters = $characters;
        }

        if (null != $session->character) {
            $this->view->character = $session->character;
        }
    }
}
