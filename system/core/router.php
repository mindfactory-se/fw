<?php

/**
 * p12t PHP Framework : /system/core/router.php
 *
 * @package p12t
 * @author hepper
 * @copyright Copyright (c) 2010, Henrik Persson, Pay if you like it
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Routes the recuest to the right mod, controller and action.
 *
 * @since 0.1.0
 * @access public
 */
class Router extends SingletonObject {

    /**
     * Invokes the setInOrder method
     *
     * @access public
     * @param string $name Regex to be search for
     * @param string $value The route to be matched.
     * @return bool Returns true if value is set.
     */
    public static function set($name, $value) {
        return self::setInOrder($name, $value);
    }

    /**
     * Matches the requestetd url to a route.
     *
     * @access public
     */
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

    /**
     * Extracts the mod, controller, action and params from the route.
     *
     * @access public
     */
    public static function parse() {
        $_this =& self::getInstance();

        $url = explode('/', App::get('sys.route.internal'));

        App::set('sys.route.app', $url[1]);
        App::set('sys.route.controller', $url[2]);
        App::set('sys.route.action', $url[3]);
        if (count($url) > 4) {
            App::set('sys.route.params', array_slice($url, 4));
        }
    }
    
}