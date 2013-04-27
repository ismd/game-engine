<?php

class MapController extends PsAbstractAuthController {

    /**
     * Выводит содержимое текущей клетки
     */
    public function cellAction() {
        $npcMapper       = new NpcMapper;
        $characterMapper = new CharacterMapper;
        $mobMapper       = new MobMapper;

        $cell = $this->session->character->cell;

        $content = array(
            'npcs'       => $npcMapper->getByCell($cell),
            'characters' => $characterMapper->getByCell($cell),
            'mobs'       => $mobMapper->getByCell($cell),
        );

        // Преобразуем в массив NPC
        foreach ($content['npcs'] as $i => $npc) {
            $content['npcs'][$i] = $npc->toArray();
        }

        // Преобразуем в массив персонажей
        $id = $this->session->character->id;
        foreach ($content['characters'] as $i => $character) {
            if ($character->id == $id) {
                unset($content['characters'][$i]);
                continue;
            }

            $content['characters'][$i] = array(
                'id'    => $character->id,
                'name'  => $character->name,
                'level' => $character->level,
                'hp'    => $character->hp,
                'maxHp' => $character->maxHp,
                'image' => $character->image,
            );
        }

        // Преобразуем в массив мобов
        foreach ($content['mobs'] as $i => $mob) {
            $content['mobs'][$i] = $mob->toArray();
        }

        $this->view->json($content);
    }
}
