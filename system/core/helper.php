<?php

namespace p12t\core;

/**
 * p12t PHP Framework : /system/core/helper.php
 *
 * @package p12t
 * @author hepper
 * @copyright Copyright (c) 2010, Henrik Persson, Pay if you like it
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Base Helper class
 *
 * Common methods used in all helpers
 *
 * @since 0.1.0
 * @access public
 */
class Helper extends Object {

    /**
     * Holdes the dependent helper needed in the helper.
     * 
     * @var array
     */
    public $helpers = array();

    public function __construct(&$controller) {
        parent::__construct();
        $this->controller =& $controller;
    }
}
?>
