<?php
/**
 * Контроллер персонажа
 *
 * @author ismd
 */

class CharacterController extends AbstractAuthController {

    public function init() {
        $this->view->setLayout('empty');
    }

    public function index() {
        $this->redirect('/');
    }

    /**
     * Создание персонажа
     * @post name
     */
    public function create() {
        $this->view->setLayout('default');

        if (false == $this->request->isPost()) {
            return;
        }

        $character = new Character(array(
            'user' => $this->session->user,
            'name' => $this->request->post->name,
        ));
        
        // Устанавливаем начальные значения
        $character->setDefaultValues();

        $mapper = new CharacterMapper;

        try {
            $mapper->save($character);
            $this->view->created = true;
        } catch (CharacterMapperLongName $e) {
            $this->view->error = $e->getMessage();
        } catch (CharacterMapperShortName $e) {
            $this->view->error = $e->getMessage();
        } catch (CharacterMapperNameExists $e) {
            $this->view->error = $e->getMessage();
        } catch (Exception $e) {
            $this->view->error = 'Ошибка';
        }
    }

    /**
     * Устанавливает текущего персонажа для сессии
     * @post id
     */
    public function set() {
        $idCharacter = (int)$_POST['id'];

        if (false == $this->session->user->hasCharacter($idCharacter)) {
            $this->view->result = 'error';
            return;
        }

        $mapper                   = new CharacterMapper;
        $this->session->character = $mapper->getById($idCharacter);

        $this->view->result = 'ok';
    }

    /**
     * Перемещение персонажа
     *
     * @post x
     * @post y
     */
    public function move() {
        $x = (int)$_POST['x'];
        $y = (int)$_POST['y'];

        $cell = new Cell($this->session->character->cell->map, $x, $y);

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
     * Список вещей персонажа
     */
    public function items() {
        $items = $this->session->character->getItems();

        $data = array();
        foreach ($items as $item) {
            $data[] = $item->toArray();
        }

        $this->view->items = $data;
    }
}
