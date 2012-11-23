<?php
/**
 * Загрузка классов "на лету"
 *
 * @author ismd
 */
function __autoload($className) {
    if (strstr($className, '.')) {
        return;
    }

    $filename = $className . '.php';

    // Класс движка
    $file = realpath(dirname(__FILE__)) . '/' . $filename;
    if (is_readable($file)) {
        require_once $file;
    }

    // Класс контроллера
    if (substr($className, -9) == 'Controller') {
        $file = SITEPATH . 'application/controllers/' . $filename;
        if (is_readable($file)) {
            require_once $file;
        }
    }

    // Класс модели
    $file = SITEPATH . 'application/models/' . $filename;
    if (is_readable($file)) {
        require_once $file;
    }

    // Класс абстрактной модели
    if (substr($className, 0, 8) == 'Abstract') {
        $file = SITEPATH . 'application/models/abstract/' . $filename;
        if (is_readable($file)) {
            require_once $file;
        }
    }
}

/**
 * Подключается к БД
 *
 * @param Registry $registry
 */
function dbConnect(&$registry) {
    $config = parse_ini_file(SITEPATH . 'application/configs/application.ini', true);

    $registry->db = mysqli_connect(
        $config['database']['host'],
        $config['database']['username'],
        $config['database']['password'],
        $config['database']['dbname']
    );
}
