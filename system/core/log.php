<?php

/**
 * p12t PHP Framework : /system/core/log.php
 *
 * @package p12t
 * @author hepper
 * @copyright Copyright (c) 2010, Henrik Persson, Pay if you like it
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Description of log
 *
 * @author hepper
 */
class Log extends SingeltonObject {

    public static function set($msg, $type = 'debug') {
        $_this =& self::getInstance();
        switch($type) {
            case 'error':
                $_this->values[$type][] = $msg;
                break;
            case 'notice':
                $_this->values[$type][] = $msg;
                break;
            case 'debug':
                $_this->values[$type][] = $msg;
                break;
        }
    }

    public static function display() {
        $_this =& self::getInstance();
        $out = '<div id="log-container">';
        $out .= '<h3>Log</h3>';
        //echo '<pre>' . print_r($_this->logValues) . '</pre>';
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
