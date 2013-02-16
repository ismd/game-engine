<?php
/**
 * Инициализируем всё необходимое и запускаем действие
 */

error_reporting(E_ALL ^ E_NOTICE);

// Определяем директорию с сайтом
define('SITEPATH', realpath(dirname(__FILE__)) . '/../');

// Инициализируем систему
require SITEPATH . 'lib/php-spa/startup.php';

// Registry, в котором будем хранить глобальные значения
$registry = new PsRegistry;

// Читаем конфиг и сохраняем в $registry
try {
    $registry->config = PsConfig::getInstance(SITEPATH)->getConfig();
} catch (PsConfigCantReadException $e) {
    // Если не удалось прочитать конфиг
    $_GET['route'] = 'index';
}

// Устанавливаем временную зону сервера
date_default_timezone_set($registry->config->timezone->server);

// Загружаем router
$registry->router = new PsRouter($registry, $_GET['route']);

// Загружаем класс для работы с шаблонами
$registry->view = new PsView($registry);

// Выбираем нужный контроллер, определяем действие и выполняем
$registry->router->delegate();

// Отображаем шаблон
$registry->view->render();
