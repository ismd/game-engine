<?php
/**
 * Абстрактный класс пользователя
 * @author ismd
 */

abstract class Abstract_User extends PsModel {

    private $_id;
    private $_login;
    private $_password;
    private $_email;
    private $_info;
    private $_site;
    private $_registered;
    private $_authKey;

    public function toArray() {
        return array(
            'id'         => $this->getId(),
            'login'      => $this->getLogin(),
            'email'      => $this->getEmail(),
            'info'       => $this->getInfo(),
            'site'       => $this->getSite(),
            'registered' => $this->getRegistered(),
        );
    }

    public function setId($value) {
        $this->_id = (int)$value;
        return $this;
    }

    public function getId() {
        return $this->_id;
    }

    public function setLogin($value) {
        $this->_login = (string)$value;
        return $this;
    }

    public function getLogin() {
        return $this->_login;
    }

    public function setPassword($value) {
        $this->_password = (string)$value;
        return $this;
    }

    public function getPassword() {
        return $this->_password;
    }

    public function setEmail($value) {
        $this->_email = (string)$value;
        return $this;
    }

    public function getEmail() {
        return $this->_email;
    }

    public function setInfo($value) {
        $this->_info = (string)$value;
        return $this;
    }

    public function getInfo() {
        return $this->_info;
    }

    public function setSite($value) {
        $this->_site = (string)$value;
        return $this;
    }

    public function getSite() {
        return $this->_site;
    }

    public function setRegistered($value) {
        $this->_registered = $value;
        return $this;
    }

    public function getRegistered() {
        return $this->_registered;
    }

    public function setAuthKey($value) {
        $this->_authKey = (string)$value;
        return $this;
    }

    public function getAuthKey() {
        return $this->_authKey;
    }
}
