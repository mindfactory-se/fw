<?php

/**
 * p12t PHP Framework : /system/core/app.php
 *
 * @package p12t
 * @author hepper
 * @copyright Copyright (c) 2010, Henrik Persson, Pay if you like it
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Containing method that needs to be accessed anywhere in the framework
 *
 * @since 1.0
 * @access public
 */
class App extends SingeltonObject {

    /**
     * Loads the given file from folder
     *
     * @param string $name
     * @return boolean Returns true if file loaded
     */
    public static function load($name) {
        $path = '/' . $name . '.php';
        return App::loadFile($path);
    }

    /**
     * Loads the given file from controllerfolder
     *
     * @param string $name
     * @return boolean Returns true if file loaded
     */
    public static function loadController($name) {
        $path = '/mods/' . $name . '.php';
        return App::loadFile($path);
    }
    
    /**
     * Loads the given file from corefolder
     *
     * @param string $name
     * @return boolean Returns true if file loaded
     */
    public static function loadCore($name) {
        $path = '/core/' . $name . '.php';
        return App::loadFile($path);
    }

    /**
     * Loads the given file from settingsfolder
     *
     * @param string $name
     * @return boolean Returns true if file loaded
     */
    public static function loadSettings($name) {
        $path = '/settings/' . $name . '.php';
        return App::loadFile($path);
    }

    /**
     * Loads the given file from modelfolder
     *
     * @param string $name
     * @return boolean Returns true if file loaded
     */
    public static function loadModel($name) {
        $name = explode('.', $name);
        
        //Load mod model
        $path = '/mods/' . $name[0] . '/mod_' . $name[0] . '_model.php';
        App::loadFile($path);

        //Load requested model
        $path = '/mods/' . $name[0] . '/models/' . $name[0] . '_' . $name[1] . '_model.php';
        if (App::loadFile($path)) {
            $modelName = ucfirst($name[0]) . ucfirst($name[1]) . 'Model';
            return new $modelName;
        }
    }

    /**
     * Loads the given file from viewfolder
     *
     * @param string $name
     * @return boolean Returns true if file loaded
     */
    public static function loadView($name, $data) {
        $name = explode('.', $name);
        $path = '/mods/' . $name[0] . '/views/' . $name[1] . '/' . $name[2] . '.php';
        return App::loadFile($path);
    }

    /**
     * Loads the given file from viewhelperfolder
     *
     * @param string $name
     * @return boolean Returns true if file loaded
     */
    public static function loadViewHelper($name) {
        $path = '/helpers/view/' . $name . '.php';
        return App::loadFile($path);
    }

    public function loadConfig($name) {
        $path = '/settings/config/' . $name . '.php';
        return App::loadFile($path);
    }

    public static function loadFile($path, $data = null) {

        if ($data) {
            extract($data);
        }
        // Load the file. First try from app and second from system.
        if (file_exists(APP_PATH . $path)) {
            require_once(APP_PATH . $path);
            return true;
        } elseif (file_exists(SYS_PATH . $path)) {
            require_once(SYS_PATH . $path);
            return true;
        } else {
            return false;
        }
    }
}