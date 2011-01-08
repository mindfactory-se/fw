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
Locale::set('p12t.date', '/^(?:(0?[1-9]|[12]\d|3[01])([ -\/\.]?)(0?[1-9]|1[012])\2(\d{2}|(?:19|20)\d{2}))$/');
Locale::set('p12t.date_format', 'dmy');
Locale::set('p12t.phone', '/^(?:\+?1)?[-. ]?\\(?[2-9][0-8][0-9]\\)?[-. ]?[2-9][0-9]{2}[-. ]?[0-9]{4}$/');
Locale::set('p12t.ssn', '/^(?!000|666|9[0-9][0-9]|73[4-9]|74[0-9])([0-6]\d{2}|7([0-6]\d|7[012]))([ -]?)(?!00)\d{2}\3(?!0000)\d{4}$/');
Locale::set('p12t.time_hm', '/^(?:[1-9]|0\d|1[012]):[0-5]\d (?:pm|am|PM|AM)$/');
Locale::set('p12t.time_hms', '/^(?:[1-9]|0\d|1[012]):[0-5]\d:[0-5]\d (?:pm|am|PM|AM)$/');
Locale::set('p12t.zip', '/^([0-9]{5})(-[0-9]{4})?$/i');