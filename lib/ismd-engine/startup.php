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
 * Подключение к БД
 *
 * @return 
 */
function dbConnect() {
    $mysqli = mysqli_init();
    
    // int возвращается как int, а не string
    $mysqli->options(MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);
    
    return $mysqli->real_connect('localhost', 'root', '123', 'game');
}
