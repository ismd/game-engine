<?php
/**
 * Класс для работы с шаблонами
 *
 * @author ismd
 */

class Template {

    private $_registry;
    private $_session;
    private $_data  = array();
    private $_js    = array();
    private $_css   = array();
    private $_title = '';

    public function __construct($registry) {
        $this->_registry = $registry;
        $this->_session  = $registry->session;
    }

    public function __set($key, $value) {
        $this->_data[$key] = $value;
    }

    public function __get($key) {
        if (!isset($this->_data[$key])) {
            return null;
        }

        return $this->_data[$key];
    }

    public function __unset($key) {
        if (isset($this->data[$key])) {
            unset($this->data[$key]);
        }
    }

    public function __isset($key) {
        return isset($this->_data[$key]);
    }

    /**
     * Показываем нужный шаблон
     */
    public function show() {
        // Отправляем заголовок с указанием кодировки
        header('Content-Type: text/html; charset=utf-8');

        $route = $this->_registry->router->getRoute();
        $route = ($route != '') ? explode('/', $route) : array('index');
        $path  = SITEPATH . 'templates/';

        $headers = array();
        $footers = array();

        $countRoute = count($route);

        // Ищем нужные нам хэдеры и футеры
        for ($i = 0; $i < $countRoute - 1; $i++) {
            if (is_readable($path . 'header.phtml')) {
                $headers[] = $path . 'header.phtml';
            }

            if (is_readable($path . 'footer.phtml')) {
                $footers[] = $path . 'footer.phtml';
            }

            $path .= $route[$i] . '/';

            if (!is_dir($path)) {
                return;
            }
        }

        // Сам файл шаблона и возможно ближайшие хэдер и футер
        if (is_dir($path . $route[$countRoute - 1])) {
            $fileInSubDir = is_readable($path . $route[$countRoute - 1] . '/index.phtml');

            if (is_readable($path . 'header.phtml')) {
                $headers[] = $path . 'header.phtml';
            }

            if ($fileInSubDir && is_readable($path . $route[$countRoute - 1] . '/header.phtml')) {
                $headers[] = $path . $route[$countRoute - 1] . '/header.phtml';
            }

            if ($fileInSubDir) {
                $filepath = $path . $route[$countRoute - 1] . '/index.phtml';
            } elseif ( is_readable($path . $route[$countRoute - 1] . '.phtml') ) {
                $filepath = $path . $route[$countRoute - 1] . '.phtml';
            } else {
                return;
            }

            if (is_readable($path . 'footer.phtml')) {
                $footers[] = $path . 'footer.phtml';
            }

            if ($fileInSubDir && is_readable($path . $route[$countRoute - 1] . '/footer.phtml')) {
                $footers[] = $path . $route[$countRoute - 1] . '/footer.phtml';
            }
        } else {
            if (is_readable($path . 'header.phtml')) {
                $headers[] = $path . 'header.phtml';
            }

            if (is_readable($path . $route[$countRoute - 1] . '.phtml')) {
                $filepath = $path . $route[$countRoute - 1] . '.phtml';
            } else {
                return;
            }

            if (is_readable($path . 'footer.phtml')) {
                $footers[] = $path . 'footer.phtml';
            }
        }

        // Подключаем все нужные хэдеры
        foreach ($headers as $header) {
            require $header;
        }

        // Подключаем сам файл шаблона
        require $filepath;

        // Подключаем все нужные футеры
        $footers = array_reverse($footers);
        foreach ($footers as $footer) {
            require $footer;
        }
    }

    /**
     * Переданная ссылка будет вставлена в качестве ссылки на javascript-файл
     * Может быть передан массив ссылок
     */
    public function js($link) {
        if (is_array($link)) {
            $this->_js = array_merge($this->_js, $link);
        } else {
            $this->_js[] = $link;
        }
    }

    /**
     * Переданная ссылка будет вставлена в качестве ссылки на css-файл
     * Может быть передан массив ссылок
     */
    public function css($link) {
        if (is_array($link)) {
            $this->_css = array_merge($this->_css, $link);
        } else {
            $this->_css[] = $link;
        }
    }

    public function setTitle($title) {
        $this->_title = '::' . $title;
    }
}
