<?php
$this->ImportClass("web.controls.itemslistcontrol", "ItemsListControl");
/** List control
 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
 * @version 1.0
 * @package Libraries
 * @subpackage classes.web.controls
 * @access public
 */
class SubscribeAdminListControl extends ItemsListControl{
    var $ClassName = "SubscribeAdminListControl";
    var $Version = "1.0";

    function ProcessListSection(){
		if ($this->library_ID=="contentlist" || $this->library_ID=="archivelist" || $this->library_ID=="userthemelist"){
            if (!$this->Page->Kernel->MultiLanguage){
				$fields=$this->listSettings->GetItem("LIST", "FIELDS_COUNT");
				for($i=0; $i<$fields; $i++){
					$name=$this->listSettings->GetItem("FIELD_".$i, "FIELD_NAME");
					if ($name=="lang_ver"){
						$this->listSettings->SetItem("FIELD_".$i, "EDIT_CONTROL", null);
						$this->listSettings->SetItem("FIELD_".$i, "IN_LIST", 0);
					}
				}
			}
		}
    	return parent::ProcessListSection();
    }

} // class


?>