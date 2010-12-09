<?php

/**
 * p12t PHP Framework : /system/core/singeltonObject.php
 *
 * @package p12t
 * @author hepper
 * @copyright Copyright (c) 2010, Henrik Persson, Pay if you like it
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */

class SingeltonObject extends Object {

    /**
     * Instance of singelton object
     *
     * @access private
     * @var object
     */
    protected static $inctance = array();
	
    /**
     * Holdes the configurations values
     *
     * @access private
     * @var array
     */
    protected $values = array();
	
	
    /**
     * Private constructor to ensure singelton
     */
    protected function __construct() {
    }
	
    /**
     * The singelton method
     */
    final public static function &getInstance() {
        $calledClassName = get_called_class();
        if (!isset(self::$inctance[$calledClassName])) {
            self::$inctance[$calledClassName] = new $calledClassName;
        }
        return self::$inctance[$calledClassName];
    }


    /**
     * Set a new value
     *
     * @access public
     * @param string $name
     * @param mixed $value
     * @return boolean
     */

    public static function setInOrder($name, $value) {
        $_this =& self::getInstance();
        if (isset($name) && !empty($name) && isset($value)) {
            $_this->values[] = array($name => $value);
            return true;
        } else {
            return false;
        }
    }

    public static function set($name, $value) {
        $_this =& self::getInstance();
        if (isset($name) && !empty($name) && isset($value)) {
            $_this->values[$name] = $value;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get a value
     *
     * @access public
     * @param string $name
     * @return mixed Returns the value of the given name or false.
     */

    public static function get($name) {
        $_this =& self::getInstance();
        if (isset($_this->values[$name])) {
            return $_this->values[$name];
        } else {
            return '';
        }
    }
}