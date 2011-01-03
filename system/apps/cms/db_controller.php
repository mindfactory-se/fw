<?php

namespace p12t\apps\cms;

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
 * @since 0.1.0
 * @access public
 */

class DbController extends AppController {
    
    public function view($id = NULL) {
    $model = new models\DbModel($this);
    $this->set(array('records' => $model->view($id)));
    $this->render();
}
}