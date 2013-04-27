<?php
/**
 * Контроллер персонажа
 * @author ismd
 */

class CharacterController extends PsAbstractAuthController {

    public function createPartial() {
    }

    /**
     * Создание персонажа
     */
    public function createAction() {
        $post = $this->request->post;

        $character = new Character(array(
            'user' => $this->session->user,
            'name' => $post->name,
        ));

        // Устанавливаем начальные значения
        $character->setDefaultValues();

        $mapper = new CharacterMapper;

        try {
            $id = $mapper->save($character);

            // Добавляем созданного персонажа в список персонажей пользователя
            $this->session->user->characters = array_merge($this->session->user->characters, array(
                $mapper->getById($id),
            ));

            $this->view->json(array(
                'status'  => 'ok',
                'message' => '',
                'id'      => $id,
            ));
        } catch (CharacterMapperLongName $e) {
            $this->view->json(array(
                'status'  => 'error',
                'message' => $e->getMessage(),
            ));
        } catch (CharacterMapperShortName $e) {
            $this->view->json(array(
                'status'  => 'error',
                'message' => $e->getMessage(),
            ));
        } catch (CharacterMapperNameExists $e) {
            $this->view->json(array(
                'status'  => 'error',
                'message' => $e->getMessage(),
            ));
        } catch (Exception $e) {
            $this->view->json(array(
                'status'  => 'error',
                'message' => 'Ошибка',
            ));
        }
    }

    /**
     * Устанавливает текущего персонажа для сессии
     * @post id
     */
    public function setAction() {
        $idCharacter = (int)$this->request->post->id;

        if (!$this->session->user->hasCharacter($idCharacter)) {
            $this->view->json(array(
                'status'  => 'error',
                'message' => 'Ошибка',
            ));
            return;
        }

        $mapper = new CharacterMapper;

        $this->session->character = $mapper->getById($idCharacter);

        $this->view->json(array(
            'status'    => 'ok',
            'message'   => '',
            'character' => $this->session->character->toArray(),
        ));
    }

    /**
     * Перемещение персонажа
     * @post x
     * @post y
     */
    public function moveAction() {
        $post = $this->request->post;

        $x = (int)$post->x;
        $y = (int)$post->y;

        $cell = new Cell($this->session->character->cell->map, $x, $y);

        try {
            $this->session->character->move($cell);

            $this->view->json(array(
                'status'  => 'ok',
                'message' => '',
                'x'       => $cell->x,
                'y'       => $cell->y,
            ));
        } catch (CharacterFastMove $e) {
            $this->view->json(array(
                'status'  => 'error',
                'message' => $e->getMessage(),
            ));
        } catch (CharacterCantMoveHere $e) {
            $this->view->json(array(
                'status'  => 'error',
                'message' => $e->getMessage(),
            ));
        }
    }

    /**
     * Список вещей персонажа
     */
    public function itemsAction() {
        $items = $this->session->character->getItems();

        $data = array();
        foreach ($items as $item) {
            $data[] = $item->toArray();
        }

        $this->view->json($data);
    }
}
