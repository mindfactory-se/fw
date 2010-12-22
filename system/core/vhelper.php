<?php

namespace p12t\core;
/**
 * p12t PHP Framework : /system/core/vhelper.php
 *
 * @package p12t
 * @author hepper
 * @copyright Copyright (c) 2010, Henrik Persson, Pay if you like it
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Base view helper class
 *
 * Common methods used in all helpers
 *
 * @since 0.2.0
 * @access public
 */
class Vhelper extends Helper {

    public $vHelpers = array();

    /**
     * Builds a string of options to put in a tag.
     *
     * @access private
     * @param array $options Options as name, value pairs.
     * @return string
     */
    protected function buildOptionsString($options) {
        $option = '';
        foreach($options as $key => $field) {
                $option .= ' ' . $key . '="' . $field . '"';
            }
        return $option;
    }

    /**
     * Checks if a url is external.
     *
     * @access private
     * @param string $url URl to be checked.
     * @return bool True if URL is external.
     */
    protected function isExternalUrl($url) {
        if (strpos($url, '://') > 0) {
            return true;
        }
    }
}
?>