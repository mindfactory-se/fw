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
 * @since 0.1.0
 * @access public
 */
class App extends SingletonObject {

    /**
     * Loads the given file from given path.
     *
     * @access public
     * @param string $name The name or path of the file to be loaded.
     * @return boolean Returns true if file loaded
     */
    public static function load($name) {
        $path = '/' . $name . '.php';
        return App::loadFile($path);
    }

    /**
     * Loads the given file from controllerfolder
     *
     * @access public
     * @param string $name The name of the file to be loaded.
     * @return boolean Returns true if file loaded
     */
    public static function loadController($name) {
        $path = '/apps/' . $name . '.php';
        return App::loadFile($path);
    }

    /**
     * Loads the given file from settingsfolder
     *
     * @access public
     * @param string $name The name of the file to be loaded.
     * @return boolean Returns true if file loaded
     */
    public static function loadSettings($name) {
        $path = '/settings/' . $name . '.php';
        return App::loadFile($path);
    }

    /**
     * Loads the given file from modelfolder
     *
     * @access public
     * @param string $name The name of the file to be loaded.
     * @return boolean Returns true if file loaded
     */
    public static function loadModel($name) {
        $name = explode('.', $name);
        
        //Load mod model
        $path = '/apps/' . $name[0] . '/app_' . $name[0] . '_model.php';
        App::loadFile($path);

        //Load requested model
        $path = '/apps/' . $name[0] . '/models/' . $name[0] . '_' . $name[1] . '_model.php';
        if (App::loadFile($path)) {
            $modelName = ucfirst($name[0]) . ucfirst($name[1]) . 'Model';
            return new $modelName;
        }
    }

    /**
     * Loads the given file from viewfolder
     *
     * @access public
     * @param string $name The name of the file to be loaded.
     * @return boolean Returns true if file loaded
     */
    public static function loadView($name, $data) {
        $name = explode('.', $name);
        $path = '/apps/' . $name[0] . '/views/' . $name[1] . '/' . $name[2] . '.php';
        return App::loadFile($path);
    }

    /**
     * Loads the given file from viewhelperfolder
     *
     * @access public
     * @param string $name The name of the file to be loaded.
     * @return boolean Returns true if file loaded
     */
    public static function loadHelper($name) {
        $path = '/helpers/' . $name . '.php';
        return App::loadFile($path);
    }

    /**
     * Loads the given file from configfolder
     *
     * @access public
     * @param string $name The name of the file to be loaded.
     * @return boolean Returns true if file loaded
     */
    public function loadConfig($name) {
        $path = '/settings/config/' . $name . '.php';
        return App::loadFile($path);
    }

    /**
     * Try to load the file in the give path.
     *
     * First try to require the file frome the application folder. If that's not
     * successfull try to require the file from the system folder insted.
     *
     * @access public
     * @param string $path Holdes the path to the file to be loaded.
     * @return boolean Returns true if file requierd sucessfully.
     */
    public static function loadFile($path, $data = null) {

        if ($data) {
            extract($data);
        }
        // Load the file. First try from app and second from system.
        if (file_exists(SITE_PATH . $path)) {
            require_once(SITE_PATH . $path);
            return true;
        } elseif (file_exists(SYS_PATH . $path)) {
            require_once(SYS_PATH . $path);
            return true;
        } else {
            return false;
        }
    }
}