<?php

/** Base Component class.
* @author Sergey Grishko <sgrishko@reaktivate.com>
* @modified Konstantin Matsebora <kmatsebora@activemedia.com.ua>
* @version 2.0
* @package Loader
* @subpackage classes
* @access public
**/
class EngineCache {
	/**
	*  Class name
	* @var	string	$ClassName
	**/
	var $ClassName = "EngineCache";
		
	/**
	*  Class version
	* @var  string  $Version
	**/
	var $Version = "1.0";
	
	static function CheckCachedInit($f=false){
        if ((defined("NO_ENGINE_CACHE") && (NO_ENGINE_CACHE == 1))){
			return true;
		}

        if (!$f){
        	$file_name=CACHE_ROOT.'engine/class_init';
        	if (!file_exists($file_name)){
	            $classes=array(	LOADER_ROOT . 'modules/functions.php',
							    LOADER_ROOT . 'classes/error.php',
						        LOADER_ROOT . 'classes/component.php',
						        LOADER_ROOT . 'classes/configfilehelper.php',
						        LOADER_ROOT . 'classes/configfile.php',
						        LOADER_ROOT . 'classes/datadispatcher.php',
						        LOADER_ROOT . 'classes/path.php',
						        LOADER_ROOT . 'classes/debug.php',
						        LOADER_ROOT . 'classes/package.php',
						        LOADER_ROOT . 'classes/kernel.php',
						        LOADER_ROOT . 'classes/engine.php');

	          	$class=null;
	          	foreach($classes as $path){
	                $t=token_get_all(file_get_contents($path));
			        for ($i=0, $c=count($t); $i<$c; $i++){
			        	$tc=$t[$i][0];
			        	if (!is_array($t[$i])){
			         		$class.=$t[$i];
			         	} else {
			         		if($tc!=T_WHITESPACE && $tc!=T_COMMENT && $tc!=T_DOC_COMMENT){
			         			$class.=$t[$i][1];
							}
			         		if ($tc==T_WHITESPACE){
								$class.=" ";
							}
			         	}
			        }
	          	}

				$handle = fopen($file_name, 'w');
				fwrite($handle, $class);
				fclose($handle);
				$mask = umask(0);
				@chmod($file_name, 0777);
				@umask($mask);
			}
			include($file_name);
        }
        return false;
    }
	
	static function CheckCachedClass($className, $package){
    	$path="";    	
    	if (DataDispatcher::isExists('CachedClasses')){
    		$CachedClasses=DataDispatcher::get('CachedClasses');
    	}else{
    		$file_name = CACHE_ROOT.'engine/classes';
    		if (is_readable($file_name)){
    			$CachedClasses=unserialize_file($file_name);
	   		}else{
                $CachedClasses=array();
			}
    		DataDispatcher::set('CachedClasses', $CachedClasses);
    	}
    	if (is_array($CachedClasses)){
    		$path=$CachedClasses[$className.($package!='' ? '|' : '').$package];    		
      	}
        return $path;
    }

    static function CheckKernelCached(&$Kernel){
    	if ( defined('NO_ENGINE_CACHE') && (NO_ENGINE_CACHE != 0)){
			return true;
		}
        $cacheFile=CACHE_ROOT.'engine/kernel_'.md5($iniFileRoot.$IniFile.$Kernel->ComponentName.$Kernel->ComponentRoot.Engine::getVariable('language'));
        if (is_readable($cacheFile) && (time() - filemtime($cacheFile)) < 604800){
        	list(
				$Kernel->Settings,
				$Kernel->Languages,
				$Kernel->LangShortNames,
				$Kernel->LangLongNames,
				$Kernel->Language,
				$Kernel->MultiLanguage,
				$Kernel->Debug,
				$Kernel->ResourcesRoot,
				$Kernel->ClassesDirs,
				$Kernel->ModuleRoot,
				$Kernel->FileMode,
				$Kernel->DirMode)=unserialize_file($cacheFile);
			return false;
        }
        return true;
    }

    static function CacheKernel(&$Kernel){
    	if ( defined('NO_ENGINE_CACHE') && (NO_ENGINE_CACHE != 0)){
			return;
		}
    	$cacheFile=CACHE_ROOT.'engine/kernel_'.md5($iniFileRoot.$IniFile.$Kernel->ComponentName.$Kernel->ComponentRoot.Engine::getVariable('language'));

    	serialize_data($cacheFile, array(
			$Kernel->Settings,
			$Kernel->Languages,
			$Kernel->LangShortNames,
			$Kernel->LangLongNames,
			$Kernel->Language,
			$Kernel->MultiLanguage,
			$Kernel->Debug,
			$Kernel->ResourcesRoot,
			$Kernel->ClassesDirs,
			$Kernel->ModuleRoot,
			$Kernel->FileMode,
			$Kernel->DirMode));
    }

    static function CheckKernelPackageCached(&$Kernel, $package){
    	if ( defined('NO_ENGINE_CACHE') && (NO_ENGINE_CACHE != 0)){
			return true;
		}
        $cacheFile=CACHE_ROOT.'engine/kernel_package_'.md5($package." ".Engine::GetPackageName()." ".$Kernel->Language);
        if (is_readable($cacheFile) && (time() - filemtime($cacheFile)) < 604800){
        	list(
				$Kernel->Package,
				$Kernel->Errors,
				$Kernel->Localization,
				$Kernel->useAuthentication)=unserialize_file($cacheFile);
        	$GLOBALS["config_errorMessages"]=&$Kernel->Errors;
			return false;
        }
        return true;
    }

    static function CacheKernelPackage(&$Kernel, $package){
    	if ( defined('NO_ENGINE_CACHE') && (NO_ENGINE_CACHE != 0)){
			return;
		}
    	$cacheFile=CACHE_ROOT.'engine/kernel_package_'.md5($package." ".Engine::GetPackageName()." ".$Kernel->Language);
    	serialize_data($cacheFile, array(
			$Kernel->Package,
			$Kernel->Errors,
			$Kernel->Localization,
			$Kernel->useAuthentication));
    }
	
	static function SaveLoadedClasses($className, $package, $path){
        if (DataDispatcher::isExists('CachedClasses')){
    		$CachedClasses=DataDispatcher::get('CachedClasses');
    		if (!($CachedClasses[$className.($package!='' ? '|' : '')]!='')){
    			EngineCache::SaveClass($path);
    			$CachedClasses[$className.($package!='' ? '|' : '').$package]=CACHE_ROOT.'engine/class_'.md5($path);
    			$file_name = CACHE_ROOT.'engine/classes';
    			DataDispatcher::set('CachedClasses', $CachedClasses);
    			if (is_writable($file_name) || !file_exists($file_name)){
    				serialize_data($file_name, $CachedClasses);
				}
    		}
    	}
    }

    static function SaveClass($path){
        $t=token_get_all(file_get_contents($path));

		$class=null;
        for ($i=0, $c=count($t); $i<$c; $i++){
        	$tc=$t[$i][0];
        	if (!is_array($t[$i])){
         		$class.=$t[$i];
         	}else {
         		if($tc!=T_WHITESPACE && $tc!=T_COMMENT && $tc!=T_DOC_COMMENT){
         			$class.=$t[$i][1];
				}
         		if ($tc==T_WHITESPACE){
					$class.=" ";
				}
         	}
        }
        $file_name=CACHE_ROOT.'engine/class_'.md5($path);
		$handle = fopen($file_name, 'w');
		fwrite($handle, $class);
		fclose($handle);
		$mask = umask(0);
		@chmod($file_name, 0777);
		@umask($mask);
    }
}
?>
