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
 * @todo date validation
 * @todo time validation
 * @todo dateTime validation
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
     * @access public
     * @var array
     * @since 0.2.0
     */
    public $validationErrors = array();

    /**
     *  Holdes refrens to controller::data
     *
     * @access public
     * @var array
     * @since 0.2.0
     */
    public $data;

    /**
     * Gives access to controller::data and controller::validationsErrors
     *
     * @access public
     * @param object Controllerobhect
     * @since 0.2.0
     */
    public function __construct(&$controller) {
        parent::__construct();
        $this->validationErrors =& $controller->validationErrors;
        $this->data =& $controller->data;
    }

    /**
     * Validates the given data.
     *
     * @access public
     * @return bool True if data validates.
     * @since 0.2.0
     */
    public function validate() {
        foreach ($this->validation as $field => $rules) {
            foreach ($rules as $rule => $options) {
                $this->$rule($field, $options);
            }
        }
        return (count($this->validationErrors) > 0) ? false : true;
    }

    /**
     * Sets a validation error message sortet by field.
     *
     * @access public
     * @param string $field Field that contains an error.
     * @param string $msg Error message.
     * @since 0.2.0
     */
    private function setValidationError($field, $msg) {
        $this->validationErrors[$field][] = $msg;
    }
    
    // -----------------------------------------
    // Below is the diffrent validation methods.
    // -----------------------------------------

    /**
     * Validates an alphanumeric field.
     *
     * Checks if a field contains numbers and letters.
     *
     * @access private
     * @param string $field Name of field to validate.
     * @param array $options ('Error message').
     * @since 0.2.0
     */
    private function alphaNumeric($field, $options) {
        $arrField = explode('.', $field);
        $data = (isset($this->data[$arrField[0]][$arrField[1]][$arrField[2]])) ? $this->data[$arrField[0]][$arrField[1]][$arrField[2]] : '';
        $localChars = \p12t\core\Locale::get('p12t.chars');
        $regex = '/^[\p{L}\p{Nd}'. $localChars .']+$/mu';
        if (!preg_match($regex, $data)) {
            $this->setValidationError($field, $options[0]);
        }
    }

    /**
     * Validates an alphanumeric field.
     *
     * Checks if two fields contains the same value.
     *
     * @access private
     * @param string $field Name of field to validate.
     * @param array $options ('Fieldname 2', 'Error message').
     * @since 0.2.0
     */
    private function alike($field, $options) {
        $arrField = explode('.', $field);
        $arrField2 = explode('.', $options[0]);
        $data = (isset($this->data[$arrField[0]][$arrField[1]][$arrField[2]])) ? $this->data[$arrField[0]][$arrField[1]][$arrField[2]] : '';
        $data2 = (isset($this->data[$arrField2[0]][$arrField2[1]][$arrField2[2]])) ? $this->data[$arrField2[0]][$arrField2[1]][$arrField2[2]] : '';
        if ($data != $data2) $this->setValidationError($field, $options[1]);
    }

    /**
     * Validates an boolean field.
     *
     * Checks if a field contains an boolean value.
     *
     * @access private
     * @param string $field Name of field to validate.
     * @param array $options ('Error message').
     * @since 0.2.0
     */
    function boolean($field, $options) {
        $arrField = explode('.', $field);
        $data = (isset($this->data[$arrField[0]][$arrField[1]][$arrField[2]])) ? $this->data[$arrField[0]][$arrField[1]][$arrField[2]] : '';
        $values = array(0, 1, '0', '1', true, false, 'true', 'false');
        if (!in_array($data, $values, true)) $this->setValidationError($field, $options[0]);
    }

    /**
     * Validates an email field.
     *
     * Checks if a field contains a valid emailadress.
     * Credits to {@link http://www.linuxjournal.com/article/9585}
     *
     * @access private
     * @param string $field Name of field to validate.
     * @param array $options ('Error message').
     * @since 0.2.0
     */
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

    /**
     * Validates if field values are in list.
     *
     * Usde primary in multiple fields or radiobuttons or other data that you
     * wan't the user submitted data to be a certain value.
     *
     * @access private
     * @param string $field Name of field to validate.
     * @param array $options ('array of allowed values', 'Error message').
     * @since 0.2.0
     */
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

    /**
     * Validates an integer field.
     *
     * Checks if a field contains an integer value.
     * Credits to {@link http://www.techbytes.ca/techbyte19.html}
     *
     * @access private
     * @param string $field Name of field to validate.
     * @param array $options ('Error message').
     * @since 0.2.0
     */
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

    /**
     * Validates an ip field.
     *
     * Checks if a field contains an valid IPv4 or IPv6 adress.
     *
     * @access private
     * @param string $field Name of field to validate.
     * @param array $options ('Error message').
     * @since 0.3.0
     */
    private function ip($field, $options) {
        $arrField = explode('.', $field);
        $data = (isset($this->data[$arrField[0]][$arrField[1]][$arrField[2]])) ? $this->data[$arrField[0]][$arrField[1]][$arrField[2]] : '';
        if (!filter_var($data, FILTER_VALIDATE_IP, array('flags' => FILTER_FLAG_IPV4)) && !filter_var($data, FILTER_VALIDATE_IP, array('flags' => FILTER_FLAG_IPV6))) {
            $this->setValidationError($field, $options[0]);
        }
    }

    /**
     * Validates an IPv4 field.
     *
     * Checks if a field contains an valid IPv4 adress.
     *
     * @access private
     * @param string $field Name of field to validate.
     * @param array $options ('Error message').
     * @since 0.3.0
     */
    private function ip4($field, $options) {
        $arrField = explode('.', $field);
        $data = (isset($this->data[$arrField[0]][$arrField[1]][$arrField[2]])) ? $this->data[$arrField[0]][$arrField[1]][$arrField[2]] : '';
        if (!filter_var($data, FILTER_VALIDATE_IP, array('flags' => FILTER_FLAG_IPV4))) {
            $this->setValidationError($field, $options[0]);
        }
    }

    /**
     * Validates an IPv6 field.
     *
     * Checks if a field contains an valid or IPv6 adress.
     *
     * @access private
     * @param string $field Name of field to validate.
     * @param array $options ('Error message').
     * @since 0.3.0
     */
    private function ip6($field, $options) {
        $arrField = explode('.', $field);
        $data = (isset($this->data[$arrField[0]][$arrField[1]][$arrField[2]])) ? $this->data[$arrField[0]][$arrField[1]][$arrField[2]] : '';
        if (!filter_var($data, FILTER_VALIDATE_IP, array('flags' => FILTER_FLAG_IPV6))) {
            $this->setValidationError($field, $options[0]);
        }
    }

    /**
     * Validates the lenght of the field.
     *
     * Checks if a field contains the right lenght.
     * If max is null the max lenght isen't checked.
     *
     * @access private
     * @param string $field Name of field to validate.
     * @param array $options ('Min lenght', 'Max lenght', 'Error message').
     * @since 0.2.0
     */
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

    /**
     * Validates an multipple field.
     *
     * Checks if the right number of optionse are selected.
     * If max is 0 then max isen't checked.
     *
     * @access private
     * @param string $field Name of field to validate.
     * @param array $options ('Min', 'Max', 'Error message').
     * @since 0.2.0
     * @todo Change max to use null insted of 0
     */
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

    /**
     * Checks if a field contains value.
     *
     * @access private
     * @param string $field Name of field to validate.
     * @param array $options ('Error message').
     * @since 0.2.0
     */
    private function notEmpty($field, $options) {
        $arrField = explode('.', $field);
        $data = (isset($this->data[$arrField[0]][$arrField[1]][$arrField[2]])) ? $this->data[$arrField[0]][$arrField[1]][$arrField[2]] : null;
        if ($data == '') {
            $this->setValidationError($field, $options[0]);
        }
    }

    /**
     * Validates an numeric field.
     *
     * Checks if a field contains a numric value.
     *
     * @access private
     * @param string $field Name of field to validate.
     * @param array $options ('Error message').
     * @since 0.2.0
     */
    private function numeric($field, $options) {
        $arrField = explode('.', $field);
        $data = (isset($this->data[$arrField[0]][$arrField[1]][$arrField[2]])) ? $this->data[$arrField[0]][$arrField[1]][$arrField[2]] : null;
        if (!is_numeric($data)) {
            $this->setValidationError($field, $options[0]);
        }
    }

    /**
     * Validates an zip code field.
     *
     * Checks if a field contains an valid zip code.
     *
     * @access private
     * @param string $field Name of field to validate.
     * @param array $options ('Error message').
     * @since 0.3.0
     */
    private function phone($field, $options) {
        $arrField = explode('.', $field);
        $data = (isset($this->data[$arrField[0]][$arrField[1]][$arrField[2]])) ? $this->data[$arrField[0]][$arrField[1]][$arrField[2]] : '';
        $regex = \p12t\core\Locale::get('p12t.phone');
        if (!preg_match($regex, $data)) {
            $this->setValidationError($field, $options[0]);
        }
    }

    /**
     * Validates an numric fields range.
     *
     * Checks if a numric field is between two values.
     * If min or max is null the value isen't cheked.
     *
     * @access private
     * @param string $field Name of field to validate.
     * @param array $options ('Min', 'Max', 'Error message').
     * @since 0.2.0
     */
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

    /**
     * Validates an field by submitted regex.
     *
     * A method to make an own validation.
     *
     * @access private
     * @param string $field Name of field to validate.
     * @param array $options ('Reg ex', 'Error message').
     * @since 0.2.0
     */
    private function regex($field, $options) {
        $arrField = explode('.', $field);
        $data = (isset($this->data[$arrField[0]][$arrField[1]][$arrField[2]])) ? $this->data[$arrField[0]][$arrField[1]][$arrField[2]] : null;
        if (!preg_match($options[0], $data)) {
            $this->setValidationError($field, $options[1]);
        }
    }

    /**
     * Validates an social security number field.
     *
     * Checks if a field contains an valid social security number.
     *
     * @access private
     * @param string $field Name of field to validate.
     * @param array $options ('Error message').
     * @since 0.3.0
     */
    private function ssn($field, $options) {
        $arrField = explode('.', $field);
        $data = (isset($this->data[$arrField[0]][$arrField[1]][$arrField[2]])) ? $this->data[$arrField[0]][$arrField[1]][$arrField[2]] : '';
        $regex = \p12t\core\Locale::get('p12t.ssn');
        if (!preg_match($regex, $data)) {
            $this->setValidationError($field, $options[0]);
        }
    }

    /**
     * Validates an string field.
     *
     * Checks if a field contains numbers and letters.
     *
     * @access private
     * @param string $field Name of field to validate.
     * @param array $options ('Error message').
     * @since 0.3.0
     */
    private function string($field, $options) {
        $arrField = explode('.', $field);
        $data = (isset($this->data[$arrField[0]][$arrField[1]][$arrField[2]])) ? $this->data[$arrField[0]][$arrField[1]][$arrField[2]] : null;
        $localChars = \p12t\core\Locale::get('p12t.chars');
        $regex = '/^[\p{L}'. $localChars .']+$/mu';
        if (!preg_match($regex, $data)) {
            $this->setValidationError($field, $options[0]);
        }
    }
    
    /**
     * Validates an url field.
     *
     * Checks if a field contains an valid url.
     *
     * @access private
     * @param string $field Name of field to validate.
     * @param array $options ('Error message').
     * @since 0.2.0
     * @todo Make it possible to choose more then one protocoll.
     */
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

    /**
     * Validates an zip code field.
     *
     * Checks if a field contains an valid zip code.
     *
     * @access private
     * @param string $field Name of field to validate.
     * @param array $options ('Error message').
     * @since 0.3.0
     */
    private function zip($field, $options) {
        $arrField = explode('.', $field);
        $data = (isset($this->data[$arrField[0]][$arrField[1]][$arrField[2]])) ? $this->data[$arrField[0]][$arrField[1]][$arrField[2]] : '';
        $regex = \p12t\core\Locale::get('p12t.zip');
        if (!preg_match($regex, $data)) {
            $this->setValidationError($field, $options[0]);
        }
    }
}