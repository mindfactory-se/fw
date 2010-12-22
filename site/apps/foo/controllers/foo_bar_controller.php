<?php

namespace p12t\apps\foo\controllers;

/**
 * p12t PHP Framework : /app/mods/foo/controllers/foo_bar_controller.php
 *
 * @package p12t
 * @author hepper
 * @copyright Copyright (c) 2010, Henrik Persson, Pay if you like it
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Example app to show file structure and basic usage.
 *
 * @since 0.1.0
 * @access public
 */
class FooBarController extends \p12t\apps\foo\AppFooController {

    public $vHelpers = array('Form');

    public function  __construct() {
        parent::__construct();
    }
    
    public function index() {
        $fooBar = new \p12t\apps\foo\models\FooBarModel;
        //$this->set(array('msg' => $fooBar->index()));
        $this->set(array('msg' => $this->data));
        $this->render();
    }
}
