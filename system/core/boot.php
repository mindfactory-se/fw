<?php

/**
 * p12t PHP Framework : /system/core/bootstrap.php
 *
 * Include all the requierd framework files, set up the first benchmark leg,
 * sets som system variables and runs the dispather.
 *
 * @package p12t
 * @author hepper
 * @copyright Copyright (c) 2010, Henrik Persson, Pay if you like it
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @since 0.1.0
 */

// Sets error reporting to show all errors.
error_reporting(E_ALL);

// Start up Benchmark as soon as possible.
Benchmark::set('Start');

// Set some system values
App::set('sys.version', '0.2.0');
App::set('sys.name', 'p12t Framework');
App::set('sys.fullname', 'Pay If Yoy Like It Framework');

// Invoke the dispather class and run the framework.
$p12t = new Dispatcher;
$p12t->run();

/**
 * Autoload function for automatic include of used core classes.
 *
 * @access public
 * @param string $name Name of class to include
 */
function __autoload($name) {
    if (loadFile('/core/' . strtolower($name) . '.php')) return true;
    if (loadFile('/helpers/' . strtolower($name) . '.php')) return true;
    if (loadFile('/apps/' . strtolower($name) . '.php')) return true;
    if (loadFile('/apps/system/' . strtolower($name) . '.php')) return true;
}

  /**
     * Try to load the file in the give path.
     *
     * First try to require the file frome the application folder. If that's not
     * successfull try to require the file from the system folder insted.
     *
     * @access public
     * @param string $path Holdes the path to the file to be loaded.
     * @return boolean Returns true if file requierd sucessfully.
     */
function loadFile($path) {

    // Load the file. First try from site and second from system.
    if (file_exists(SITE_PATH . $path)) {
        require_once(SITE_PATH . $path);
        return true;
    } elseif (file_exists(SYS_PATH . $path)) {
        require_once(SYS_PATH . $path);
        return true;
    } else {
        return false;
    }
}