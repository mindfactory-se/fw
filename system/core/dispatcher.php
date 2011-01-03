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
        P12t::set('sys.version', '0.2.0');
        P12t::set('sys.name', 'p12t Framework');
        P12t::set('sys.fullname', 'Pay If Yoy Like It Framework');

        $this->loadRequierdFiles();
        Router::match();
        $this->checkControllers();
        $this->createController();
        $this->setData();
        $this->setLocale();
        $this->loadLocale();
        $this->invokeAction();

        if (Config::get('default.debug_level')) {
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
        P12t::loadSettings('router');
        P12t::loadSettings('config/default');
        P12t::loadSettings('config/db');
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

        $fileName = '/apps/' . P12t::get('sys.route.app') . '/' . P12t::get('sys.route.controller') . '_controller.php';
        if (!file_exists(\SITE_PATH . $fileName) AND !file_exists(\SYS_PATH . $fileName)) {
            P12t::set('sys.route.app', 'system');
            P12t::set('sys.route.controller', 'errors');
            P12t::set('sys.route.action', 'e404');
            P12t::set('sys.route.params', array(str_replace('/', '.', P12t::get('sys.route.visible'))));
        }
    }

    /**
     * Creates the controller.
     *
     * @access private
     */
    private function createController() {
        //Create the controller object.
        $this->controllerName = '\\p12t\\apps\\' . P12t::get('sys.route.app') . '\\' . ucfirst(P12t::get('sys.route.controller')) . 'Controller';
        $this->controller = new $this->controllerName;

        if (!method_exists($this->controller, P12t::get('sys.route.action'))) {
            $this->controller = new \p12t\apps\system\ErrorsController;
            P12t::set('sys.route.app', 'system');
            P12t::set('sys.route.controller', 'errors');
            P12t::set('sys.route.action', 'e404');
            P12t::set('sys.route.params', array(str_replace('/', '.', P12t::get('sys.route.visible'))));
        }
    }

    /**
     * Invokes the action.
     *
     * @access private
     */
    private function invokeAction() {
        if (!is_array(P12t::get('sys.route.params'))) {
            $this->controller->{P12t::get('sys.route.action')}();
        } else {
            call_user_func_array(array($this->controller, P12t::get('sys.route.action')), P12t::get('sys.route.params'));
        }
    }

    private function setData() {
        if (isset($_POST['data'])) {
            $this->controller->data = $_POST['data'];
            unset ($_POST);
        }
    }

    private function setLocale() {
        $methods = Config::get('default.locale_detection_methods');
        $lang = null;
        foreach ($methods as $method) {
            switch ($method) {
                case 'config':
                    $langs = Config::get('default.locale_languages');
                    $lang = $langs[0];
                    break;
                
            }
            if (!is_null($lang)) break;
        }
        P12t::set('sys.language', $lang);
    }

    private function loadLocale() {
        P12t::loadLocale('common');
    }
}