<?php
/**
 * Инициализируем всё необходимое и запускаем действие
 */

error_reporting (E_ALL);

session_start();

// Определяем директорию с сайтом
define('SITEPATH', realpath(dirname(__FILE__)) . '/../');

// Инициализируем систему
require SITEPATH . 'lib/ismd-engine/startup.php';

// Registry, в котором будем хранить глобальные значения
$registry = new Registry;

// Инициализируем собственную реализацию сессий с блэкджеком
$registry->session = new Session;

// Подключаемся к базе данных
if (!(mysql_connect('localhost', 'root', '123')
        && mysql_select_db('game'))) {
    $registry->db_error = true;
    $_GET['route'] = 'index';
}

// Загружаем router
$registry->router = new Router(
    $registry,
    (!empty($_GET['route']) ? $_GET['route'] : 'index')
);

// Загружаем класс для работы с шаблонами
$registry->template = new Template($registry);

// Выбираем нужный контроллер, определяем действие и выполняем
$registry->router->delegate();
$registry->router->showTemplate();