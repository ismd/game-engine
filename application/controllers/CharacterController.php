<?php
/**
 * Контроллер персонажа
 * @author ismd
 */

class CharacterController extends PsAbstractAuthController {

    /**
     * Создание персонажа
     * @post name
     */
    public function createAction() {
        $request = $this->getRequest();

        if (!$request->isPost()) {
            return;
        }

        $character = new Character(array(
            'user' => $this->session->user,
            'name' => $request->post->name,
        ));

        // Устанавливаем начальные значения
        $character->setDefaultValues();

        $mapper = new CharacterMapper;

        try {
            $mapper->save($character);

            $this->view->json(array(
                'status' => 'ok',
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
        $idCharacter = (int)$this->request->getPost()->id;

        if (!$this->session->user->hasCharacter($idCharacter)) {
            $this->view->json(array(
                'status' => 'error',
            ));

            return;
        }

        $mapper = new CharacterMapper;

        $this->session->character = $mapper->getById($idCharacter);

        $this->view->json(array(
            'status' => 'ok',
            'character' => $this->session->character->toArray(),
        ));
    }

    /**
     * Перемещение персонажа
     * @post x
     * @post y
     */
    public function moveAction() {
        $request = $this->getRequest();

        $x = (int)$request->post->x;
        $y = (int)$request->post->y;

        $cell = new Cell($this->session->character->cell->map, $x, $y);

        try {
            $this->session->character->move($cell);

            $this->view->json(array(
                'status' => 'ok',
            ));
        } catch (CharacterFastMove $e) {
            $this->view->json(array(
                'status'  => 'error',
                'message' => 'fast moving',
            ));
        } catch (CharacterCantMoveHere $e) {
            $this->view->json(array(
                'status'  => 'error',
                'message' => 'cannot move here',
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
