<?php

/**
 * p12t PHP Framework : /system/mods/cms/models/cms_dynamic_model.php
 *
 * @package p12t
 * @author hepper
 * @copyright Copyright (c) 2010, Henrik Persson, Pay if you like it
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */

/**
 * CMS model that connect to the db.
 *
 * @since 0.1.0
 * @access public
 */
class CmsDbModel extends AppCmsModel {

    public function view($id) {
        $db = Db::getInstance();
        return $db->query('SELECT title, body FROM cms_db WHERE id='. $id)->fetch();
    }
}