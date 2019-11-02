<?php
	/** XML Helper class
	  * Provides routines to render proper lists regarding data types
	  * @author Sergey Grishko <sgrishko@reaktivate.com>
      * @modified Artem Mikhmel <amikhmel@activemedia.com.ua>
	  * @version 1.0
	  * @package	Framework
	  * @subpackage classes.system.xml
	  * @access public
	  * @static
	  **/
	class XmlHelper {
		// Class information
		var $className = "XmlHelper";
		var $version = "1.0";

        /**
        * Method builds date representation of a control
        * @param    (object structure)  $xmlWriter  Instance of xmlWriter
        * @param     string             $xmlTag     Xml Tag
        * @param     string             $dateString String representation of date
        * @access    public
        */
		static function BuildDateXml(&$xmlWriter, $xmlTag, $dateString = null) {
			if (is_null($dateString)) {
				$dateString = date("Y-m-d");
			}

			list($year, $month, $day) = sscanf($dateString, "%d-%d-%d");
			$xmlWriter->WriteStartElement($xmlTag);
			$xmlWriter->WriteElementString("Year", $year);
			$xmlWriter->WriteElementString("MonthValue", $month);
			$xmlWriter->WriteElementString("MonthShortName", date("M", mktime(0, 0, 0, $month, 1, 2000)));
			$xmlWriter->WriteElementString("MonthName", date("F", mktime(0, 0, 0, $month, 1, 2000)));
			$xmlWriter->WriteElementString("DayValue", $day);
			$xmlWriter->WriteElementString("Day", ($day < 10 ? "0" : "") . $day);
			$xmlWriter->WriteEndElement();
		}

        /**
        * Method builds date and time representation of a control
        * @param    (object structure)  $xmlWriter  Instance of xmlWriter
        * @param     string             $xmlTag     Xml Tag
        * @param     string             $dateString String representation of date
        * @access    public
        */
		static function BuildDateTimeXml(&$xmlWriter, $xmlTag, $dateTimeString = null) {
			if (is_null($dateTimeString)) {
				$dateTimeString = date("Y-m-d H:i:s");
			}
			list($year, $month, $day, $hour, $minute, $second) = sscanf($dateTimeString, "%d-%d-%d %d:%d:%d");
			$xmlWriter->WriteStartElement($xmlTag);
			$xmlWriter->WriteElementString("Year", $year);
			$xmlWriter->WriteElementString("MonthValue", $month);
			$xmlWriter->WriteElementString("MonthShortName", date("M", mktime(0, 0, 0, $month, 1, 2000)));
			$xmlWriter->WriteElementString("MonthName", date("F", mktime(0, 0, 0, $month, 1, 2000)));
			$xmlWriter->WriteElementString("DayValue", $day);
			$xmlWriter->WriteElementString("Day", ($day < 10 ? "0" : "") . $day);
			$xmlWriter->WriteElementString("HourValue", $hour);
			$xmlWriter->WriteElementString("Hour", ($hour < 10 ? "0" : "") . $hour);
			$xmlWriter->WriteElementString("MinuteValue", $minute);
			$xmlWriter->WriteElementString("Minute", ($minute < 10 ? "0" : "") . $minute);
			$xmlWriter->WriteElementString("SecondValue", $second);
			$xmlWriter->WriteElementString("Second", ($second < 10 ? "0" : "") . $second);
			$xmlWriter->WriteEndElement();
		}
       /**
        * Method cuts  string in first occurance of space after MinLen length
        * @param     string      $String  String to strip out
        * @param     int         $MinLen  Minimum string length
        * @param     int         $MaxLen  Maximum string length
        * @return    string      stripped string
        * @access    public
        */

		static function StripString($String, $MinLen, $MaxLen) {
			if (strlen($String) < $MinLen)
				return $String;

			$stripped = 0;
			$cb = $String;
			for ($i=$MinLen; $i<=$MaxLen; $i++) {
				if ($cb[$i] == ' ') {
					$stripped = 1;
					$ret = substr($String, 0, $i);
					$break;
				}
			}
			if ($stripped == 1)
				return $ret;
			else
				return $String;
		}

        /**
        * Method generates random password with length of 8 chars
        * @return    string    Generated password
        * @access    public
        */
		static function generatePassword() {

			$salt = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
			srand((double)microtime()*1000000);
			$i = 0;

			while ($i < 8) {  // change for other length
				$num = rand() % strlen($salt);
				$tmp = substr($salt, $num, 1);
				$pass = $pass . $tmp;
				$i++;
			}
			return $pass;
		}

       /**
         * Method builds XML Pager
         * @param       (object structure)    $xmlWriter    Instance of xmlWriter Class
         * @param       int $page          Page number
         * @param       int $itemsCount    Items count
         * @param       int $itemsPerPage  Items per page
         * @param       int $pagesPerPager Pages per pager
         * @access      public
         **/
       static function buildPagerXml(&$xmlWriter, $page, $itemsCount, $itemsPerPage, $pagesPerPager) {
            $pageCount = ($itemsCount - 1) / $itemsPerPage + 1;
            $startItem = $itemsPerPage * ($page - 1) + 1;
            $endItem = $itemsPerPage * $page;
            if ($endItem > $itemsCount)
                $endItem = $itemsCount;

            $xmlWriter->WriteStartElement("pager");
            $xmlWriter->WriteElementString("items-per-page", $itemsPerPage);
            $xmlWriter->WriteElementString("page-count", $pageCount);
            $xmlWriter->WriteElementString("current-page", $page);

            $xmlWriter->WriteElementString("start-item", $startItem);
            $xmlWriter->WriteElementString("end-item", $endItem);

            $xmlWriter->WriteStartElement("first-page");
            if ($page == 1)
                $xmlWriter->WriteAttributeString("current", "");
            $xmlWriter->WriteString("1");
            $xmlWriter->WriteEndElement();

            $xmlWriter->WriteStartElement("previous-page");
            if ($page == 1)
                $xmlWriter->WriteAttributeString("current", "");
            $xmlWriter->WriteString($page - ($page == 1 ? 0 : 1));
            $xmlWriter->WriteEndElement();

            $xmlWriter->WriteStartElement("next-page");
            if ($page == $pageCount)
                $xmlWriter->WriteAttributeString("current", "");
            $xmlWriter->WriteString($page + ($page == $pageCount ? 0 : 1));
            $xmlWriter->WriteEndElement();

            $xmlWriter->WriteStartElement("last-page");
            if ($page == $pageCount)
                $xmlWriter->WriteAttributeString("current", "");
            $xmlWriter->WriteString($pageCount);
            $xmlWriter->WriteEndElement();

            if ($pagesPerPager < $pageCount) {
                $startPage = $page - (int) ($pagesPerPager / 2);
                if ($startPage < 1)
                    $startPage = 1;
                if ($page + (int) ($pagesPerPager / 2) > $pageCount)
                    $startPage = $startPage - ($page + (int) (($pagesPerPager) / 2) - $pageCount) + ($pagesPerPager % 2 == 1 ? 0 : 1);
                if ($startPage > 1)
                    $xmlWriter->WriteElementString("previous-pager-page",
                        $startPage - 1);
                if ($startPage + $pagesPerPager < $pageCount)
                    $xmlWriter->WriteElementString("next-pager-page",
                        $startPage + $pagesPerPager);
                for ($i = $startPage; $i < $startPage + $pagesPerPager; $i++) {
                    $xmlWriter->WriteStartElement("page-link");
                    if ($i == $page)
                        $xmlWriter->WriteAttributeString("active", "");
                    $xmlWriter->WriteString($i);
                    $xmlWriter->WriteEndElement();
                }
            }
            else
                for ($i = 1; $i <= $pageCount; $i++) {
                    $xmlWriter->WriteStartElement("page-link");
                    if ($i == $page)
                        $xmlWriter->WriteAttributeString("active", "");
                    $xmlWriter->WriteString($i);
                    $xmlWriter->WriteEndElement();
                }
            $xmlWriter->WriteEndElement();
        }


  /**
    * Method builds XML list regarding on xmlWriter, dataReader, decorator
    * @param       (object structure)    $xmlWriter    Instance of xmlWriter Class
    * @param       (object structure)    $dataReader  Instance of Datareader Class
    * @param       string   $decorator   Name of the method used to decorate the result
    * @param       object   $object      Object with decorator method
    * @access      public
    **/
        static function buildListXml(&$xmlWriter, &$dataReader, $decorator = null,&$object) {
            $useDecorator = (strlen($decorator) && method_exists($object, $decorator));
            if ($dataReader) {
                while ($dataReader->Read()) {
                    if ($useDecorator) {
                        $object->$decorator($xmlWriter, $dataReader->Item);
                    }
                    else {
                        $xmlWriter->WriteStartElement("row");
                        foreach($dataReader->Item as $key => $value) {
                            $xmlWriter->WriteElementString($key, $value);
                        }
                        $xmlWriter->WriteEndElement();
                    }
                }
                $dataReader->Close();
            }
        }

         /**
        * Method draws array of data in specified XML-node set
        *  @param   XMLWriter   $xmlWriter   Instance of XMLWriter
        *  @param   array   $data   Array of data to draw
        *  @param   string   $group_tag_name   Group Tag  name

        *  @param   string   $element_tag_name   Element Tag  name
        *  @access  public
        **/
        static function DrawArray(&$xmlWriter, $data, $group_tag_name, $element_tag_name){
           $sizeof = sizeof($data);
           $xmlWriter->WriteStartElement($group_tag_name);
           for($i=0; $i<$sizeof; $i++){
                $xmlWriter->WriteElementString($element_tag_name, $data[$i]);
           }
           $xmlWriter->WriteEndElement();

        }
	} // class
?>