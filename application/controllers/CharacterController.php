<?php
/**
 * Контроллер персонажа
 *
 * @author ismd
 */

class CharacterController extends AbstractAuthController {

    public function index() {
        $this->redirect('/');
    }

    /**
     * Создание персонажа
     */
    public function create() {
        if (empty($_POST)) {
            return;
        }

        $character = array(
            'user' => $this->session->user,
            'name' => $_POST['name'],
        );

        $character = new Character($character);
        $character->setDefaultValues();

        $mapper = new CharacterMapper;

        try {
            $mapper->save($character);
        } catch (Exception $e) {
            $this->view->error = $e->getMessage();
        }
    }

    /**
     * ajax: устанавливает текущего персонажа для сессии
     */
    public function set() {
        $this->view->setEmpty(true);

        $idCharacter = (int)$_GET['id'];

        if (!$this->session->user->hasCharacter($idCharacter)) {
            $this->view->result = 'error';
            return;
        }

        $mapper                   = new CharacterMapper;
        $this->session->character = $mapper->getById($idCharacter);

        $this->view->result = 'ok';
    }

    /**
     * Перемещение персонажа
     */
    public function move() {
        $x = (int)$_GET['x'];
        $y = (int)$_GET['y'];

        try {
            $this->session->character->move($x, $y);
            $this->view->result('ok');
        } catch (CharacterFastMove $e) {
            $this->view->result('error: fast moving');
        } catch (CharacterCantMoveHere $e) {
            $this->view->result('error: cannot move here');
        }
    }

    /**
     * ajax: список вещей персонажа
     */
    public function items() {
        $items = $this->session->character->getItems();

        $data = array();
        foreach ($items as $item) {
            $data[] = $item->toArray();
        }

        $this->view->data = $data;
    }
}
