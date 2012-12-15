<?php
/**
 * Класс клетки на карте
 *
 * @author ismd
 */

class Cell extends AbstractCell {

    /**
     * Возвращает содержимое клетки. Возвращает уже массив массивов, а не массив объектов
     * FIXME: deprecated, remove
     *
     * @return array Массив с содержимым клетки array('mobs' => array(...), 'characters' => array(...), ...)
     */
    public function getContent() {
        $cellContent = array(
            'npcs'       => array(),
            'mobs'       => array(),
            'characters' => array(),
        );

        // Получаем NPC на клетке
        $mapper = new NpcMapper;
        $npcs   = $mapper->getByCell($this);

        // Получаем персонажей на клетке
        $mapper     = new CharacterMapper;
        $characters = $mapper->getByCell($this);

        // Получаем мобов на клетке
        $mapper = new MobMapper;
        $mobs   = $mapper->getByCell($this);

        // Преобразуем в массив
        foreach ($npcs as $npc) {
            $cellContent['npcs'][] = $npc->toArray();
        }

        foreach ($characters as $character) {
            $cellContent['characters'][] = $character->toArray();
        }

        foreach ($mobs as $mob) {
            $cellContent['mobs'][] = $mob->toArray();
        }

        return $cellContent;
    }
}