<?php

/**
 * p12t PHP Framework : /system/mods/cms/controllers/cms_static_controller.php
 *
 * @package p12t
 * @author hepper
 * @copyright Copyright (c) 2010, Henrik Persson, Pay if you like it
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */

class CmsStaticController extends ModCmsController {

    public function view() {
        $path = func_get_args();
        $path = '/mods/cms/views/static/' . implode('/', $path[0]) . '.php';
        $this->render($path);
    }
}