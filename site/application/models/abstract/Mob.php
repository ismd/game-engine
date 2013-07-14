<?php
/**
 * Абстрактный класс моба
 * @author ismd
 */

abstract class Abstract_Mob extends PsModel {

    private $_id;    // id в таблице MobLayout (конкретный моб на карте)
    private $_idMob; // id в таблице Mob (класс моба)
    private $_name;
    private $_level;
    private $_hp;
    private $_maxHp;
    private $_minDamage;
    private $_maxDamage;
    private $_experience;
    private $_image;
    private $_strength;
    private $_dexterity;
    private $_endurance;
    private $_idLayout;
    private $_x;
    private $_y;

    public function toArray() {
        return array(
            'id'         => $this->getId(),
            'idMob'      => $this->getIdMob(),
            'name'       => $this->getName(),
            'level'      => $this->getLevel(),
            'hp'         => $this->getHp(),
            'maxHp'      => $this->getMaxHp(),
            'minDamage'  => $this->getMinDamage(),
            'maxDamage'  => $this->getMaxDamage(),
            'experience' => $this->getExperience(),
            'image'      => $this->getImage(),
            'strength'   => $this->getStrength(),
            'dexterity'  => $this->getDexterity(),
            'endurance'  => $this->getEndurance(),
            'idLayout'   => $this->getIdLayout(),
            'x'          => $this->getX(),
            'y'          => $this->getY(),
        );
    }

    public function setId($value) {
        $this->_id = (int)$value;
        return $this;
    }

    public function getId() {
        return $this->_id;
    }

    public function setIdMob($value) {
        $this->_idMob = (int)$value;
        return $this;
    }

    public function getIdMob() {
        return $this->_idMob;
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

    public function setIdLayout($value) {
        $this->_idLayout = (int)$value;
        return $this;
    }

    public function getIdLayout() {
        return $this->_idLayout;
    }

    public function setX($value) {
        $this->_x = (int)$value;
        return $this;
    }

    public function getX() {
        return $this->_x;
    }

    public function setY($value) {
        $this->_y = (int)$value;
        return $this;
    }

    public function getY() {
        return $this->_y;
    }
}
