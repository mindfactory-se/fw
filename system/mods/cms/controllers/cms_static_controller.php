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
 * @since 1.0
 * @access public
 */
class CmsStaticController extends ModCmsController {

    /**
     * Displays the requestetd static page.
     *
     * @access public
     * @todo Chek if it works with subfolders.
     * @todo Make docbloc about param.
     */
    public function view() {
        $path = func_get_args();
        $path = '/mods/cms/views/static/' . implode('/', $path[0]) . '.php';
        $this->render($path);
    }
}