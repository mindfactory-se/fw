<?php

namespace p12t\helpers;

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
class Form extends \p12t\core\Vhelper {

    /**
     * Creates a input tag type button.
     *
     * @param string $value
     * @param array $options
     * @return type
     */
    public function button($value, $options = array()) {
        return $this->formatButton($value, 'button', $options);
    }

    /**
     * Creates a input tag type checkbox.
     *
     * @param string $name
     * @param string|int $value
     * @param array $options
     * @return string
     */
    public function checkbox($name, $data, $options = array()) {
        $name = explode('.', $name);
        $count = 0;
        $buffer = '';
        foreach ($data as $key => $value) {
            $checked = '';
            if (isset($this->controller->data[$name[0]][$name[1]][$name[2]][$count])) {
               $checked = ($this->controller->data[$name[0]][$name[1]][$name[2]][$count] == $value) ? 'checked="true"' : '';
            }
            $buffer .= sprintf('<input type="hidden" name="data[%s][%s][%s][%d]" value="0" %s />', $name[0], $name[1], $name[2], $count, $this->buildOptionsString($options));
            $buffer .= "\n";
            $buffer .= sprintf('<input type="checkbox" name="data[%s][%s][%s][%d]" value="%s"%s%s /> %s<br />', $name[0], $name[1], $name[2], $count, $value, $checked, $this->buildOptionsString($options), $key);
            $buffer .= "\n";
            $count ++;
        }
        /*$checked = '';
        if (isset($this->controller->data[$name[0]][$name[1]][$name[2]])) {
            foreach ($this->controller->data[$name[0]][$name[1]][$name[2]] as $item) {
                $checked = ($item == $value) ? 'checked="true"' : '';
            }
        }
        $buffer .= sprintf('<input type="hidden" name="data[%s][%s][%s][]" %s />', $name[0], $name[1], $name[2], $this->buildOptionsString($options));
        $buffer .= sprintf('<input type="checkbox" name="data[%s][%s][%s][]" value="%s"%s%s />', $name[0], $name[1], $name[2], $value, $checked, $this->buildOptionsString($options));
        */return $buffer;
    }
    
    /**
     * Creats a Form tag
     *
     * @param String $action The action.
     * @param array $options Options as name, value pairs.
     * @return string Form tag.
     */
    public function create($action = NULL, $options = array()) {
        if (!$action) $action = App::get ('sys.route.visible');
        return sprintf('<form action="/%s" method="POST"%s>', $action, $this->buildOptionsString($options));
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
        return $this->formatInput($name, 'file', $options);
    }

    /**
     * Creates a input tag type button, submit or reset.
     * @param <type> $value
     * @param <type> $type
     * @param <type> $options
     * @return <type>
     */
    private function formatButton($value, $type, $options) {
        return sprintf('<input type="%s" value="%s"%s />', $type, $value, $this->buildOptionsString($options));
    }

    /**
     * Creates a input tag type text,password, hidden or file.
     * @param string $name
     * @param string $type
     * @param array $options
     * @return string
     */
    private function formatInput($name, $type, $options) {
        $name = explode('.', $name);
        $options['value'] = (isset($options['value'])) ? $options['value'] : '';
        $options['value'] = (isset($this->controller->data[$name[0]][$name[1]][$name[2]])) ? $this->controller->data[$name[0]][$name[1]][$name[2]] : $options['value'];
        return sprintf('<input type="%s" name="data[%s][%s][%s]"%s />', $type, $name[0], $name[1], $name[2], $this->buildOptionsString($options));
    }

    /**
     * Creates a input tag type hidden.
     *
     * @param string $name
     * @param array $options
     * @return string
     */
    public function hidden($name, $value, $options = array()) {
      $name = explode('.', $name);
        return sprintf('<input type="hidden" value="%s" name="data[%s][%s][%s]"%s />', $value, $name[0], $name[1], $name[2], $this->buildOptionsString($options));
    }

    /**
     * Creates a input tag type image.
     *
     * @param string $src
     * @param array $options
     * @return string
     */
    public function image($src, $options = array()){
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
    public function password($name, $options = array()) {
        return $this->formatInput($name, 'password', $options);
    }

    /**
     * Creates a input tag type radio.
     *
     * @param string $name
     * @param string|int $value
     * @param array $options
     * @return string
     */
    public function radio($name, $value, $options = array()) {
        $name = explode('.', $name);
        $checked = '';
        if (isset($this->controller->data[$name[0]][$name[1]][$name[2]])) {
            $checked = ($this->controller->data[$name[0]][$name[1]][$name[2]] == $value) ? 'checked="true"' : '';
        }
        return sprintf('<input type="radio" name="data[%s][%s][%s]" value="%s"%s%s />', $name[0], $name[1], $name[2], $value, $checked, $this->buildOptionsString($options));
    }

    /**
     * Creates a input tag type resetbutton.
     *
     * @param string $value
     * @param array $options
     * @return string
     */
    public function reset($value, $options = array()) {
        return $this->formatButton($value, 'reset', $options);
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
    public function select($name, $data, $multiple = false, $options = array()) {
        $name = explode('.', $name);
        $multipleExtra = '';
        if ($multiple) {
            $multiple = ' multiple';
            $multipleExtra = '[]';
        }
        $buffer = '';
        $buffer .= sprintf('<select name="data[%s][%s][%s]%s"%s%s>' , $name[0], $name[1], $name[2], $multipleExtra, $multiple, $this->buildOptionsString($options));
        $buffer .= "\n";
        foreach ($data as $key => $value) {
            $selected = '';
            if ($multiple) {
                if (isset($this->controller->data[$name[0]][$name[1]][$name[2]])) {
                    foreach ($this->controller->data[$name[0]][$name[1]][$name[2]] as $item) {
                         if ($item == $value) {
                             $selected = ' selected="true"';
                             break;
                         }
                    }
                }
            } else {
                if (isset($this->controller->data[$name[0]][$name[1]][$name[2]])) {
                    $selected = ($this->controller->data[$name[0]][$name[1]][$name[2]] == $value) ? ' selected="true"' : '';
                }
            }
            $buffer .= sprintf('<option value="%s"%s>%s</option>', $value, $selected, $key);
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
    public function submit($value, $options = array()) {
        return $this->formatButton($value, 'submit', $options);
    }

    /**
     * Creates a input tag type text.
     * @param string $name
     * @param array $options
     * @return string
     */
    public function text($name, $options = array()) {
        return $this->formatInput($name, 'text', $options);
    }

    /**
     *  Creates a textarea tag.
     *
     * @param string $name
     * @param string $content
     * @param array $options
     * @return string
     */
    public function textarea($name, $content = '', $options = array()) {
        $name = explode('.', $name);
        $content = (isset($this->controller->data[$name[0]][$name[1]][$name[2]])) ? $this->controller->data[$name[0]][$name[1]][$name[2]] : $content;
        $buffer = '';
        $buffer .= sprintf('<textarea name="data[%s][%s][%s]"%s>' , $name[0], $name[1], $name[2], $this->buildOptionsString($options));
        $buffer .= $content;
        $buffer .= "</textarea>";
        return $buffer;
    }
}
