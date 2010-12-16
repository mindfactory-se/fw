<?php

/**
 * p12t PHP Framework : /system/core/dispatcher.php
 *
 * @package p12t
 * @author hepper
 * @copyright Copyright (c) 2010, Henrik Persson, Pay if you like it
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Invokes the framework
 *
 * @since 0.1.0
 * @access public
 */
class Dispatcher extends Object {

    /**
     * Holdes the controller object.
     *
     * @access public
     * @var string
     */
    
    public $controller;

    /**
     * Holdes the full controller name.
     *
     * @access public
     * @var string
     */
    public $controllerName;

    public function  __construct() {
        parent::__construct();
    }

    /**
     * Runs the framework
     *
     * Invokes the router and loads the nececery files to create the requested
     * controller object and load s the requested action.
     *
     * @access public
     */
    public function run() {

        $this->loadRequierdFiles();
        Router::match();
        $this->loadControllers();
        $this->createController();
        if (isset($_POST['data'])) $this->controller->data = $_POST['data'];
        $this->invokeAction();

        if (Config::get('sys.debug.level')) {
            echo Benchmark::display();
            echo Log::display();
        }
    }

    /**
     * Load the requierd framework files.
     *
     * Loads the config files, sitecontroller, sitemodel and system appcontroller.
     *
     * @access private
     */
    private function loadRequierdFiles() {
        App::loadSettings('router');
        App::loadSettings('config/default');
        App::load('apps/site_controller');
        App::load('apps/system/app_system_controller');
        App::load('apps/site_model');
    }

    /**
     * Loads the controllers.
     *
     * Loads the requested appcontroller and the requested controller. If not
     * able to load the requested controllers we load the sytem error controllerz.
     *
     * @access private
     */
    private function loadControllers() {
        if (!App::loadController(App::get('sys.route.app') .'/app_' . App::get('sys.route.app') . '_controller')) {
            App::loadController('system/app_system_controller');
            App::set('sys.route.app', 'system');
            App::set('sys.route.controller', 'errors');
            App::set('sys.route.action', 'e404');
            App::set('sys.route.params', array(str_replace('/', '.', App::get('sys.route.visible'))));
        }
        
        if (!App::loadController(App::get('sys.route.app') . '/controllers/' . App::get('sys.route.app') . '_' . App::get('sys.route.controller') . '_controller')) {
            //$this->redirect('/system/errors/e404/' . str_replace('/', '.', App::get('sys.route.internal')));
            App::loadController('system/app_system_controller');
            App::loadController('system/controllers/system_errors_controller');
            App::set('sys.route.app', 'system');
            App::set('sys.route.controller', 'errors');
            App::set('sys.route.action', 'e404');
            App::set('sys.route.params', array(str_replace('/', '.', App::get('sys.route.visible'))));
        }
    }

    /**
     * Creates the controller.
     *
     * @access private
     */
    private function createController() {
        //Create the controller object.
        $this->controllerName = ucfirst(App::get('sys.route.app')) . ucfirst(App::get('sys.route.controller')) . 'Controller';
        $this->controller = new $this->controllerName;

        if (!method_exists($this->controller, App::get('sys.route.action'))) {
            App::loadController('system/app_system_controller');
            App::loadController('system/controllers/system_errors_controller');
            $this->controller = new SystemErrorsController;
            App::set('sys.route.app', 'system');
            App::set('sys.route.controller', 'errors');
            App::set('sys.route.action', 'e404');
            App::set('sys.route.params', array(str_replace('/', '.', App::get('sys.route.visible'))));
        }
    }

    /**
     * Invokes the action.
     *
     * @access private
     */
    private function invokeAction() {
        if (!is_array(App::get('sys.route.params'))) {
            $this->controller->{App::get('sys.route.action')}();
        } else {
            call_user_func_array(array($this->controller, App::get('sys.route.action')), App::get('sys.route.params'));
        }
    }
}