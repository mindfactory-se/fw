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

// Includes some files neceesary for the framework.

require_once(SITE_PATH . '/settings/config/default.php');
require_once(SITE_PATH . '/settings/router.php');
require_once(SITE_PATH . '/settings/router.php');

// Set some system values
App::set('sys.version', '0.1.0');
App::set('sys.name', 'p12t Framework');
App::set('sys.Fullname', 'Pay If Yoy Like It Framework');

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
    include SYS_PATH . '/core/' . strtolower($name) . '.php';
}