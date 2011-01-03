<?php

namespace p12t\apps\system;
/**
 * p12t PHP Framework : /system/mods/system/controllers/system_errors_controller.php
 *
 * @package p12t
 * @author hepper
 * @copyright Copyright (c) 2010, Henrik Persson, Pay if you like it
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Error controller the framework uses to display diffretn error messages.
 *
 * @since 0.1.0
 * @access public
 */
class ErrorsController extends AppController {

    public $helpers = array('Html');
    
    /**
     * An 404 error action.
     *
     * @access public
     */
    public function e404($param) {
        $param = str_replace('.', '/', $param);
        $this->render($this->set(array('param' => $param)));
    }
}