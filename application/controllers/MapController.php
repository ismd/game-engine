<?php

class MapController extends AbstractAuthController {

    public function index() {
        die;
    }

    /**
     * Выводит содержимое текущей клетки
     */
    public function cell() {
        $this->view->setLayout('empty');

        $content = array(
            'npcs'       => array(),
            'mobs'       => array(),
            'characters' => array(),
        );

        $cell = $this->session->character->cell;

        // Получаем NPC на клетке
        $mapper = new NpcMapper;
        $npcs   = $mapper->getByCell($cell);

        // Получаем персонажей на клетке
        $mapper     = new CharacterMapper;
        $characters = $mapper->getByCell($cell);

        // Получаем мобов на клетке
        $mapper = new MobMapper;
        $mobs   = $mapper->getByCell($cell);

        // Преобразуем в массив
        foreach ($npcs as $npc) {
            //$content['npcs'][] = $npc->toArray();
        }

        $id = $this->session->character->id;
        foreach ($characters as $character) {
            if ($character->id == $id) {
                continue;
            }

            $content['characters'][] = array(
                'id'    => $character->id,
                'name'  => $character->name,
                'level' => $character->level,
                'hp'    => $character->hp,
                'maxHp' => $character->maxHp,
                'image' => $character->image,
            );
        }

        foreach ($mobs as $mob) {
            //$content['mobs'][] = $mob->toArray();
        }

        $this->view->content = $content;
    }
}
