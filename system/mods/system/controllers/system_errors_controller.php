<?php

/**
 * p12t PHP Framework : /system/mods/system/controllers/system_errors_controller.php
 *
 * @package p12t
 * @author hepper
 * @copyright Copyright (c) 2010, Henrik Persson, Pay if you like it
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */

class SystemErrorsController extends ModSystemController{

    public function e404() {
        $this->render();
    }
}