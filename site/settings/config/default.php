<?php

/**
 * p12t PHP Framework : /app/settings/config/default.php
 *
 * @package p12t
 * @author hepper
 * @copyright Copyright (c) 2010, Henrik Persson, Pay if you like it
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @since 0.1.0
 */


p12t\core\Config::set('sys.debug.level', 1);

// Database config.
p12t\core\Config::set('db.default.prefix', 'mysql');
p12t\core\Config::set('db.default.name', 'p12t');
p12t\core\Config::set('db.default.user', 'my_user');
p12t\core\Config::set('db.default.password', 'my_password');
p12t\core\Config::set('db.default.host', 'localhost');
p12t\core\Config::set('db.default.port', '3306');
p12t\core\Config::set('db.default.socket', '/Applications/MAMP/tmp/mysql/mysql.sock');
p12t\core\Config::set('db.default.useSocket', TRUE);