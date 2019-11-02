<?php
/**
  * Credit card processor
  * @author    Konstantin Matsebora    <kmatsebora@activemedia.com.ua>
  * @package   Framework
  * @subpackage classes.system.io
  * @access    public
  **/

  class CreditCardProcessor	{

  	/**
    	* Credit card number
      * @var	string	$ccard_number
      **/
    var $ccard_number;

    /**
      * Credit card expiration date
      * @var  string  $ccard_expdate
      **/
    var $ccard_expdate;

    /**
      * Credit card owner
      * @var  string  $ccard_owner
      **/
    var $ccard_owner;

    /**
      * Last transaction ID
      * @var  string  $transactionid
      **/
    var $transactionid;

    /**
      * Credit card type
      * @var  string  $ccard_type
      **/
    var $ccard_type;

    /**
    	* Class constructor
      * @param		string	$number		Credit card number
      * @param		string	$expdate  Expiration date
      * @param		string	$owner		Credit card owner
      * @param		string	$type			Credit card type
      **/
    function CreditCardProcessor($number,$expdate,$owner,$type)	{
	  $this->ccard_number		=   $number;
	  $this->ccard_expdate	    =   $expdate;
      $this->ccard_owner		=   $owner;
      $this->ccard_type         =   $type;
    }
    /**
    	* Method validate credit card localy
      * @return		boolean		validation result
      * @access		public
      **/
    function ValidateLocaly()	{
//  Check the expiration date first
    if (strlen($this->cccard_expdate)) {
      $Month = substr($this->cccard_expdate, 0, 2);
      $Year  = substr($this->cccard_expdate, -2);

      $WorkDate = "$Month/01/$Year";
      $WorkDate = strtotime($WorkDate);
      $LastDay  = date("t", $WorkDate);

      $Expires  = strtotime("$Month/$LastDay/$Year 11:59:59");
      if ($Expires < time()) return 0;
    }

//  Innocent until proven guilty
    $GoodCard = true;

//  Get rid of any non-digits
    $this->ccard_number = ereg_replace("[^0-9]", "", $this->ccard_number);
//  Perform card-specific checks, if applicable
    switch ($this->ccard_type) {

    case "mcd" :
      $GoodCard = ereg("^5[1-5].{14}$", $this->ccard_number);
      break;

    case "vis" :
      $GoodCard = ereg("^4.{15}$|^4.{12}$", $this->ccard_number);
      break;

    case "amx" :
      $GoodCard = ereg("^3[47].{13}$", $this->ccard_number);
      break;

    case "dsc" :
      $GoodCard = ereg("^6011.{12}$", $this->ccard_number);
      break;

    case "dnc" :
      $GoodCard = ereg("^30[0-5].{11}$|^3[68].{12}$", $this->ccard_number);
      break;

    case "jcb" :
      $GoodCard = ereg("^3.{15}$|^2131|1800.{11}$", $this->ccard_number);
      break;

    case "dlt" :
      $GoodCard = ereg("^4.{15}$", $this->ccard_number);
      break;

    case "swi" :
      $GoodCard = ereg("^[456].{15}$|^[456].{17,18}$", $this->ccard_number);
      break;

    case "enr" :
      $GoodCard = ereg("^2014.{11}$|^2149.{11}$", $this->ccard_number);
      break;
    }

//  The Luhn formula works right to left, so reverse the number.
    $this->ccard_number = strrev($this->ccard_number);

    $Total = 0;

    for ($x=0; $x<strlen($this->ccard_number); $x++) {
      $digit = substr($this->ccard_number,$x,1);

//    If it's an odd digit, double it
      if ($x/2 != floor($x/2)) {
        $digit *= 2;

//    If the result is two digits, add them
        if (strlen($digit) == 2)
          $digit = substr($digit,0,1) + substr($digit,1,1);
      }

//    Add the current digit, doubled and added if applicable, to the Total
      $Total += $digit;
    }

//  If it passed (or bypassed) the card-specific check and the Total is
//  evenly divisible by 10, it's cool!
	/*	if ($GoodCard && $Total % 10 == 0) {echo "COOL";
    	die();
    } */

    //echo ((int)$GoodCard)." ".$Total."<br>";
    if ($GoodCard && $Total % 10 == 0) return true; else return false;
  }

  /**
  	* Set credit card expiration date from format YYYY-MM-DD to MM/DD/YYYY
    * @param		string		$date			input date
    * @param		boolean		$convert  convert flag (from format YYYY-MM-DD HH:MM:SS to MM/DD/YYYY)
    **/
  function setDate($date,$convert=false)	{
  	if (!$convert)	{
        $this->ccard_expdate=$date;
    }    else	{
    	list($cdate,$ctime)=split(" ",$date);
      list($year,$month,$day)=split("-",$cdate);
        $this->ccard_expdate=$month."/".$day."/".$year;
	  }
  }

//end of class
}
?>