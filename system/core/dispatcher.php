<?php

namespace p12t\core;

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

    /**
     * Runs the framework
     *
     * Invokes the router and loads the nececery files to create the requested
     * controller object and load s the requested action.
     *
     * @access public
     */
    public function run() {

        Benchmark::set('Start');

        // Set some system values
        App::set('sys.version', '0.2.0');
        App::set('sys.name', 'p12t Framework');
        App::set('sys.fullname', 'Pay If Yoy Like It Framework');

        $this->loadRequierdFiles();
        Router::match();
        $this->checkControllers();
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
    }

    /**
     * Loads the controllers.
     *
     * Loads the requested appcontroller and the requested controller. If not
     * able to load the requested controllers we load the sytem error controllerz.
     *
     * @access private
     */
    private function checkControllers() {

        $fileName = '/apps/' . App::get('sys.route.app') . '/controllers/' . App::get('sys.route.app') . '_' . App::get('sys.route.controller') . '_controller.php';
        if (!file_exists(\SITE_PATH . $fileName) AND !file_exists(\SYS_PATH . $fileName)) {
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
        $this->controllerName = '\\p12t\\apps\\' . App::get('sys.route.app') . '\\controllers\\' . ucfirst(App::get('sys.route.app')) . ucfirst(App::get('sys.route.controller')) . 'Controller';
        $this->controller = new $this->controllerName;

        if (!method_exists($this->controller, App::get('sys.route.action'))) {
            $this->controller = new \p12t\apps\system\controllers\SystemErrorsController;
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