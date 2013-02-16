<?php
/**
 * Роутер
 *
 * Использование:
 * $router->delegate() -- Подключает нужные классы, выполняет нужный метод
 * $router->getController()
 * $router->getAction()
 * $router->getArgs()
 *
 * @author ismd
 */

class PsRouter {

    protected $_registry;
    protected $_route;

    /**
     * Запрошен только partial
     */
    protected $_isPartial = false;

    /**
     * Запрошен доступ к действию
     */
    protected $_isAction = false;

    /**
     * Контроллер
     * @var string
     */
    protected $_controller;

    /**
     * Действие
     * @var string
     */
    protected $_action;

    /**
     * Аргументы запроса
     * Пример: <контроллер>/<действие>/<арг.1>/<арг.2>/...
     * @var array
     */
    protected $_args = array();

    public function __construct($registry, $route) {
        if (empty($route)) {
            $route = 'index';
        }

        $this->_registry = $registry;
        $this->_route    = $route;
    }

    /**
     * Подключаем нужный контроллер, модель и выполняем действие
     */
    public function delegate() {
        // Анализируем путь
        $this->parseRoute();

        // Имя класса контроллера
        $controllerName = ucfirst($this->_controller) . 'Controller';

        // Путь к директории с контроллерами
        $controllersPath = SITEPATH . 'application/controllers/';

        // Путь к контроллеру
        $controllerFile   = $controllersPath . $controllerName . '.php';

        // Если недоступен файл контроллера
        if (!is_readable($controllerFile)) {
            $controllerFile = $controllersPath . 'IndexController.php';
            $controllerName = 'IndexController';
        }

        // Подключаем контроллер
        require $controllerFile;

        // Создаём экземпляр контроллера
        $controller = new $controllerName($this->_registry);

        $action = $this->_action;

        if ($this->isPartial()) {
            $action .= 'Partial';
        } elseif ($this->isAction()) {
            $action .= 'Action';
        }

        // Если действие недоступно
        if (!is_callable(array($controller, $action))) {
            die;
        }

        // Инициализируем контроллер, если надо
        if (is_callable(array($controller, 'init'))) {
            $controller->init();
        }

        // Выполняем действие
        $controller->$action();
    }

    /**
     * Определяет контроллер, действие и аргументы
     * Устанавливает свойства _controller, _action и _args
     */
    protected function parseRoute() {
        $route = explode('/', $this->_route);

        // Получаем префиксы
        $prefixes = $this->_registry->config->url_prefix;

        switch ($route[0]) {
            // Обрабатываем как partial
            case $prefixes->partial:
                $this->_isPartial = true;
                break;

            // Обрабатываем как действие
            case $prefixes->action:
                $this->_isAction = true;
                break;

            default:
                $this->_controller = 'index';
                $this->_action     = 'index';
                return;
                break;
        }

        $countRoute = count($route);

        if ($countRoute == 1) {
            die;
        }

        // Контроллер
        $this->_controller = strtolower($route[1]);

        // Действие
        if ($countRoute > 2) {
            $this->_action = strtolower($route[2]);
        } else {
            $this->_action = 'index';
        }

        // Аргументы
        $this->_args = array_slice($route, 3);
    }

    /**
     * Возвращает контроллер
     * @return string
     */
    public function getController() {
        return $this->_controller;
    }

    /**
     * Возвращает действие
     * @return string
     */
    public function getAction() {
        return $this->_action;
    }

    /**
     * Возвращает аргументы, переданные в url
     * @return array
     */
    public function getArgs() {
        return $this->_args;
    }

    public function isPartial() {
        return $this->_isPartial;
    }

    public function isAction() {
        return $this->_isAction;
    }
}
