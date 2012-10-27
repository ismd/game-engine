<?php
/**
 * Абстрактный класс моба
 *
 * @author ismd
 */

abstract class AbstractMob extends DefaultModel {

    protected $_id;      // id в таблице MobMap (конкретный моб на карте)
    protected $_idMob;   // id в таблице Mob (класс моба)
    protected $_name;
    protected $_level;
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

    public function getId() {
        return $this->_id;
    }

    public function getIdMob() {
        return $this->_idMob;
    }

    public function getName() {
        return $this->_name;
    }

    public function getLevel() {
        return $this->_level;
    }

    public function getHp() {
        return $this->_hp;
    }

    public function getMaxHp() {
        return $this->_maxHp;
    }

    public function getMinDamage() {
        return $this->_minDamage;
    }

    public function getMaxDamage() {
        return $this->_maxDamage;
    }

    public function getExperience() {
        return $this->_experience;
    }

    public function getImage() {
        return $this->_image;
    }

    public function getStrength() {
        return $this->_strength;
    }

    public function getDexterity() {
        return $this->_dexterity;
    }

    public function getEndurance() {
        return $this->_endurance;
    }

    public function getIdMap() {
        return $this->_idMap;
    }

    public function getCoordinateX() {
        return $this->_coordinateX;
    }

    public function getCoordinateY() {
        return $this->_coordinateY;
    }

    public function setId($id) {
        $this->_id = (int)$id;
        return $this;
    }

    public function setIdMob($idMob) {
        $this->_idMob = (int)$idMob;
        return $this;
    }

    public function setName($name) {
        $this->_name = (string)$name;
        return $this;
    }

    public function setLevel($level) {
        $this->_level = (int)$level;
        return $this;
    }

    public function setHp($hp) {
        $this->_hp = (int)$hp;
        return $this;
    }

    public function setMaxHp($maxHp) {
        $this->_maxHp = (int)$maxHp;
        return $this;
    }

    public function setMinDamage($minDamage) {
        $this->_minDamage = (int)$minDamage;
        return $this;
    }

    public function setMaxDamage($maxDamage) {
        $this->_maxDamage = (int)$maxDamage;
        return $this;
    }

    public function setExperience($experience) {
        $this->_experience = (int)$experience;
        return $this;
    }

    public function setImage($image) {
        $this->_image = (string)$image;
        return $this;
    }

    public function setStrength($strength) {
        $this->_strength = (int)$strength;
        return $this;
    }

    public function setDexterity($dexterity) {
        $this->_dexterity = (int)$dexterity;
        return $this;
    }

    public function setEndurance($endurance) {
        $this->_endurance = (int)$endurance;
        return $this;
    }

    public function setIdMap($idMap) {
        $this->_idMap = (int)$idMap;
        return $this;
    }

    public function setCoordinateX($coordinateX) {
        $this->_coordinateX = (int)$coordinateX;
        return $this;
    }

    public function setCoordinateY($coordinateY) {
        $this->_coordinateY = (int)$coordinateY;
        return $this;
    }

    public function toArray() {
        return array(
            'id'             => $this->_id,
            'idMob'          => $this->_idMob,
            'name'           => $this->_name,
            'level'          => $this->_level,
            'hp'             => $this->_hp,
            'maxHp'          => $this->_maxHp,
            'minDamage'      => $this->_minDamage,
            'maxDamage'      => $this->_maxDamage,
            'experience'     => $this->_experience,
            'image'          => $this->_image,
            'strength'       => $this->_strength,
            'dexterity'      => $this->_dexterity,
            'endurance'      => $this->_endurance,
            'idMap'          => $this->_idMap,
            'coordinateX'    => $this->_coordinateX,
            'coordinateY'    => $this->_coordinateY
        );
    }
}
