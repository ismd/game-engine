<?php
/**
 * Контроллер пользователя
 *
 * @author ismd
 */

class UserController extends PsAuthController {

    public function index() {
        die;
    }

    /**
     * Список персонажей игрока
     */
    public function charactersAction() {
        $characters = array();

        // Преобразуем в массив каждого персонажа
        foreach ($this->getSession()->user->getCharacters() as $character) {
            /* @var $character Character */
            $characters[] = array(
                'id'    => $character->getId(),
                'name'  => $character->getName(),
                'level' => $character->getLevel(),
                'hp'    => $character->getHp(),
                'maxHp' => $character->getMaxHp(),
                'image' => $character->getImage(),
            );
        }

        $this->view->json($characters);
    }
}
