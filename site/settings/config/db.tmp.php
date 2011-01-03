<?php

/**
 * p12t PHP Framework : /app/settings/config/db.php
 *
 * @package p12t
 * @author hepper
 * @copyright Copyright (c) 2010, Henrik Persson, Pay if you like it
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @since 0.2.0
 */

namespace p12t\core;

// Database config.
Config::set('db.default.driver', 'mysql');
Config::set('db.default.dns', 'mysql:host=localhost;dbname=my_db');
Config::set('db.default.user', 'my_user');
Config::set('db.default.password', 'my_password');