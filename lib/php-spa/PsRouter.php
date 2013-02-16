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

    public function __construct($registry, $route = 'index') {
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
        if (false == is_readable($controllerFile)) {
            $controllerFile = $controllersPath . 'IndexController.php';
            $controllerName = 'IndexController';
        }

        // Подключаем контроллер
        require $controllerFile;

        // Создаём экземпляр контроллера
        $controller = new $controllerName($this->_registry);

        $action = $this->_action;

        // Если действие недоступно
        if (false == is_callable(array($controller, $action))) {
            header('Location: /');
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
     */
    protected function parseRoute() {
        $route      = explode('/', $this->_route);

        // Обрабатываем как partial
        if ($route[0] == 'p') {
            $this->_isPartial = true;
            $route = array_slice($route, 1);
        } else {
            $this->_controller = 'index';
            $this->_action      = 'index';
            return;
        }
        
        $countRoute = count($route);

        // Контроллер
        if ($countRoute > 0) {
            $this->_controller = strtolower($route[0]);
        } else {
            $this->_controller = 'index';
        }

        // Действие
        if ($countRoute > 1) {
            $this->_action = strtolower($route[1]);
        } else {
            $this->_action = 'index';
        }

        // Аргументы
        $this->_args = array_slice($route, 2);
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
}
