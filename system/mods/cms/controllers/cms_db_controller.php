<?php

/**
 * p12t PHP Framework : /system/mods/cms/controllers/cms_db_controller.php
 *
 * @package p12t
 * @author hepper
 * @copyright Copyright (c) 2010, Henrik Persson, Pay if you like it
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */

/**
 * CMS controller that uses database to store pages.
 *
 * @since 1.0
 * @access public
 */

class CmsDbController extends ModCmsController {
    public function view($id = NULL) {
    $model = App::loadModel('cms.db');
    //print_r($model->view($id));
    $this->set(array('records' => $model->view($id)));
    $this->render();
}
}