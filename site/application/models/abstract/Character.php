<?php
/**
 * Абстрактный класс персонажей
 * @author ismd
 */

abstract class Abstract_Character extends PsModel {

    private $_id;     // id в таблице Character (сам персонаж)
    private $_idUser; // id в таблице User (пользователь)
    private $_name;
    private $_level;
    private $_money;
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
            'idUser'     => $this->getIdUser(),
            'name'       => $this->getName(),
            'level'      => $this->getLevel(),
            'money'      => $this->getMoney(),
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
