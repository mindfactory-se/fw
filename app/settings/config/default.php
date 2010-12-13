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


Config::set('sys.debug.level', 1);

// Database config.
Config::set('db.default.prefix', 'mysql');
Config::set('db.default.name', 'p12t');
Config::set('db.default.user', 'my_user');
Config::set('db.default.password', 'my_password');
Config::set('db.default.host', 'localhost');
Config::set('db.default.port', '3306');
Config::set('db.default.socket', '/Applications/MAMP/tmp/mysql/mysql.sock');
Config::set('db.default.useSocket', TRUE);