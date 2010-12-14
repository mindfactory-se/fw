<?php

/**
 * p12t PHP Framework : /system/mods/cms/controllers/cms_static_controller.php
 *
 * @package p12t
 * @author hepper
 * @copyright Copyright (c) 2010, Henrik Persson, Pay if you like it
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */

/**
 * CMS controller that uses files on the hard drive to display pages.
 *
 * @since 0.1.0
 * @access public
 */
class CmsFileController extends AppCmsController {

    public function  __construct() {
        parent::__construct();
    }
    
    /**
     * Displays the requestetd static page.
     *
     * @access public
     * @param array Path to file to show.
     */
    public function view() {
        $path = func_get_args();
        $path = '/apps/cms/views/file/' . implode('/', $path) . '.php';
        $this->render($path);
    }
}