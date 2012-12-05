<?php
/**
 * Абстрактный класс персонажей
 *
 * @author ismd
 */

abstract class AbstractCharacter extends AbstractModel {

    protected $_id;     // id в таблице Character (сам персонаж)
    protected $_idUser; // id в таблице User (пользователь)
    protected $_name;
    protected $_level;
    protected $_money;
    protected $_hp;
    protected $_maxHp;
    protected $_minDamage;
    protected $_maxDamage;
    protected $_experience;
    protected $_image;
    protected $_strength;
    protected $_dexterity;
    protected $_endurance;
    protected $_idMap;
    protected $_coordinateX;
    protected $_coordinateY;

    public function toArray() {
        return array(
            'id'          => $this->id,
            'idUser'      => $this->idUser,
            'name'        => $this->name,
            'level'       => $this->level,
            'money'       => $this->money,
            'hp'          => $this->hp,
            'maxHp'       => $this->maxHp,
            'minDamage'   => $this->minDamage,
            'maxDamage'   => $this->maxDamage,
            'experience'  => $this->experience,
            'image'       => $this->image,
            'strength'    => $this->strength,
            'dexterity'   => $this->dexterity,
            'endurance'   => $this->endurance,
            'idMap'       => $this->idMap,
            'coordinateX' => $this->coordinateX,
            'coordinateY' => $this->coordinateY,
        );
    }

    public function setId($value) {
        $this->_id = (int)$value;
        return $this;
    }

    public function getId() {
        return $this->_id;
    }

    public function setIdUser($value) {
        $this->_idUser = (int)$value;
        return $this;
    }

    public function getIdUser() {
        return $this->_idUser;
    }

    public function setName($value) {
        $this->_name = (string)$value;
        return $this;
    }

    public function getName() {
        return $this->_name;
    }

    public function setLevel($value) {
        $this->_level = (int)$value;
        return $this;
    }

    public function getLevel() {
        return $this->_level;
    }

    public function setMoney($value) {
        $this->_money = (int)$value;
        return $this;
    }

    public function getMoney() {
        return $this->_money;
    }

    public function setHp($value) {
        $this->_hp = (int)$value;
        return $this;
    }

    public function getHp() {
        return $this->_hp;
    }

    public function setMaxHp($value) {
        $this->_maxHp = (int)$value;
        return $this;
    }

    public function getMaxHp() {
        return $this->_maxHp;
    }

    public function setMinDamage($value) {
        $this->_minDamage = (int)$value;
        return $this;
    }

    public function getMinDamage() {
        return $this->_minDamage;
    }

    public function setMaxDamage($value) {
        $this->_maxDamage = (int)$value;
        return $this;
    }

    public function getMaxDamage() {
        return $this->_maxDamage;
    }

    public function setExperience($value) {
        $this->_experience = (int)$value;
        return $this;
    }

    public function getExperience() {
        return $this->_experience;
    }

    public function setImage($value) {
        $this->_image = (string)$value;
        return $this;
    }

    public function getImage() {
        return $this->_image;
    }

    public function setStrength($value) {
        $this->_strength = (int)$value;
        return $this;
    }

    public function getStrength() {
        return $this->_strength;
    }

    public function setDexterity($value) {
        $this->_dexterity = (int)$value;
        return $this;
    }

    public function getDexterity() {
        return $this->_dexterity;
    }

    public function setEndurance($value) {
        $this->_endurance = (int)$value;
        return $this;
    }

    public function getEndurance() {
        return $this->_endurance;
    }

    public function setIdMap($value) {
        $this->_idMap = (int)$value;
        return $this;
    }

    public function getIdMap() {
        return $this->_idMap;
    }

    public function setCoordinateX($value) {
        $this->_coordinateX = (int)$value;
        return $this;
    }

    public function getCoordinateX() {
        return $this->_coordinateX;
    }

    public function setCoordinateY($value) {
        $this->_coordinateY = (int)$value;
        return $this;
    }

    public function getCoordinateY() {
        return $this->_coordinateY;
    }
}
