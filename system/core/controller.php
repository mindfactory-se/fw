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
 * @since 0.1.0
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
     * Applayoyt to render.
     *
     * @access private
     * @var string
     */
    protected $appLayout = 'default';

    /**
     * Layout to render.
     *
     * @access protected
     * @var string
     */
    protected $layout = 'default';

    public function  __construct() {
        parent::__construct();
    }

    /**
     * Redirects to the given url.
     *
     * @param string $url Url to be redirectetd to.
     */
    public function redirect($url) {
        echo header('Location: ' . $url);
        exit;
    }

    /**
     * Renders the view.
     *
     * Renders the view in tree steps. First the controller view. Second the app
     * layout and third the site layout. If no path is given the view based on
     * controller and action is renderd.
     *
     * @access protected
     * @param string $path
     */
    protected function render($path = '') {
        extract($this->viewVars);

        if (empty($path)) {
            $path = '/apps/' . App::get('sys.route.app') . '/views/' . App::get('sys.route.controller') . '/' . App::get('sys.route.action') . '.php';
        }
        ob_start();
        App::loadFile($path, $this->viewVars);
        $this->set(array('viewContent' => ob_get_contents()));
        ob_end_clean();

        // Render mod layout
        $path = '/layouts/' . App::get('sys.route.app') . '/' . $this->appLayout . '.php';
        ob_start();
        App::loadFile($path, $this->viewVars);
        $this->set(array('content' => ob_get_contents()));
        ob_end_clean();

        // Render app layout
        $path = '/layouts/' . $this->layout . '.php';
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
