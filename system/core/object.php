<?php

/**
 * p12t PHP Framework : /system/core/object.php
 *
 * @package p12t
 * @author hepper
 * @copyright Copyright (c) 2010, Henrik Persson, Pay if you like it
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */

class Object {

    public function redirect($url) {
        echo header('Location: ' . $url);
        exit;
    }
}