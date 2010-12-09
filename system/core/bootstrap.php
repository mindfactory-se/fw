<?php

/**
 * p12t PHP Framework : /system/core/bootstrap.php
 *
 * @package p12t
 * @author hepper
 * @copyright Copyright (c) 2010, Henrik Persson, Pay if you like it
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */

// Sets error reporting to show all errors.
error_reporting(E_ALL);

//Includes som files nececery for the framework
require_once('object.php');
require_once('singeltonObject.php');
require_once('benchmark.php');

// Start up Benchmark as soon as possible.
Benchmark::set('start');

// Continiue to load files.
require_once('app.php');
require_once('log.php');
require_once('config.php');
require_once('controller.php');
require_once('model.php');
require_once(APP_PATH . '/settings/config/default.php');
require_once('router.php');
require_once('dispatcher.php');
require_once(APP_PATH . '/settings/router.php');
require_once('helper.php');
require_once('view_helper.php');
require_once('controller_helper.php');
require_once('model_helper.php');
require_once(APP_PATH . '/settings/router.php');

if (!App::loadViewhelper('Html'))
    die('Error: helpers/view/html not loaded');

// Set some system values
App::set('sys.version', '1.0');
App::set('sys.name', 'p12t PHP Framework');
App::set('sys.Fullname', 'Pay If Yoy Like It PHP Framework');

$p12t = new Dispatcher;
$p12t->run();