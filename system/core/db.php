<?php

/**
 * p12t PHP Framework : /system/core/db.php
 *
 * @package p12t
 * @author hepper
 * @copyright Copyright (c) 2010, Henrik Persson, Pay if you like it
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Handels database connections and querys.
 *
 * @since 0.1.0
 * @access public
 */
class Db extends Object {
    /**
     * Instance of singleton objects
     *
     * @access protected
     * @var object
     */
    protected static $inctance = array();

    /**
     * Private constructor to ensure singleton
     *
     * @access private
     */
    private function __construct() {
    }

    /**
     * The singleton method.
     *
     * If the requierd database connection isn't set a new is created.
     *
     * @access public
     * @return object An instanse of the requested class.
     */
    final public static function &getInstance($db = 'default') {
        
        if (!isset(self::$inctance[$db])) {
            $dsn = NULL;
            $dsn .= Config::get('db.' . $db . '.prefix') . ':';
            if (Config::get('db.' . $db . '.useSocket')) {
                $dsn .=  'unix_socket=' . Config::get('db.' . $db . '.socket') . ';';
            } else {
                $dsn .=  'host=' . Config::get('db.' . $db . '.host') . ';port=' . Config::get('db' . $db . 'port');
            }
            $dsn .= 'dbname=' . Config::get('db.' . $db . '.name');
            $user = Config::get('db.' . $db . '.user');
            $password = Config::get('db.' . $db . '.password');

            try {
                self::$inctance[$db] = new PDO($dsn, $user, $password);
            } catch (PDOException $e) {
                die("PDO CONNECTION ERROR: " . $e->getMessage() . "<br/>");
            }

        }
        return self::$inctance[$db];
    }

}
?>
