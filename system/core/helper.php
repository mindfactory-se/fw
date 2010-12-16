<?php

/**
 * p12t PHP Framework : /system/core/helper.php
 *
 * @package p12t
 * @author hepper
 * @copyright Copyright (c) 2010, Henrik Persson, Pay if you like it
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Base Helper class
 *
 * Common methods used in all helpers
 *
 * @since 0.1.0
 * @access public
 */
class Helper extends Object{
    
    /**
     * Builds a string of options to put in a tag.
     *
     * @access private
     * @param array $options Options as name, value pairs.
     * @return string
     */
    protected static function buildOptionsString($options) {
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
    protected static function isExternalUrl($url) {
        if (strpos($url, '://') > 0) {
            return true;
        }
    }
}
?>
