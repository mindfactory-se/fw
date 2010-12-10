<?php

/**
 * p12t PHP Framework : /system/core/singletonObject.php
 *
 * @package p12t
 * @author hepper
 * @copyright Copyright (c) 2010, Henrik Persson, Pay if you like it
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Base class for all the singeltons in the framwork
 *
 * @since 1.0
 * @access public
 */
class SingletonObject extends Object {

    /**
     * Instance of singleton objects
     *
     * @access protected
     * @var object
     */
    protected static $inctance = array();
	
    /**
     * Holdes the values set by the class
     *
     * @access protected
     * @var array
     */
    protected $values = array();
	
	
    /**
     * Private constructor to ensure singleton
     *
     * @access private
     */
    private function __construct() {
    }
	
    /**
     * The singelton method.
     *
     * If no instanse of the class exists a new is created an returned.
     *
     * @access public
     * @return object An instanse of the requested class.
     */
    final public static function &getInstance() {
        $calledClassName = get_called_class();
        if (!isset(self::$inctance[$calledClassName])) {
            self::$inctance[$calledClassName] = new $calledClassName;
        }
        return self::$inctance[$calledClassName];
    }


    /**
     * Set a new value.
     *
     * Sets a value so it could be returned in the same order as its set.
     *
     * @access public
     * @param string $name Name om variable to be set
     * @param mixed $value Value of varible to be set.
     * @return bool True if value is set.
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

      /**
     * Set a new value.
     *
     * @access public
     * @param string $name Name om variable to be set
     * @param mixed $value Value of varible to be set.
     * @return bool True if value is set.
     */
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
     * @param string $name Name of variable to be viewed.
     * @return mixed Returns the value of the given variable or false.
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