<?php

/**
 * p12t PHP Framework : /system/core/object.php
 *
 * @package p12t
 * @author hepper
 * @copyright Copyright (c) 2010, Henrik Persson, Pay if you like it
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Base class for all clases in the framework.
 *
 * @since 0.1.0
 * @access public
 */
class Object {

    /**
     * Redirects to the given url.
     *
     * @param string $url Url to be redirectetd to.
     */
    public function redirect($url) {
        echo header('Location: ' . $url);
        exit;
    }
}