<?php

/**
 * p12t PHP Framework : /app/mods/foo/controllers/foo_bar_model.php
 *
 * @package p12t
 * @author hepper
 * @copyright Copyright (c) 2010, Henrik Persson, Pay if you like it
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Example mod to show file structure and basic usage.
 *
 * @since 0.1.0
 * @access public
 */
class FooBarModel extends modFooModel {

    public function __construct() {
        
    }

    public function index() {
        return 'Mod: foo - OK<br>Controller: bar - OK<br>Action: index - OK';
    }
}