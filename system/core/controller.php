<?php

namespace p12t\core;

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
     * Contains data posted with form.
     *
     * @access protected
     * @var array
     */
    public $data = array();

    /**
     * Holdes the viev object.
     * 
     * @var object
     */
    public $view;

    /**
     * Contains all variables needed in the view.
     * 
     * @access protected
     * @var array
     */
    public $viewVars = array();

    /**
     * Applayoyt to render.
     *
     * @access private
     * @var string
     */
    public $appLayout = 'default';

    /**
     * Layout to render.
     *
     * @access protected
     * @var string
     */
    public $layout = 'default';

    /**
     * Holdes validation errors
     *
     * @var array
     */
    public $validationErrors = array();

    /**
     * Viev helpers to be loaded.
     *
     * @var array
     */
    public $vHelpers = array();

    protected function mergeHelpers() {
        $siteVars = get_class_vars('\\p12t\\apps\\SiteController');
        $appVars = get_class_vars('\\p12t\\apps\\' . P12t::get('sys.route.app') . '\\AppController');
        $this->vHelpers = array_unique(array_merge($siteVars['vHelpers'], $appVars['vHelpers'], $this->vHelpers));        
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

    protected function render($path = '') {

        $this->mergeHelpers();
        $this->view = new View($this);
        $this->view->render($path);

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
    public function set($params) {
        $this->viewVars = array_merge($this->viewVars, $params);
    }
}
