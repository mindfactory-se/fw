<?php

/**
 * p12t PHP Framework : /site/locale/en/_p12t.php
 *
 * @package p12t
 * @author hepper
 * @copyright Copyright (c) 2010, Henrik Persson, Pay if you like it
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @since 0.3.0
 */

namespace p12t\core;

Locale::set('p12t.chars', '');
Locale::set('p12t.phone', '/^(?:\+?1)?[-. ]?\\(?[2-9][0-8][0-9]\\)?[-. ]?[2-9][0-9]{2}[-. ]?[0-9]{4}$/');
Locale::set('p12t.zip', '/^([0-9]{5})(-[0-9]{4})?$/i');