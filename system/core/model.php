<?php

namespace p12t\core;

/**
 * p12t PHP Framework : /system/core/model.php
 *
 * @package p12t
 * @author hepper
 * @copyright Copyright (c) 2010, Henrik Persson, Pay if you like it
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Base model class.
 *
 * Common methods used in all models.
 *
 * @since 0.1.0
 * @access public
 * @todo zip validation when language developed
 * @todo phone validation when language developed
 * @todo date validation
 * @todo time validation
 * @todo dateTime validation
 * @todo ip validation
 * @todo social security number validation when language developed
 */
class Model extends Object {

    /**
     * Holds validation data
     *
     * @access public
     * @var array
     */
    public $validation = array();

    /**
     * Holdes validation errors
     *
     * @var array
     */
    public $validationErrors = array();

    public $data;

    public function __construct(&$controller) {
        parent::__construct();
        $this->validationErrors =& $controller->validationErrors;
        $this->data =& $controller->data;
    }

    public function validate() {
        foreach ($this->validation as $field => $rules) {
            foreach ($rules as $rule => $options) {
                $this->$rule($field, $options);
            }
        }
        return (count($this->validationErrors) > 0) ? false : true;
    }

    private function setValidationError($field, $msg) {
        $this->validationErrors[$field][] = $msg;
    }
    
    // -----------------------------------------
    // Below is the diffrent validation methods.
    // -----------------------------------------

    private function alphaNumeric($field, $options) {
        $arrField = explode('.', $field);
        $data = (isset($this->data[$arrField[0]][$arrField[1]][$arrField[2]])) ? $this->data[$arrField[0]][$arrField[1]][$arrField[2]] : '';
        if (!preg_match('/^[\p{Ll}\p{Lm}\p{Lo}\p{Lt}\p{Lu}\p{Nd}]+$/mu', $data)) {
            $this->setValidationError($field, $options[0]);
        }
    }

    private function alike($field, $options) {
        $arrField = explode('.', $field);
        $arrField2 = explode('.', $options[0]);
        $data = (isset($this->data[$arrField[0]][$arrField[1]][$arrField[2]])) ? $this->data[$arrField[0]][$arrField[1]][$arrField[2]] : '';
        $data2 = (isset($this->data[$arrField2[0]][$arrField2[1]][$arrField2[2]])) ? $this->data[$arrField2[0]][$arrField2[1]][$arrField2[2]] : '';
        if ($data != $data2) $this->setValidationError($field, $options[1]);
    }

    function boolean($field, $options) {
        $arrField = explode('.', $field);
        $data = (isset($this->data[$arrField[0]][$arrField[1]][$arrField[2]])) ? $this->data[$arrField[0]][$arrField[1]][$arrField[2]] : '';
        $values = array(0, 1, '0', '1', true, false, 'true', 'false');
        if (!in_array($data, $values, true)) $this->setValidationError($field, $options[0]);
    }
    
