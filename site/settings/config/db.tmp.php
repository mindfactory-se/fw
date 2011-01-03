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

// Database config.
\p12t\core\Config::set('db.default.driver', 'mysql');
\p12t\core\Config::set('db.default.dns', 'mysql:host=localhost;dbname=my_db');
\p12t\core\Config::set('db.default.user', 'my_user');
\p12t\core\Config::set('db.default.password', 'my_password');

\p12t\core\Config::set('sys.debug.level', 1);