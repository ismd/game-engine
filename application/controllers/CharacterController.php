<?php
/**
 * Контроллер персонажа
 *
 * @author ismd
 */

class CharacterController extends AbstractAuthController {

    public function init() {
        if (empty($this->_session->user)) {
            header('Location: /');
            die;
        }
    }

    public function index() {
        header('Location: /');
        die;
    }

    public function create() {
        if (empty ($_POST)) {
            return;
        }

        $character = array(
            'idUser' => $this->_session->user->id,
            'name'   => !empty($_POST['name']) ? $_POST['name'] : '',
        );


        $character = new Character($character);
        $character->setDefaultValues();

        $mapper = new CharacterMapper;
        $this->_template->error = $mapper->save($character);
        }
    }

    /**
     * ajax: устанавливает текущего персонажа для сессии
     */
    public function set() {
        $idCharacter = (int)$_GET['id'];

        if (!$this->_session->user->hasCharacter($idCharacter)) {
            die('error');
        }

        $mapper = new CharacterMapper;
        $this->_session->character = $mapper->getById($idCharacter);
        
        $mapper = new MapMapper;
        $map = $mapper->getById($this->_session->character->idMap);

        $map->currentCell = new MapCell(
            $this->_session->character->idMap,
            $this->_session->character->coordinateX,
            $this->_session->character->coordinateY
        );

        $this->_session->map = $map;
        
        die('ok');
    }

    /**
     * Перемещение персонажа
     */
    public function move() {
        $x = $_GET['x'];
        $y = $_GET['y'];

        if ($this->_session->character->move($x, $y)) {
                $this->_session->map->currentCell->coordinateX = $this->_session->character->coordinateX;
                $this->_session->map->currentCell->coordinateY = $this->_session->character->coordinateY;
            
            die('ok');
        }
        
        die('error');
    }

    /**
     * ajax: список вещей персонажа
     */
    public function items() {
        $items = $this->_session->character->getItems();
        foreach ($items as $i => $item) {
            $items[$i] = $item->toArray();
        }

        die(json_encode($items));
    }
}
