<?php

/**
 * p12t PHP Framework : /system/core/controller.php
 *
 * @package p12t
 * @author hepper
 * @copyright Copyright (c) 2010, Henrik Persson, Pay if you like it
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Conroller base class.
 *
 * Contains methods used in all controllers.
 * 
 * @since 1.0
 * @access public
 */
class Controller extends Object {

    /**
     * Contains all variables needed in the view.
     * 
     * @access protected
     * @var array
     */
    protected $viewVars = array();

    /**
     * Renders the view.
     *
     * Renders the view in tree steps. Fista the controller view. Second the mod
     * layout and third the site layout. If no path is given the view based on
     * controller and action is renderd.
     *
     * @access protected
     * @param string $path
     * @todo Render other then default layouts.
     */
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

    /**
     * Set a variabel to the view.
     *
     * Saves the given varable or array to be used in the view when rendering
     * the page.
     *
     * @access protected
     * @param mixed $params
     */
    protected function set($params) {
        $this->viewVars = array_merge($this->viewVars, $params);
    }
}
