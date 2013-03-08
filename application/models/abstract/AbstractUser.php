<?php
/**
 * Абстрактный класс пользователя
 * @author ismd
 */

abstract class AbstractUser extends PsAbstractModel {

    protected $_id;
    protected $_login;
    protected $_password;
    protected $_password1;
    protected $_email;
    protected $_info;
    protected $_site;
    protected $_registered;

    public function toArray() {
        return array(
            'id'         => $this->id,
            'login'      => $this->login,
            'email'      => $this->email,
            'info'       => $this->info,
            'site'       => $this->site,
            'registered' => $this->registered,
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
}
