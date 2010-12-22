<?php

namespace p12t\helpers;

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
class Html extends \p12t\core\Vhelper {

    /**
     * Makes a hypertext link tag.
     *
     * @access public
     * @param string $href URL that the link vill point to.
     * @param string $title The tite of the link.
     * @param array $options Options as name, value pairs.
     * @return string Link tag.
     */
    public function a($href, $title, $options = array()) {
        if (!$this->isExternalUrl($href)) {
            $url = \p12t\core\App::get('sys.route.base') . $href;
        }
        return '<a href="' . $href . '"' . $this->buildOptionsString($options) . '>' . $title .'</a>';
    }

    /**
     * Makes a css link tag.
     *
     * @access public
     * @param string $path Path to css file
     * @return string CSS link tag.
     */
    public function css($path) {
        if (!$this->isExternalUrl($path)) {
            $path = \p12t\core\App::get('sys.route.base') . '/css/' . $path . '.css';
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
    public function charset($charset = 'uft-8') {
        return sprintf('<meta http-equiv="Content-Type" content="text/html; charset=%s" />', $charset);
    }

    /**
     * Makes a doctype tag.
     *
     * @access public
     * @param string $type Tupe of doctype to be set.
     * @return string Doctype tag.
     */
    public function docType($type = 'xhtml-strict') {
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
    public function img($src, $alt = '', $options = array()) {
        if (!$this->isExternalUrl($src)) {
            $src = \p12t\core\App::get('sys.route.base') . '/img/' . $src;
        }
        return '<img src="' . $src . '" alt="' . $alt . '"' . $this->buildOptionsString($options) . ' />';
    }

    /**
     * Wrapper for img method.
     *
     * @access public
     * @see Html::img()
     */
    public function image($src, $alt = '', $options = array()) {
        $this->img($src, $alt, $options);
    }

    /**
     * Wrapper for a method.
     *
     * @access public
     * @see Html::a()
     */
    public function link($title, $url, $options = array()) {
        $this->a($title, $url, $options);
    }

}
?>
