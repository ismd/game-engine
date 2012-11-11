<?php
/**
 * Абстрактный класс пользователя
 *
 * @author ismd
 */

abstract class AbstractUser extends AbstractModel {

    protected $_id;
    protected $_login;
    protected $_password;
    protected $_password1;
    protected $_email;
    protected $_info;
    protected $_site;
    protected $_registered;

    public function getId() {
        return $this->_id;
    }

    public function getLogin() {
        return $this->_login;
    }

    public function getPassword() {
        return $this->_password;
    }

    public function getPassword1() {
        return $this->_password1;
    }

    public function getEmail() {
        return $this->_email;
    }

    public function getInfo() {
        return $this->_info;
    }

    public function getSite() {
        return $this->_site;
    }

    public function getRegistered() {
        return $this->_registered;
    }

    public function setId($id) {
        $this->_id = (int)$id;
        return $this;
    }

    public function setLogin($login) {
        $this->_login = (string)$login;
        return $this;
    }

    public function setPassword($password) {
        $this->_password = (string)$password;
        return $this;
    }

    public function setPassword1($password1) {
        $this->_password1 = (string)$password1;
        return $this;
    }

    public function setEmail($email) {
        $this->_email = (string)$email;
        return $this;
    }

    public function setInfo($info) {
        $this->_info = (string)$info;
        return $this;
    }

    public function setSite($site) {
        $this->_site = (string)$site;
        return $this;
    }

    public function setRegistered($registered) {
        $this->_registered = $registered;
        return $this;
    }
}
