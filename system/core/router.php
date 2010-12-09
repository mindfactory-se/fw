<?php

/**
 * p12t PHP Framework : /system/core/router.php
 *
 * @package p12t
 * @author hepper
 * @copyright Copyright (c) 2010, Henrik Persson, Pay if you like it
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */

class Router extends SingeltonObject {

    public static function set($name, $value) {
        return self::setInOrder($name, $value);
    }

    public static function match() {
        $_this =& self::getInstance();
        
        $path = (isset($_SERVER['PATH_INFO'])?$_SERVER['PATH_INFO']:'/');
        $param = array();
        foreach ($_this->values as $value) {
            foreach ($value as $key => $name) {
                if(preg_match('#' . $key . '#i', $path)) {
                    App::set('sys.route.internal', preg_replace('#' . $key . '#i', $name, $path));
                    App::set('sys.route.visible', $path);
                    Router::parse();
                    break 2;
                }
            }
        }
        $baseUrl = substr($_SERVER['SCRIPT_NAME'], 0, strpos($_SERVER['SCRIPT_NAME'], 'index.php') - 1);
        App::set('sys.route.base', $baseUrl);
    }

    public static function parse() {
        $_this =& self::getInstance();

        $url = explode('/', App::get('sys.route.internal'));

        $count = count($url);

        Benchmark::set('Before');

        App::set('sys.route.mod', $url[1]);
        App::set('sys.route.controller', $url[2]);
        App::set('sys.route.action', $url[3]);
        if ($count > 4) {
            App::set('sys.route.params', array_slice($url, 4));
        }
        Benchmark::set('After');
    }
    
}