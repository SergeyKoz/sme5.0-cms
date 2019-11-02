<?php
$this->ImportClass("system.web.xmlcontrol", "XMLControl");
/** Extranet Menu Page class
 * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
 * @version 1.0
 * @package  Extranet
 * @subpackage classes.web
 * @access public
 */
class ConfigMenuControl extends XMLControl{
    var $ClassName = "ConfigMenuControl";
    var $Version = "1.0";

    /**
     * Method get packages menu definition and insert it to menu object
     * @param      string  $filename       file name of package menu file
     * @access private
     **/
    static function GetPackagesMenu(&$object, &$menu, $filename){
	        $menuPathList = array();
	        foreach ($object->Kernel->Settings->GetSection("PACKAGES") as $name => $path) {
	            if ($name != "extranet") {
	                $package = $object->Kernel->getPackageSettings($name);
	                $menuPathList = array_merge($menuPathList, (array)$package->GetItem("PACKAGE", "ResourcePath"));
	            }
	        }

	        $menuPathList = array_unique($menuPathList);

	        foreach ($menuPathList as $path) {
	            if (is_readable($path . $filename)) {
	                ConfigFile::emptyInstance("_temp");
	                $_menu = &ConfigFile::GetInstance("_temp", $path . $filename);
	                $menu->mergeSections($_menu, "a");
	                ConfigFile::emptyInstance("_temp");
	            }
	        }

    }

    /**
     *  Method builds rows of a list
     * @param  XMLWriter   $xmlWriter  instance of XMLWriter
     * @access private
     **/
	static function RenderPackagesMenu(&$object, &$menu, &$auth, &$xmlWriter, $pageMode=""){

        $sections = (array)$menu->GetItem("MENU", "sections");
        $l=$object->Language;
        $render_sections = array();

        foreach ($sections as $i => $sectionname) {
            if ('' == $sectionname) {
                continue;
            }
            //set section array
            $cursection = $render_sections[$sectionname] = array();
            $cursection["title"] = $menu->GetItem($sectionname, "_title_" . $l);
            $cursection["items"] = array();
            //get  link urls
            $items_link_urls = $menu->GetItem($sectionname, "link_url");
            if (! is_array($items_link_urls)) {
                $items_link_urls = array($items_link_urls);
            }
            //--get link titles
            $items_link_titles = $menu->GetItem($sectionname, "link_title_" . $l);
            if (! is_array($items_link_titles)) {
                $items_link_titles = array($items_link_titles);
            }
            //--get link images
            $items_link_images = $menu->GetItem($sectionname, "link_image");
            //--get link target
            $items_link_packages = $menu->GetItem($sectionname, "link_package");
            if (! is_array($items_link_images)) {
                $items_link_images = array($items_link_images);
            }
            if (! is_array($items_link_packages)) {
                $items_link_packages = array($items_link_packages);
            }
            $access_granted = false;
            //--get section links access
            if ($menu->HasItem($sectionname, "link_access")) {
                $items_link_access = $menu->GetItem($sectionname, "link_access");
                if (! is_array($items_link_access)) {
                    $items_link_access = array($items_link_access);
                }
                //--check access to  the section
                if ($auth->isRoleExists(implode(",", $items_link_access), $pageMode))
                    $access_granted = true;
            } else {
                $items_link_access = array();
                $access_granted = true;
            }
            //set items to real menu
            if ($access_granted)
                foreach ($items_link_urls as $j => $url) {
                    if (($auth->isSuperUser()) || (count($items_link_access) != 0) && $auth->isRoleExists($items_link_access[$j], $pageMode)) {
                        //--get packe info
                        if (! isset($package[$items_link_packages[$j]]))
                            $package[$items_link_packages[$j]] = $object->getPackageSettings($items_link_packages[$j]);
                            //--get package image url
                        $_img_url = $package[$items_link_packages[$j]]->GetItem("Package", "PackagePath") . $items_link_images[$j];
                        //--check image file in package dir
                        if (file_exists($_img_url)) {
                            $img_url = $package[$items_link_packages[$j]]->GetItem("Package", "PackageURL") . "/";
                        } else {
                            $img_url = $object->Settings->GetItem("MODULE", "FrameworkURL") . "packages/" . $items_link_packages[$j] . "/";
                        }
                        //add item
                        if ($menu->HasItem($sectionname, "link_target_" . ($j + 1))) {
                            $target = $object->GetItem($sectionname, "link_target_" . ($j + 1));
                        } else {
                            $target = "parent.content";
                        }
                        $cursection["items"][] = array("url" => $items_link_urls[$j] , "title" => $items_link_titles[$j] , "image" => $img_url . $items_link_images[$j] , "target" => $target);
                    } //end if
                } //end foreach
            unset($package);
            $render_sections[$sectionname] = $cursection;
        } //end foreach
        //render menu
        if (sizeof($render_sections)) {
            $object->ImportClass("system.web.controls.recordcontrol", "RecordControl");
            $record = new RecordControl("record", "link");
            $xmlWriter->WriteStartElement("menu");
            foreach ($render_sections as $sectionname => $section) {
                if (count($section["items"])) {
                    $xmlWriter->WriteStartElement("section");
                    $xmlWriter->WriteElementString("title", $section["title"]);
                    foreach ($section["items"] as $i => $item) {
                        $record->InitControl($item);
                        $record->XmlControlOnRender($xmlWriter);
                    }
                    $xmlWriter->WriteEndElement();
                }
            }
            $xmlWriter->WriteEndElement("menu");
        }

    }

    // class
}
?>