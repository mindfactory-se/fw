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
 * @since 1.0
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
     * controller object and load s the requestet action.
     *
     * @access public
     * @todo Make submetods in run().
     */
    public function run() {
        if(!App::loadSettings('router')) {
            die('Error: settings/router not loaded');
        }

        Router::match();
        $this->loadDefaultHelpers();
        
        // Load controllers
        App::load('mods/app_controller');
        App::load('mods/system/mod_system_controller');
        if (!App::loadController(App::get('sys.route.mod') .'/mod_' . App::get('sys.route.mod') . '_controller')) {
            $this->redirect('/system/errors/e404/' . str_replace('/', '.', App::get('sys.route.internal')));
        }
        if (!App::loadController(App::get('sys.route.mod') . '/controllers/' . App::get('sys.route.mod') . '_' . App::get('sys.route.controller') . '_controller')) {
            $this->redirect('/system/errors/e404/' . str_replace('/', '.', App::get('sys.route.internal')));
        }
        //App::loadController(App::get('route.mod') .'/mod_' . App::get('route.mod') . '_controller');
        //App::loadController(App::get('route.mod') . '/controllers/' . App::get('route.mod') . '_' . App::get('route.controller') . '_controller');

        // Load appModel
        App::load('mods/app_model');

        //Create the controller object.
        $this->controllerName = ucfirst(App::get('sys.route.mod')) . ucfirst(App::get('sys.route.controller')) . 'Controller';
        $this->controller = new $this->controllerName;
        
        //Loads the action;
        $this->controller->{App::get('sys.route.action')}(App::get('sys.route.params'));

        if (Config::get('sys.debug.level')) {
            echo Benchmark::display();
            echo Log::display();
        }
    }

    /**
     * Loads the default helpers used in the framework.
     *
     * @access private
     */
    private function loadDefaultHelpers() {
        if (!App::loadViewhelper('Html'))
    die('Error: helpers/view/html not loaded');
    }
}