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
//p12t\core\Benchmark::set('Start');

// Set some system values
//App::set('sys.version', '0.2.0');
//App::set('sys.name', 'p12t Framework');
//App::set('sys.fullname', 'Pay If Yoy Like It Framework');

// Invoke the dispather class and run the framework.
$p12t = new p12t\core\Dispatcher;
$p12t->run();

/**
 * Autoload function for automatic include of used core classes.
 *
 * @access public
 * @param string $name Name of class to include
 */
function __autoload($name) {
    $name = us($name);
    loadFile('/' . str_replace(array('p12t\\', '\\'), array('', '/'), strtolower($name)) . '.php');
}

/**
 * Make underscore naming camelcase.
 *
 * 'foo_bar' becomes 'fooBar'
 *
 * @param string $str Underscored string
 * @return string Camelcased string
 */
function cc($str) {
  $words = explode('_', strtolower($str));

  $return = '';
  foreach ($words as $word) {
    $return .= ucfirst(trim($word));
  }

  return $return;
}

/**
 * Convenience function for echo().
 *
 * @param mixed $value Value to be echoed.
 */
function e($value) {
    echo $value;
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
    //echo SITE_PATH . $path . '<br />';
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

/**
 * Convenience function for print_r().
 *
 * @param array $param Variable to print out
 */
function pr($param) {
    echo '<pre>';
    print_r($param);
    echo '</pre>';
}

/**
 * Translates a given string.
 * 
 * Returns the translated string if it's found in the given language file. 
 * Othervise it returns the given string.
 * @param string $str 
 */
function t($str, $return = false, $language = null) {
    if ($return) {
        return $str;
    } else {
        echo $str;
    }
}

/**
 * Convenience function for var_dump().
 *
 * @param array $param Variable to print out
 */
function vd($param) {
    echo '<pre>';
    var_dump($param);
    echo '</pre>';
}

/**
 * Make camelcase naming underscore.
 *
 * 'fooBar' becomes 'foo_bar'
 *
 * @param string $str Camelcased string
 * @return string Underscored string
 */
function us($str) {
    return strtolower(preg_replace('/(?<=[a-z])([A-Z])/', '_$1', $str));
}