    private function email($field, $options) {
        $arrField = explode('.', $field);
        $email = (isset($this->data[$arrField[0]][$arrField[1]][$arrField[2]])) ? $this->data[$arrField[0]][$arrField[1]][$arrField[2]] : '';
        $isValid = true;
        $atIndex = strrpos($email, "@");
        if (is_bool($atIndex) && !$atIndex) {
            $isValid = false;
        } else {
            $domain = substr($email, $atIndex+1);
            $local = substr($email, 0, $atIndex);
            $localLen = strlen($local);
            $domainLen = strlen($domain);
            if ($localLen < 1 || $localLen > 64) {
                // local part length exceeded
                $isValid = false;
            } else if ($domainLen < 1 || $domainLen > 255) {
                // domain part length exceeded
                $isValid = false;
            } else if ($local[0] == '.' || $local[$localLen-1] == '.') {
                // local part starts or ends with '.'
                $isValid = false;
            } else if (preg_match('/\\.\\./', $local)) {
                // local part has two consecutive dots
                $isValid = false;
            } else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) {
                // character not valid in domain part
                $isValid = false;
            } else if (preg_match('/\\.\\./', $domain)) {
                // domain part has two consecutive dots
                $isValid = false;
            } else if (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local))) {
                // character not valid in local part unless
                // local part is quoted
                if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\","",$local))) {
                    $isValid = false;
                }
            }
            if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A"))) {
                // domain not found in DNS
                $isValid = false;
            }
        }
        if (!$isValid) $this->setValidationError($field, $options[0]);
    }
    
    private function inList($field, $options) {
        $arrField = explode('.', $field);
        $data = (isset($this->data[$arrField[0]][$arrField[1]][$arrField[2]])) ? $this->data[$arrField[0]][$arrField[1]][$arrField[2]] : array();
        $data = (is_array($data)) ? array_filter($data) : $data;
        if(is_array($data)) {
            foreach ($data as $value) {
                if (!in_array($value, $options[0])) {
                    $this->setValidationError($field, $options[1]);
                    return;
                }
            }
        } else {
            if (!in_array($data, $options[0])) {
                $this->setValidationError($field, $options[1]);
            }
        }
        
    }

    private function integer($field, $options) {
        $arrField = explode('.', $field);
        $data = (isset($this->data[$arrField[0]][$arrField[1]][$arrField[2]])) ? $this->data[$arrField[0]][$arrField[1]][$arrField[2]] : 0;
        $data = ($data === '') ? 0 : $data;
        $IntValue = intval($data);
        $StrValue = strval($IntValue);
        if($StrValue != $data) {
            $this->setValidationError($field, $options[0]);
        }
    }

    private function lenght($field, $options) {
        $arrField = explode('.', $field);
        $data = (isset($this->data[$arrField[0]][$arrField[1]][$arrField[2]])) ? $this->data[$arrField[0]][$arrField[1]][$arrField[2]] : null;
        if (is_null($options[1])) {
            if (strlen($data) < $options[0]) {
                $this->setValidationError($field, $options[2]);
            }
        } else {
            if (strlen($data) < $options[0] OR strlen($data) > $options[1]) {
                $this->setValidationError($field, $options[2]);
            }
        }
    }

    private function multiple($field, $options) {
        $arrField = explode('.', $field);
        $data = (isset($this->data[$arrField[0]][$arrField[1]][$arrField[2]])) ? array_filter($this->data[$arrField[0]][$arrField[1]][$arrField[2]]) : null;
        if(isset($data)) {
            $numberSelected = count($data);
            if ($numberSelected < $options[0]) {
                $this->setValidationError($field, $options[2]);
                return;
            }
            if ($numberSelected > $options[1] AND $options[1] <> 0) {
                $this->setValidationError($field, $options[2]);
                return;
            }
        } else {
            if ($options[0] > 0) {
                $this->setValidationError($field, $options[2]);
            }
        }
    }
    
    private function notEmpty($field, $options) {
        $arrField = explode('.', $field);
        $data = (isset($this->data[$arrField[0]][$arrField[1]][$arrField[2]])) ? $this->data[$arrField[0]][$arrField[1]][$arrField[2]] : null;
        if ($data == '') {
            $this->setValidationError($field, $options[0]);
        }
    }

    private function numeric($field, $options) {
        $arrField = explode('.', $field);
        $data = (isset($this->data[$arrField[0]][$arrField[1]][$arrField[2]])) ? $this->data[$arrField[0]][$arrField[1]][$arrField[2]] : null;
        if (!is_numeric($data)) {
            $this->setValidationError($field, $options[0]);
        }
    }

    private function range($field, $options) {
        $arrField = explode('.', $field);
        $data = (isset($this->data[$arrField[0]][$arrField[1]][$arrField[2]])) ? $this->data[$arrField[0]][$arrField[1]][$arrField[2]] : null;
        if (!is_numeric($data)) {
            $this->setValidationError($field, $options[2]);
        } elseif (is_null($options[1])) {
            if ($data < $options[0]) $this->setValidationError($field, $options[2]);
        } elseif (is_null($options[0])) {
            if ($data > $options[1]) $this->setValidationError($field, $options[2]);
        } else {
            if ($data < $options[0] OR $data > $options[1]) {
                $this->setValidationError($field, $options[2]);
            }
        }
    }

    private function regex($field, $options) {
        $arrField = explode('.', $field);
        $data = (isset($this->data[$arrField[0]][$arrField[1]][$arrField[2]])) ? $this->data[$arrField[0]][$arrField[1]][$arrField[2]] : null;
        if (!preg_match($options[0], $data)) {
            $this->setValidationError($field, $options[1]);
        }
    }

    private function url($field, $options) {
        $arrField = explode('.', $field);
        $data = (isset($this->data[$arrField[0]][$arrField[1]][$arrField[2]])) ? $this->data[$arrField[0]][$arrField[1]][$arrField[2]] : '';
        switch ($options[0]) {
            case 'all':
                $protocol = 'https?|ftps?|file|news|gopher';
                break;
            case 'http':
                $protocol = 'https?';
                break;
            case 'ftp':
                $protocol = 'ftps?';
                break;
            case 'file':
                $protocol = 'file';
                break;
            case 'news':
                $protocol = 'news';
                break;
            case 'gopher':
                $protocol = 'gopher';
                break;
        }
        $valid = '([' . preg_quote('!"$&\'()*+,-.@_:;=~') . '\/0-9a-z]|(%[0-9a-f]{2}))';
        $ip = '(?:(?:25[0-5]|2[0-4][0-9]|(?:(?:1[0-9])?|[1-9]?)[0-9])\.){3}(?:25[0-5]|2[0-4][0-9]|(?:(?:1[0-9])?|[1-9]?)[0-9])';
        $ip6 = '((([0-9A-Fa-f]{1,4}:){7}(([0-9A-Fa-f]{1,4})|:))|(([0-9A-Fa-f]{1,4}:){6}(:|((25[0-5]|2[0-4]\d|[01]?\d{1,2})(\.(25[0-5]|2[0-4]\d|[01]?\d{1,2})){3})|(:[0-9A-Fa-f]{1,4})))|(([0-9A-Fa-f]{1,4}:){5}((:((25[0-5]|2[0-4]\d|[01]?\d{1,2})(\.(25[0-5]|2[0-4]\d|[01]?\d{1,2})){3})?)|((:[0-9A-Fa-f]{1,4}){1,2})))|(([0-9A-Fa-f]{1,4}:){4}(:[0-9A-Fa-f]{1,4}){0,1}((:((25[0-5]|2[0-4]\d|[01]?\d{1,2})(\.(25[0-5]|2[0-4]\d|[01]?\d{1,2})){3})?)|((:[0-9A-Fa-f]{1,4}){1,2})))|(([0-9A-Fa-f]{1,4}:){3}(:[0-9A-Fa-f]{1,4}){0,2}((:((25[0-5]|2[0-4]\d|[01]?\d{1,2})(\.(25[0-5]|2[0-4]\d|[01]?\d{1,2})){3})?)|((:[0-9A-Fa-f]{1,4}){1,2})))|(([0-9A-Fa-f]{1,4}:){2}(:[0-9A-Fa-f]{1,4}){0,3}((:((25[0-5]|2[0-4]\d|[01]?\d{1,2})(\.(25[0-5]|2[0-4]\d|[01]?\d{1,2})){3})?)|((:[0-9A-Fa-f]{1,4}){1,2})))|(([0-9A-Fa-f]{1,4}:)(:[0-9A-Fa-f]{1,4}){0,4}((:((25[0-5]|2[0-4]\d|[01]?\d{1,2})(\.(25[0-5]|2[0-4]\d|[01]?\d{1,2})){3})?)|((:[0-9A-Fa-f]{1,4}){1,2})))|(:(:[0-9A-Fa-f]{1,4}){0,5}((:((25[0-5]|2[0-4]\d|[01]?\d{1,2})(\.(25[0-5]|2[0-4]\d|[01]?\d{1,2})){3})?)|((:[0-9A-Fa-f]{1,4}){1,2})))|(((25[0-5]|2[0-4]\d|[01]?\d{1,2})(\.(25[0-5]|2[0-4]\d|[01]?\d{1,2})){3})))(%.+)?';
        $host = '(?:[a-z0-9][-a-z0-9]*\.)*(?:[a-z0-9][-a-z0-9]{0,62})\.(?:(?:[a-z]{2}\.)?[a-z]{2,4}|museum|travel)';
        $regex = '/^(?:(?:'. $protocol .'):\/\/)' . (!empty($options[1]) ? '' : '?') .
            '(?:' . $ip . '|\[' . $ip6 . '\]|' . $host . ')' .
            '(?::[1-9][0-9]{0,4})?' .
            '(?:\/?|\/' . $valid . '*)?' .
            '(?:\?' . $valid . '*)?' .
            '(?:#' . $valid . '*)?$/i';
        if (!preg_match($regex, $data)) {
            $this->setValidationError($field, $options[2]);
        }
    }
}