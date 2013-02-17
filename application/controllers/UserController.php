<?php
/**
 * Контроллер пользователя
 *
 * @author ismd
 */

class UserController extends PsAbstractAuthController {

    public function index() {
        $this->redirect('/');
    }

    /**
     * Список персонажей игрока
     */
    public function charactersAction() {
        $characters = $this->session->user->characters;

        // Преобразуем в массив каждого персонажа
        foreach ($characters as $i => $character) {
            $characters[$i] = array(
                'id'    => $character->id,
                'name'  => $character->name,
                'level' => $character->level,
                'hp'    => $character->hp,
                'maxHp' => $character->maxHp,
                'image' => $character->image,
            );
        }

        $this->view->json($characters);
    }
}
