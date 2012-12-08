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

        $idCharacter = (int)$_POST['id'];

        if (!$this->session->user->hasCharacter($idCharacter)) {
            $this->view->result = 'error';
            return;
        }

        $mapper                   = new CharacterMapper;
        $this->session->character = $mapper->getById($idCharacter);

        $this->view->result = 'ok';
    }

    /**
     * ajax: Перемещение персонажа
     */
    public function move() {
        $this->view->setEmpty(true);
        
        $x = (int)$_POST['x'];
        $y = (int)$_POST['y'];
        
        $cell = new Cell($this->session->character->map, $x, $y);

        try {
            $this->session->character->move($cell);
            $this->view->result = 'ok';
        } catch (CharacterFastMove $e) {
            $this->view->result = 'error: fast moving';
        } catch (CharacterCantMoveHere $e) {
            $this->view->result = 'error: cannot move here';
        }
    }

    /**
     * ajax: список вещей персонажа
     */
    public function items() {
        $this->view->setEmpty(true);
        
        $items = $this->session->character->getItems();

        $data = array();
        foreach ($items as $item) {
            $data[] = $item->toArray();
        }

        $this->view->data = $data;
    }
}
