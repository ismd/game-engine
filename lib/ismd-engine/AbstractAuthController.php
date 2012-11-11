<?php
/**
 * Родительский класс для контроллеров, которым необходимо,
 *   чтобы пользователь был авторизован
 *
 * @author ismd
 */

abstract class AbstractAuthController extends AbstractController {

    public function __construct($registry) {
        parent::__construct($registry);

        if (!isset($this->_session->user)) {
            header('Location: /');
            die;
        }
    }
}
