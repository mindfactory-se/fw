<?php

namespace p12t\core;

/**
 * p12t PHP Framework : /system/core/view.php
 *
 * @package p12t
 * @author hepper
 * @copyright Copyright (c) 2010, Henrik Persson, Pay if you like it
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Renders the view and layouts.
 *
 * @since 0.2.0
 * @access public
 */
class View extends Object {


    /**
     * Contains data posted with form.
     *
     * @access protected
     * @var array
     */
    private $data = array();

    /**
     * Contains all helpers needed in the view.
     *
     * @access protected
     * @var array
     */
    private $helpers = array();

    /**
     * Contains all variables needed in the view.
     *
     * @access protected
     * @var array
     */
    private $viewVars = array();

    /**
     * Applayoyt to render.
     *
     * @access private
     * @var string
     */
    private $appLayout = 'default';

    /**
     * Layout to render.
     *
     * @access protected
     * @var string
     */
    private $layout = 'default';

    public function  __construct(&$controller) {
        parent::__construct();
        $this->controller =& $controller;
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
        $this->controller->viewVars = array_merge($this->viewVars, $params);
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
    public function render($path) {

        $this->triggerHelpers();
        // Render view
        if (empty($path)) {
            $path = '/apps/' . App::get('sys.route.app') . '/views/' . App::get('sys.route.controller') . '/' . App::get('sys.route.action') . '.php';
        }
        $this->set(array('viewContent' => $this->loadView($path)));
        ob_end_clean();
        
        // Render app layout
        $path = '/layouts/' . App::get('sys.route.app') . '/' . $this->controller->appLayout . '.php';
        $this->controller->set(array('content' => $this->loadView($path)));
        ob_end_clean();
        
        // Render site layout
        $path = '/layouts/' . $this->controller->layout . '.php';
        $output = $this->loadView($path);
        ob_end_clean();
        
        echo $output;
    }

    private function loadView($path) {
        extract($this->controller->viewVars);
        ob_start();
        if (file_exists(SITE_PATH . $path)) {
            include(SITE_PATH . $path);
        } elseif (file_exists(SYS_PATH . $path)) {
            include(SYS_PATH . $path);
        }
        return ob_get_contents();
    }

    private function triggerHelpers() {
        
        foreach ($this->controller->vHelpers as $helper) {
            $helperClass = '\\p12t\\helpers\\' . $helper;
            $this->{strtolower($helper)} = new $helperClass($this->controller);
            foreach ($this->{strtolower($helper)}->vHelpers as $helper2) {
                $helperClass = '\\p12t\\helpers\\' . $helper2;
                $this->{strtolower($helper)}->{strtolower($helper2)} = new $helperClass($this->controller);
            }
        }
    }
}
?>
