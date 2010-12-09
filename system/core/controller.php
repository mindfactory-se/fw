<?php

/**
 * p12t PHP Framework : /system/core/controller.php
 *
 * @package p12t
 * @author hepper
 * @copyright Copyright (c) 2010, Henrik Persson, Pay if you like it
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */

class Controller extends Object {

    protected $viewVars = array();

    protected function render($path = '') {
        extract($this->viewVars);

        if (empty($path)) {
            $path = '/mods/' . App::get('sys.route.mod') . '/views/' . App::get('sys.route.controller') . '/' . App::get('sys.route.action') . '.php';
        }
        ob_start();
        App::loadFile($path, $this->viewVars);
        $this->set(array('viewContent' => ob_get_contents()));
        ob_end_clean();

        // Render mod layout
        $path = '/layouts/' . App::get('sys.route.mod') . '/default.php';
        ob_start();
        App::loadFile($path, $this->viewVars);
        $this->set(array('content' => ob_get_contents()));
        ob_end_clean();

        // Render app layout
        $path = '/layouts/default.php';
        ob_start();
        App::loadFile($path, $this->viewVars);
        $output = ob_get_contents();
        ob_end_clean();

        echo $output;
    }

    protected function set($params) {
        $this->viewVars = array_merge($this->viewVars, $params);
    }
}
