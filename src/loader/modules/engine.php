<?php
/**
* Module(site) engine main file
* @module         engine.php
* @package        Loader
* @subpackage     modules
* @access         public
* @modulegroup    Loader
*/



//include kernel class
if (!class_exists("Loader")) {
    include(LOADER_ROOT."classes/loader.php");
}

$type = isset($_GET["type"]) ? $_GET["type"] : "";
$component = isset($_GET["component"]) ? $_GET["component"] : "";

$Loader = new Loader();
$Loader->Init();
$Loader->Load($type, $component);
$Loader->Run();
$Loader->UnLoad();

?>