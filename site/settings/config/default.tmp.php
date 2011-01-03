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

namespace p12t\core;

// Debug configuration.
Config::set('default.debug_level', 1);

// Locale configuration.
Config::set('default.locale_languages', array('en'));
Config::set('default.locale_detection_methods', array('config'));