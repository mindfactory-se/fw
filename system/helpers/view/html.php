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
 * Description of html
 *
 * @author hepper
 */
class Html extends ViewHelper {

    public function a($href, $title, $options = array()) {
        if (!Html::isExternalUrl($href)) {
            $url = App::get('route.base') . $href;
        }
        return '<a href="' . $href . '"' . HTML::buildOptionsString($options) . '>' . $title .'</a>';
    }

    public function css($path) {
        if (!Html::isExternalUrl($path)) {
            $path = App::get('route.base') . '/css/' . $path . '.css';
        }
        return sprintf('<link rel="stylesheet" type="text/css" href="%s" />', $path);
    }
    public function charset($charset = 'uft-8') {
        return sprintf('<meta http-equiv="Content-Type" content="text/html; charset=%s" />', $charset);
    }

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

    public function img($src, $alt = '', $options = array()) {
        if (!Html::isExternalUrl($src)) {
            $src = App::get('route.base') . '/img/' . $src;
        }
        return '<img src="' . $src . '" alt="' . $alt . '"' . HTML::buildOptionsString($options) . ' />';
    }

    public function image($src, $alt = '', $options = array()) {
        Html::img($src, $alt, $options);
    }

    public function link($title, $url, $options = array()) {
        html::a($title, $url, $options);
    }

    private function buildOptionsString($options) {
        $option = '';
        foreach($options as $key => $field) {
                $option .= ' ' . $key . '="' . $field . '"';
            }
        return $option;
    }

    private function isExternalUrl($url) {
        if (strpos($url, '://') > 0) {
            return true;
        }
    }
}
?>
