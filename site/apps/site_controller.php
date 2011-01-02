<?php

namespace p12t\apps;
/**
 * p12t PHP Framework : /app/mods/app_controller.php
 *
 * @package p12t
 * @author hepper
 * @copyright Copyright (c) 2010, Henrik Persson, Pay if you like it
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Application base controller
 *
 * Need something in every controller? Put it here.
 *
 * @since 0.1.0
 * @access public
 */
class SiteController extends \p12t\core\Controller {

    public $vHelpers = array('Html', 'Form');
}