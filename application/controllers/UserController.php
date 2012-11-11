<?php
/**
 * Контроллер пользователя
 *
 * @author ismd
 */

class UserController extends AbstractController {

    public function index() {
        header('Location: /');
        die;
    }

    /**
     * ajax: список персонажей игрока
     */
    public function characters() {
        $characters = $this->_session->user->getCharacters();

        // Преобразуем в массив каждого персонажа
        foreach ($characters as $i => $character) {
            $characters[$i] = $character->toArray();
        }

        die(json_encode($characters));
    }
}
