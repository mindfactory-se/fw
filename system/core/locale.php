<?php

namespace p12t\core;

/**
 * p12t PHP Framework : /system/core/locale.php
 *
 * @package p12t
 * @author hepper
 * @copyright Copyright (c) 2010, Henrik Persson, Pay if you like it
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Configaration class for holding configaration values.
 *
 * @since 0.3.0
 * @access public
 * @todo include app locale
 * @todo detect locale by user agent
 * @todo detect locale by subdomain
 * @todo detect locale by url
 */
class Locale extends SingletonObject {

    public static function translate($str) {
        $t = self::get($str);
        return (empty($t) ? $str : $t);
    }
}