<?php
/**
 * Класс клетки на карте
 * @author ismd
 */

class Cell extends AbstractCell {

    const VICINITY_WIDTH  = 7;
    const VICINITY_HEIGHT = 5;

    /**
     * Возвращает окрестности клетки
     * @return array Двумерный массив [x][y]
     */
    public function getVicinity() {
        $map = $this->map->map;

        $startX = $this->x - floor(self::VICINITY_WIDTH / 2);
        $startY = $this->y - floor(self::VICINITY_HEIGHT / 2);

        if ($startX < 0) {
            $startX = 0;
        }

        if ($startY < 0) {
            $startY = 0;
        }

        $result = array();

        for ($y = $startY, $j = 0; $y < $startY + self::VICINITY_HEIGHT; $y++, $j++) {
            for ($x = $startX, $i = 0; $x < $startX + self::VICINITY_WIDTH; $x++, $i++) {
                $result[$i][$j] = $map[$y][$x];
            }
        }

        return $result;
    }
}
