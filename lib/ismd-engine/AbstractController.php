<?php
/**
 * Родительский класс для всех наших контроллеров
 *
 * @author ismd
 */

abstract class AbstractController {

    protected $_registry;
    protected $_session;
    protected $_template;

    public function __construct($registry) {
        $this->_registry = $registry;
        $this->_session  = $registry->session;
        $this->_template = $registry->template;
    }

    /**
     * Обязательное действие index у всех контроллеров (страница по-умолчанию)
     */
    abstract public function index();
}
