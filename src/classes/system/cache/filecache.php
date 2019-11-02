<?php
define('CACHE_CHMOD', 0777);
class FileCache {
    var $cachePath = null;

    function FileCache($path) {
    	$this->setCachePath($path);
    }

    function setCachePath($path)
    {
        $path = rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $this->cachePath = $path;
        $this->initCache();
    }

    function getCachePath()
    {
        return $this->cachePath;
    }

    function purgeCache() {
        return $this->realPurgeCache($this->getCachePath());
    }

    function realPurgeCache($path) {
        $path = rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $dir = opendir($path);
        while ($item = readdir($dir)) {
            if (($item == '.') || ($item == '..')) continue;
            if (is_file($path . $item)) {
                @umask(0777);
                @chmod($path.$item, CACHE_CHMOD);
                @unlink($path . $item);

            } elseif (is_dir($path . $item)) {
            	$this->realPurgeCache($path . $item);
                //rmdir($path . $item);
            }
        }
    }

    function put($filename, $data) {
        umask(0777);
        $filename = $this->getCachePath() . $filename;
        if (!file_exists(dirname($filename))) {
        	@mkdir(dirname($filename), CACHE_CHMOD);
            @chmod(dirname($filename), CACHE_CHMOD);
    	}
    	file_put_contents($filename, serialize($data));
        @chmod($filename, CACHE_CHMOD);
    }

    function initCache()
    {
        $path = $this->getCachePath();
        if (file_exists($path)) {
            return $this;
        }
    	mkdir_r($path, CACHE_CHMOD, true);
        chmod($path, CACHE_CHMOD);
        return $this;
    }

    function get($filename, $ttl)
    {
        $filename = $this->getCachePath() . $filename;
        if (! is_readable($filename)) {
//            print "<p>[MIS] $filename</p>";
            return false;
        }
        if ((time() - filemtime($filename)) / 60 > $ttl) {
//            print "<p>[EXP] $filename</p>";
            return false;
        }
//        print "<p>[HIT] $filename</p>";
        return unserialize(file_get_contents($filename));
    }

}
