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
        $npcs   = $mapper->getOnCell($this->_idMap, $this->_coordinateX, $this->_coordinateY);

        // Получаем персонажей на клетке
        $mapper     = new CharacterMapper;
        $characters = $mapper->getOnCell($this->_idMap, $this->_coordinateX, $this->_coordinateY);

        // Получаем мобов на клетке
        $mapper = new MobMapper;
        $mobs   = $mapper->getOnCell($this->_idMap, $this->_coordinateX, $this->_coordinateY);

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
