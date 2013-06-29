<?php
/**
 * Контроллер персонажа
 * @author ismd
 */

class CharacterController extends PsAuthController {

    public function createPartial() {
    }

    /**
     * Создание персонажа
     */
    public function createAction() {
        $post = $this->getRequest()->post;

        $character = new Character(array(
            'user' => $this->getSession()->user,
            'name' => $post->name,
        ));

        // Устанавливаем начальные значения
        $character->setDefaultValues();

        try {
            $mapper = CharacterMapper::getInstance();
            $id = $mapper->save($character);

            // Добавляем созданного персонажа в список персонажей пользователя
            $this->getSession()->user->characters = array_merge(
                $this->getSession()->user->characters,
                array($mapper->getById($id))
            );

            $this->view->json(array(
                'status'  => 'ok',
                'message' => '',
                'id'      => $id,
            ));
        } catch (CharacterLongNameException $e) {
            $this->view->json(array(
                'status'  => 'error',
                'message' => $e->getMessage(),
            ));
        } catch (CharacterShortNameException $e) {
            $this->view->json(array(
                'status'  => 'error',
                'message' => $e->getMessage(),
            ));
        } catch (CharacterNameExistsException $e) {
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
        $idCharacter = (int)$this->getRequest()->getPost()->id;

        if (!$this->getSession()->user->hasCharacter($idCharacter)) {
            $this->view->json(array(
                'status'  => 'error',
                'message' => 'Ошибка',
            ));
            return;
        }

        $this->getSession()->character = CharacterMapper::getInstance()->getById($idCharacter);

        $this->view->json(array(
            'status'    => 'ok',
            'message'   => '',
            'character' => $this->getSession()->character->toArray(),
        ));
    }

    /**
     * Перемещение персонажа
     * @post x
     * @post y
     */
    public function moveAction() {
        $post = $this->getRequest()->post;

        $x = (int)$post->x;
        $y = (int)$post->y;

        $cell = new Cell($this->getSession()->character->getCell()->getMap(), $x, $y);

        try {
            $this->getSession()->character->move($cell);

            $this->view->json(array(
                'status'  => 'ok',
                'message' => '',
                'x'       => $cell->x,
                'y'       => $cell->y,
                'map'     => json_encode($this->getSession()->character->getCell()->getVicinity()),
            ));
        } catch (FastMoveException $e) {
            $this->view->json(array(
                'status'  => 'error',
                'message' => $e->getMessage(),
            ));
        } catch (CantMoveHereException $e) {
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
        $items = array();
        foreach ($this->getSession()->character->getItems() as $item) {
            $items[] = $item->toArray();
        }

        $this->view->json($items);
    }
}
