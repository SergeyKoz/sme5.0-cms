<?php
/** Class validate input data, compare dates, validate strings etc.
 * @author Sergey Grishko <sgrishko@reaktivate.com>
 * @modified Artem Mikhmel <amikhmel@activemedia.com.ua>
 * @version 1.0
 * @package Framework
 * @subpackage classes.system.web
 * @access public
 */
class Validate
{
    /**
     *  Array to check out form inputs
     * @var    array   $formfield_arr
     **/
    var $formfield_arr = array();
    /**
     *  Array to check
     * @var    array   $fieldval_arr
     **/
    var $fieldval_arr = array();
    /**
     * Array with error fields
     * @var    array   $formerr_arr
     **/
    var $formerr_arr = array();
    /**
     *   Page reference
     * @var    Page    $page
     **/
    var $Page;
    /**   Advisory error section
     *   @var  string   $errors_section
     **/
    var $errors_section;
    /**
     * Constructor
     * @param     PageClass    $page               Page reference
     * @param     array        $initArray          Array with fields rules
     * @param     string       $errors_section     NAme of section to take error messages from
     * @access    public
     */
    function Validate (&$page, $initArray = array(), $errors_section = "")
    {
        $this->Page = $page;
        $this->formfield_arr = $initArray;
        if (strlen($errors_section)) {
            $this->errors_section = $errors_section;
        }
    }
    /**
     * Method clears errors array
     * @access public
     */
    function ResetErrors ()
    {
        $this->formerr_arr = array();
    }
    /**
     * Method wich validate Form
     *
     * @param array $fieldval_arr associative array with form values (example:$_POST)
     * @param array $fileval_arr associative array of posted files (example:$_POST)
     */
    function ValidateForm ($fieldval_arr, $named_length_error = false, $errors_section = "")
    {
    	$this->date_start = array("value" => 0 , "fname" => "");
        $this->date_stop = array("value" => 0 , "fname" => "");
        ;
        if (! strlen($errors_section)) {
            if (strlen($this->errors_section)) {
                $errors_section = $this->errors_section;
            }
        }
        $this->fieldval_arr = $fieldval_arr;
        for ($i = 0; $i < sizeof($this->formfield_arr); $i ++) {
            $this->ValidateField($i, $named_length_error, $errors_section);
            if ($this->formfield_arr[$i]["dtype"] == "password" && $this->formfield_arr[$i]["dublicate"]) { //if password field
                $main_field = $this->formfield_arr[$i];
                $this->formfield_arr[$i]["name"] = $this->formfield_arr[$i]["name"] . "_2";
                $this->ValidateField($i, $named_length_error, $errors_section);
                //compare passwords
                if (! $this->formerr_arr[$main_field["name"]] && ! $this->formerr_arr[$this->formfield_arr[$i]["name"]])
                    $this->ComparePasswords($main_field, $this->formfield_arr[$i], $errors_section);
            }
        }
        if (($this->date_start["value"] !== 0) && ($this->date_stop["value"] !== 0)) {
            if (! $this->compareDates($this->date_start, $this->date_stop)) {
                $this->AddErrorMessage($errors_section, "INVALID_DATE_RANGE", "", array($this->Page->Kernel->Localization->GetItem($errors_section, $this->date_start["fname"]) , $this->Page->Kernel->Localization->GetItem($errors_section, $this->date_stop["fname"])));
                $this->formerr_arr[$this->date_start["fname"]] = 1;
                $this->formerr_arr[$this->date_stop["fname"]] = 1;
            }
        }
    }
    /**
     * Method compare two password fields
     * @param      array           $field1                     main password field
     * @param      array           $field2                     confirm password field
     * @param      string      $errors_section   errors section name
     **/
    function ComparePasswords ($field1, $field2, $errors_section)
    {
        if ($this->fieldval_arr[$field1["name"]] !== $this->fieldval_arr[$field2["name"]]) {
            $this->AddErrorMessage($errors_section, "INVALID_COMPARE", strtoupper($field1["name"]), array($this->Page->Kernel->Localization->GetItem($errors_section, $field1["name"]) , $this->Page->Kernel->Localization->GetItem($errors_section, $field2["name"])));
            $this->formerr_arr[$field1["name"]] = 1;
            $this->formerr_arr[$field2["name"]] = 1;
        }
    }
    /**
     * Method validate one field from $this->formfield_arr and use $this->fieldval_arr,$this->fileval_arr
     *
     * @param int $ i  number o field
     * @access protected
     */
    function ValidateField ($i, $named_length_error, $errors_section = "")
    {
        if (! strlen($errors_section)) {
            $errors_section = $this->Page->ClassName;
        }

        $fname = $this->formfield_arr[$i]["name"];

        $curvalue = $this->fieldval_arr[$fname];
        $ftype = $this->formfield_arr[$i]["dtype"];
        $fnull = $this->formfield_arr[$i]["notnull"];
        $flength = $this->formfield_arr[$i]["length"];
        // ��������� ����,������� ������ ���-�� ���������
        if (($fnull) && (strlen($curvalue) == 0) ) {
            $this->formerr_arr[$fname] ++; // = $fname;
            $this->AddErrorMessage($errors_section, "CANT_BE_EMPTY", $fname, array($this->Page->Kernel->Localization->GetItem($errors_section, $fname)), $named_length_error);
        } elseif (($flength != "") && (strlen($curvalue) > $flength)) {
            $this->formerr_arr[$fname] ++; // = $fname;
            $this->AddErrorMessage($errors_section, "INVALID_LENGTH", $fname, array($this->Page->Kernel->Localization->GetItem($errors_section, $fname) , $flength), $named_length_error);
        } else {
            // ������ ��������� �� ����
            switch ($ftype) {
                case "int":
                    $this->Validate_INT($fname, $curvalue, $this->formerr_arr, $errors_section);
                    break;
                case "float":
                    $this->Validate_FLOAT($fname, $curvalue, $this->formerr_arr, $errors_section);
                    break;
                case "date":
                    $this->fieldval_arr[$fname] = $this->fieldval_arr[$fname . "_year"] . "-" . $this->fieldval_arr[$fname . "_month"] . "-" . $this->fieldval_arr[$fname . "_day"] . " " . $this->fieldval_arr[$fname . "_hour"] . ":" . $this->fieldval_arr[$fname . "_minute"] . ":" . $this->fieldval_arr[$fname . "_sec"];
                    break;
                case "date_start":
                    $this->date_start["value"] = $this->fieldval_arr[$fname];
                    $this->date_start["fname"] = $fname;
                    break;
                case "date_stop":
                    $this->date_stop["value"] = $this->fieldval_arr[$fname];
                    $this->date_stop["fname"] = $fname;
                    break;
                case "email":
                    $this->Validate_EMAIL($fname, $curvalue, $this->formerr_arr, $errors_section);
                    break;
                case "textarea":
                    break;
                case "password":
                    $this->Validate_PASSWORD($fname, $curvalue, $this->formerr_arr, $errors_section);
                    break;
                default:
                    if (! is_array($curvalue))
                        $curvalue = @stripslashes(htmlspecialchars($curvalue));
                    break;
            }
        }
    }
    /**
     * Method validates field by its type, name, null or not, and so on
     * @param      string      $type           Considered Value type
     * @param      string      $name           Field name
     * @param      string      $curvalue       Current field value
     * @param      bool        $allow_null     Allow or not null values
     * @param      bool        $named_length_error  Use named length errors
     * @param      string      $errors_section     Name of section to take error messages from
     * @access public
     */
    function ValidateByType ($type, $name, $curvalue, $allow_null, $named_length_error = false, $errors_section = "")
    {
        if (! strlen($errors_section)) {
            $errors_section = $this->Page->ClassName;
        }
        //echo $name." ".$type." ".$allow_null." .".$curvalue.".<br>";


        if (! $allow_null && (strlen($curvalue) == 0)) {
            //$errors[$name]++;// = $fname;
            $this->formerr_arr[$name] ++;
            $this->AddErrorMessage($errors_section, "CANT_BE_EMPTY", $name, array($this->Page->Kernel->Localization->GetItem($errors_section, $name)), $named_length_error);
        } else {
            $validate_method = "Validate_" . $type;
            if (method_exists($this, $validate_method)) {
                $this->$validate_method($name, $curvalue, $this->formerr_arr, $errors_section);
            }
        }
    }
    /**
     * Method checks validity of considered password value
     * @param    string      $fname                Field name
     * @param    string        $curvalue       Current field value
     * @param    array       $errors           Array with error flags
     * @param    string        $errors_section Name of section to take error messages from
     * @access  public
     **/
    function Validate_PASSWORD ($fname, $curvalue, &$errors, $errors_section = "")
    {
        return ;
        if (! strlen($errors_section)) {
            $errors_section = $this->Page->ClassName;
        }
        if (strlen($curvalue) != 0) {
            preg_match('~[a-zA-Z][a-zA-Z0-9]{5,}~', $curvalue, $exp);
            if (sizeof($exp) == 0) {
                $errors[$fname] ++; // = $fname;
                if ($this->Page->Kernel->Errors->HasItem($errors_section, "INVALID_" . strtoupper($fname))) {
                    $this->Page->AddErrorMessage($errors_section, "INVALID_" . strtoupper($fname));
                } else {
                    //$this->AddErrorMessage($errors_section, "INVALID_PASSWORD", $fname, array($this->Page->Kernel->Localization->GetItem($errors_section, $fname)));
                }
            }
        }
    }
    /**
     * Method checks validity of considered integer value
     * @param     string      $fname      Field name
     * @param     string      $curvalue       Current field value
     * @param     array       $errors         Array with error flags
     * @param      string      $errors_section        Name of section to take error messages from
     * @access    public
     */
    function Validate_INT ($fname, $curvalue, &$errors, $errors_section = "")
    {
        if (! strlen($errors_section)) {
            $errors_section = $this->Page->ClassName;
        }
        if (strspn($curvalue, "+-1234567890") != strlen($curvalue)) {
            $errors[$fname] ++; //$errors[] = $fname;
            if ($this->Page->Kernel->Errors->HasItem($errors_section, "INVALID_" . strtoupper($fname))) {
                $this->Page->AddErrorMessage($errors_section, "INVALID_" . strtoupper($fname));
            } else {
                $this->AddErrorMessage($errors_section, "INVALID_INT", $fname, array($this->Page->Kernel->Localization->GetItem($errors_section, $fname)));
            }
        }
    }
    /**
     * Method checks validity of considered float value
     * @param     string      $fname      Field name
     * @param     string      $curvalue       Current field value
     * @param     array       $errors         Array with error flags
     * @param      string      $errors_section        Name of section to take error messages from
     * @access    public
     */
    function Validate_FLOAT ($fname, $curvalue, &$errors, $errors_section = "")
    {
        if (! strlen($errors_section)) {
            $errors_section = $this->Page->ClassName;
        }
        if (strspn($curvalue, "+-1234567890.") != strlen($curvalue)) {
            $errors[$fname] ++; //$errors[] = $fname;
            if ($this->Page->Kernel->Errors->HasItem($errors_section, "INVALID_" . strtoupper($fname))) {
                $this->Page->AddErrorMessage($errors_section, "INVALID_" . strtoupper($fname));
            } else {
                $this->AddErrorMessage($errors_section, "INVALID_FLOAT", $fname, array($this->Page->Kernel->Localization->GetItem($errors_section, $fname)));
            }
        }
    }
    /**
     * Method checks validity of considered email value
     * @param     string      $fname      Field name
     * @param     string      $curvalue       Current field value
     * @param     array       $errors         Array with error flags
     * @param      string      $errors_section        Name of section to take error messages from
     * @access    public
     */
    function Validate_EMAIL ($fname, $curvalue, &$errors, $errors_section = "")
    {
        if (! strlen($errors_section)) {
            $errors_section = $this->Page->ClassName;
        }
        if (strlen($curvalue) != 0) {
            preg_match('~.+@[0-9a-zA-Z\.\-]+\.[0-9a-zA-Z\.\-]{2,}~', $curvalue, $exp);
            if (sizeof($exp) == 0) {
                $errors[$fname] ++; // = $fname;
                if ($this->Page->Kernel->Errors->HasItem($errors_section, "INVALID_" . strtoupper($fname))) {
                    $this->Page->AddErrorMessage($errors_section, "INVALID_" . strtoupper($fname));
                } else {
                    $this->AddErrorMessage($errors_section, "INVALID_EMAIL", $fname, array($this->Page->Kernel->Localization->GetItem($errors_section, $fname)));
                }
            }
        }
    }
    /**
     * Method compares 2 times
     * @param      mixed   $date1   Date 1
     * @param      mixed   $date2   DAte 2
     * @return     bool   true if date2 >=  date1, false otherwise
     * @access     public
     */
    function compareDates ($date1, $date2)
    {
        if ($date2 >= $date1) {
            return true;
        }
        return false;
    }
    /**
     * Method sets custom error
     * @param     string      $name       Field name
     * @param     string      $error          Error resource-message
     * @param     string      $errors_section     Name of section to take error messages from
     * @access    public
     */
    function SetCustomError ($name, $error, $errors_section = "")
    {
        if (! strlen($errors_section)) {
            $errors_section = $this->Page->ClassName;
        }
        if (is_array($name)) {
            for ($i = 0; $i < sizeof($name); $i ++) {
                $this->formerr_arr[$name[$i]] ++;
            }
        } else {
            $this->formerr_arr[$name] ++;
        }
        $this->Page->AddErrorMessage($errors_section, $error);
    }
    /**
     *  Method add error message to parent page errors container
     * @param  string    $errors_section     section name of error string
     * @param  string    $error              error variable name
     * @param  string    $fname              field name
     * @param  array     $data               additional error data
     * @param  boolean   $named_length_error flag identify personal length error
     **/
    function AddErrorMessage ($errors_section, $error, $fname, $data = array(), $named_length_error = true)
    {
        if ($this->Page->Kernel->Errors->HasItem($errors_section, $error . (($named_length_error === false || $fname == "") ? "" : "_" . $fname))) {
            $this->Page->AddErrorMessage($errors_section, $error . (($named_length_error === false || $fname == "") ? "" : "_" . $fname), $data);
        } else {
            if ($this->Page->Kernel->Errors->HasItem("GlobalErrors", $fname)) {
                $error_string = $this->Page->Kernel->Errors->GetItem("GlobalErrors", $fname);
            } else {
                $error_string = $this->Page->Kernel->Errors->GetItem("GlobalErrors", $error);
            }
            @$errClass = &Error::GetInstance();
            $errClass->SystemMessages->Sections["globalerrors"][$error . "_" . $fname] = $error_string;
            $this->Page->AddErrorMessage("GlobalErrors", $error . "_" . $fname, $data);
        }
    }
} // class
?>