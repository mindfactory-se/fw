<?php

/**
 * p12t PHP Framework : /system/helpers/view/form.php
 *
 * @package p12t
 * @author hepper
 * @copyright Copyright (c) 2010, Henrik Persson, Pay if you like it
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Form viewhelper
 *
 * Diffrent methods used to output HTMLforms in the views.
 *
 * @since 0.2.0
 * @access public
 */
class Form extends Helper {

    /**
     * Load dependent helpers
     *
     * @access public
     */
    public function  __construct() {
        parent::__construct();
        App::loadHelper('Html');
    }

    /**
     * Creates a input tag type button.
     *
     * @param string $value
     * @param array $options
     * @return type
     */
    public static function button($value, $options = array()) {
        return Form::formatButton($value, 'button', $options);
    }

    /**
     * Creates a input tag type checkbox.
     *
     * @param string $name
     * @param string|int $value
     * @param array $options
     * @return string
     */
    public static function checkbox($name, $value, $options = array()) {
        $name = explode('.', $name);
        return sprintf('<input type="checkbox" name="data[%s][%s][%s][]" value="%s"%s />', $name[0], $name[1], $name[2], $value, Form::buildOptionsString($options));
    }
    
    /**
     * Creats a Form tag
     *
     * @param String $action The action.
     * @param array $options Options as name, value pairs.
     * @return string Form tag.
     */
    public static function create($action = NULL, $options = array()) {
        if (!$action) $action = App::get ('sys.route.visible');
        return sprintf('<form action="/%s" method="POST"%s>', $action, Form::buildOptionsString($options));
    }

    /**
     * Creates a form end tag.
     * @return string.
     */
    public static function end() {
        return '</form>';
    }

    /**
     * Crates an input tag.
     *
     * @param string $name In format 'app.controller.field'.
     * @param string $type Type og inputfield.
     * @param array $options Options as name, value pairs.
     * @return string Input tag.
     */

    /**
     * Creates a input tag type file.
     *
     * @param string $name
     * @param array $options
     * @return string
     */
    public static function file($name, $options = array()) {
        return Form::formatInput($name, 'file', $options);
    }

    /**
     * Creates a input tag type button, submit or reset.
     * @param <type> $value
     * @param <type> $type
     * @param <type> $options
     * @return <type>
     */
    private static function formatButton($value, $type, $options) {
        return sprintf('<input type="%s" value="%s"%s />', $type, $value, Form::buildOptionsString($options));
    }

    /**
     * Creates a input tag type text,password, hidden or file.
     * @param string $name
     * @param string $type
     * @param array $options
     * @return string
     */
    private static function formatInput($name, $type, $options) {
        $name = explode('.', $name);
        return sprintf('<input type="%s" name="data[%s][%s][%s]"%s />', $type, $name[0], $name[1], $name[2], Form::buildOptionsString($options));
    }

    /**
     * Creates a input tag type hidden.
     *
     * @param string $name
     * @param array $options
     * @return string
     */
    public static function hidden($name, $options = array()) {
        return Form::formatInput($name, 'hidden', $options);
    }

    /**
     * Creates a input tag type image.
     *
     * @param string $src
     * @param array $options
     * @return string
     */
    public static function image($src, $options = array()){
        if (!Html::isExternalUrl($src)) {
            $name[0] = App::get('sys.route.base') . '/img/' . $src;
        }
                return sprintf('<input type="image" src="%s" />', $src);
    }

    /**
     * Creates a input tag type password.
     *
     * @param string $name
     * @param array $options
     * @return string
     */
    public static function password($name, $options = array()) {
        return Form::formatInput($name, 'password', $options);
    }

    /**
     * Creates a input tag type radio.
     *
     * @param string $name
     * @param string|int $value
     * @param array $options
     * @return string
     */
    public static function radio($name, $value, $options = array()) {
        $name = explode('.', $name);
        return sprintf('<input type="radio" name="data[%s][%s][%s]" value="%s"%s />', $name[0], $name[1], $name[2], $value, Form::buildOptionsString($options));
    }

    /**
     * Creates a input tag type resetbutton.
     *
     * @param string $value
     * @param array $options
     * @return string
     */
    public static function reset($value, $options = array()) {
        return Form::formatButton($value, 'reset', $options);
    }

    /**
     *  Creates a select tag.
     *
     * @param string $name
     * @param array $data
     * @param bool $multiple
     * @param array $options
     * @return string
     */
    public static function select($name, $data, $multiple = false, $options = array()) {
        $name = explode('.', $name);
        $multipleExtra = '';
        if ($multiple) {
            $multiple = ' multiple';
            $multipleExtra = '[]';
        }
        $buffer = '';
        $buffer .= sprintf('<select name="data[%s][%s][%s]%s"%s%s>' , $name[0], $name[1], $name[2], $multipleExtra, $multiple, Form::buildOptionsString($options));
        $buffer .= "\n";
        foreach ($data as $key => $value) {
            $buffer .= sprintf('<option value="%s">%s</option>', $value, $key);
            $buffer .= "\n";
        }
        $buffer .= "</select>";
        return $buffer;
    }

    /**
     * Creates a input tag type submitbutton.
     *
     * @param string $value
     * @param array $options
     * @return string
     */
    public static function submit($value, $options = array()) {
        return Form::formatButton($value, 'submit', $options);
    }

    /**
     * Creates a input tag type text.
     * @param string $name
     * @param array $options
     * @return string
     */
    public static function text($name, $options = array()) {
        return Form::formatInput($name, 'text', $options);
    }

    /**
     *  Creates a textarea tag.
     *
     * @param string $name
     * @param string $content
     * @param array $options
     * @return string
     */
    public static function textarea($name, $content = '', $options = array()) {
        $name = explode('.', $name);
        $buffer = '';
        $buffer .= sprintf('<textarea name="data[%s][%s][%s]"%s>' , $name[0], $name[1], $name[2], Form::buildOptionsString($options));
        $buffer .= $content;
        $buffer .= "</textarea>";
        return $buffer;
    }
}
