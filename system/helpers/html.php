<?php

/**
 * p12t PHP Framework : /system/helpers/view/html.php
 *
 * @package p12t
 * @author hepper
 * @copyright Copyright (c) 2010, Henrik Persson, Pay if you like it
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */

/**
 * HTML viewhelper
 *
 * Diffrent methods used to output HTML in the views.
 *
 * @since 0.1.0
 * @access public
 */
class Html extends Helper {

    /**
     * Makes a hypertext link tag.
     *
     * @access public
     * @param string $href URL that the link vill point to.
     * @param string $title The tite of the link.
     * @param array $options Options as name, value pairs.
     * @return string Link tag.
     */
    public static function a($href, $title, $options = array()) {
        if (!Html::isExternalUrl($href)) {
            $url = App::get('route.base') . $href;
        }
        return '<a href="' . $href . '"' . HTML::buildOptionsString($options) . '>' . $title .'</a>';
    }

    /**
     * Makes a css link tag.
     *
     * @access public
     * @param string $path Path to css file
     * @return string CSS link tag.
     */
    public static function css($path) {
        if (!Html::isExternalUrl($path)) {
            $path = App::get('route.base') . '/css/' . $path . '.css';
        }
        return sprintf('<link rel="stylesheet" type="text/css" href="%s" />', $path);
    }

    /**
     * Makes a meta charset tag.
     *
     * @access public
     * @param string $charset Charset to be set.
     * @return string Charset tag.
     */
    public static function charset($charset = 'uft-8') {
        return sprintf('<meta http-equiv="Content-Type" content="text/html; charset=%s" />', $charset);
    }

    /**
     * Makes a doctype tag.
     *
     * @access public
     * @param string $type Tupe of doctype to be set.
     * @return string Doctype tag.
     */
    public static function docType($type = 'xhtml-strict') {
        switch ($type) {
            case 'html':
                return '';
                break;
            case 'html4-strict':
                return '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">';
                break;
            case 'html4-trans':
                return '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
                break;
            case 'html4-frame':
                return '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">';
                break;
            case 'xhtml-strict':
                return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
                break;
            case 'xhtml-trans':
                return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
                break;
            case 'xhtml-frame':
                return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">';
                break;
            case 'xhtml11':
                return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">';
                break;
        }
    }

    /**
     * Makes an image tag.
     *
     * @access public
     * @param string $src The path to the image.
     * @param string $alt Alternative tect for the image.
     * @param array $options Options as name, value pairs.
     * @return string Image tag.
     */
    public static function img($src, $alt = '', $options = array()) {
        if (!Html::isExternalUrl($src)) {
            $src = App::get('route.base') . '/img/' . $src;
        }
        return '<img src="' . $src . '" alt="' . $alt . '"' . HTML::buildOptionsString($options) . ' />';
    }

    /**
     * Wrapper for img method.
     *
     * @access public
     * @see Html::img()
     */
    public static function image($src, $alt = '', $options = array()) {
        Html::img($src, $alt, $options);
    }

    /**
     * Wrapper for a method.
     *
     * @access public
     * @see Html::a()
     */
    public static function link($title, $url, $options = array()) {
        html::a($title, $url, $options);
    }

    /**
     * Builds a string of options to put in a tag.
     *
     * @access private
     * @param array $options Options as name, value pairs.
     * @return string
     */
    private static function buildOptionsString($options) {
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
    private static function isExternalUrl($url) {
        if (strpos($url, '://') > 0) {
            return true;
        }
    }
}
?>
