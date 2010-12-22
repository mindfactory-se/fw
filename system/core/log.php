<?php

namespace p12t\core;

/**
 * p12t PHP Framework : /system/core/log.php
 *
 * @package p12t
 * @author hepper
 * @copyright Copyright (c) 2010, Henrik Persson, Pay if you like it
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Class to log mesages in the framwork
 *
 * @since 0.1.0
 * @access public
 */
class Log extends SingletonObject {

    /**
     * Sets a log mesage.
     *
     * Overides the parent set metod to be abel to set diffrent types of log
     * messages.
     *
     * @access public
     * @param mixed $msg
     * @param string $type notice, debug or error
     */
    public static function set($msg, $type = 'debug') {
        $_this =& self::getInstance();
        switch($type) {
            case 'error':
            case 'notice':
            case 'debug':
                $_this->values[$type][] = $msg;
                break;
        }
    }

    /**
     * Render the log values to displays as HTML.
     *
     * @access public
     * @return string HTML output.
     */
    public static function display() {
        $_this =& self::getInstance();
        $out = '<div id="log-container">';
        $out .= '<h3>Log</h3>';
        
        foreach ($_this->values as $type => $values) {
            //echo '<pre>' . print_r($value) . '</pre>';
            $out .= '<h4>' . $type . '</h4>';
            foreach ($values as $msg) {
                $out .= $msg . '<br />';
            }
        }

        $out .= '</div>';

        return $out;
    }
}
?>
