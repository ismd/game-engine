<?php
/**
 * Created by PhpStorm.
 * User: ismd
 * Date: 8/10/15
 * Time: 4:25 PM
 */

class CellsSprite extends PsModel {

    const CELL_SIZE_X = 30;
    const CELL_SIZE_Y = 30;

    private $_file;

    public function __construct($file) {
        $this->_file = imagecreatefrompng($file);
    }

    public function getSize() {
        return [
            'width' => imagesx($this->_file) / self::CELL_SIZE_X,
            'height' => imagesy($this->_file) / self::CELL_SIZE_Y,
        ];
    }
}
