<?php
/**
  * Entry point
  * @module entry.php
  * @package CMS
  * @access public
  * @modulegroup CMS
 */

date_default_timezone_set('Europe/Kiev');

define("NO_CACHE",1);
define("NO_ENGINE_CACHE", 1);

define("CACHE_ROOT","/opt/CACHE/");

/*   Loader root directory  */
define("LOADER_ROOT","/opt/project/engine/loader/");

/*   Ini-file root directory  */
define("INIFILE_ROOT","/opt/");

//Include engine
include(LOADER_ROOT."modules/engine.php");

?>