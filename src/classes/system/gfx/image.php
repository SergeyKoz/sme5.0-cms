<?php
/**
 * amWebFramework
 *
 * @version    $Id: image.php,v 1.2 2011/02/17 15:08:23 skozin Exp $
 * @copyright  (C) 2008 Activemedia, LLC
 * @author     Alexander A. Degtiar <adegtiar@activemedia.ua>
 */

class Image
{
    var $ClassName = "Image";
    var $Version = "1.0";
    var $image = null;
    var $width = 0;
    var $height = 0;
    var $isTrueColor = false;
    var $fileAccessMode = 0777;

    function _init()
    {
    	$this->image = null;
    	$this->width = 0;
    	$this->height = 0;
    	$this->isTrueColor = false;
    }

    function getWidth()
    {
        return $this->width;
    }

    function getHeight()
    {
        return $this->height;
    }

    function isTrueColor()
    {
        return $this->isTrueColor;
    }

    function loadFromFile($filename, $forceType = '')
    {
    	$this->_init();
    	if (!is_readable($filename)) {
    		return false;
    	}

    	$fileExt = ($forceType == '') ? pathinfo($filename, PATHINFO_EXTENSION) : strtolower($forceType);
    	switch($fileExt) {
            case 'jpeg':
            case 'jpg':
           	   $this->image = @imagecreatefromjpeg($filename);
           	   break;
            case 'png':
           	   $this->image = @imagecreatefrompng($filename);
           	   break;
            case 'gif':
           	   $this->image = @imagecreatefromgif($filename);
           	   break;
       	    default:
               $this->image = @imagecreatefromstring(@file_get_contents($filename));
    	}
    	$this->getInfo();
        return ($this->image !== false);
    }

    function loadFromString($data)
    {
        $this->_init();
    	$this->image = @imagecreatefromstring($data);
        if ($this->image === false) return false;
        $this->getInfo();
        return true;
    }

    function getInfo()
    {
    	if (!$this->image) {
    		return false;
    	}
        $this->width = imagesx($this->image);
        $this->height = imagesy($this->image);
        $this->isTrueColor = imageistruecolor($this->image);
    }

    function saveToFile($filename, $imageType, $quality = 70, $filters = null)
    {
        return $this->make($filename, $imageType, $quality, $filters);
    }

    function saveToString($imageType, $quality = 70, $filters = null)
    {
        $ob = ob_get_clean();
        ob_start();
        $this->make(null, $imageType, $quality, $filters);
        $imageData = ob_get_clean();
        ob_start();
        echo $ob;
        return $imageData;
    }

    function resizeSquare($resizeToWidth, $allowUpsize = true)
    {
		$offsetX = 0;
		$offsetY = 0;
		if ($this->width > $this->height) {
			$offsetX = ($this->width - $this->height)/2;
		} else
		if ($this->height > $this->width) {
			$offsetY = ($this->height - $this->width)/2;
		}

        if (($this->width < $resizeToWidth) && ($this->height < $resizeToWidth) && !$allowUpsize) {
             return true;
        }
        $newImage = imagecreatetruecolor($resizeToWidth, $resizeToWidth);
        $white = imagecolorallocate($newImage, 255, 255, 255);
        if (imagecopyresampled($newImage, $this->image, 0, 0, $offsetX, $offsetY, $resizeToWidth, $resizeToWidth, $this->width-$offsetX*2, $this->height-$offsetY*2)) {
            imagedestroy($this->image);
            $this->image = $newImage;
            $this->getInfo();
            return true;
        } else {
            imagedestroy($newImage);
            return false;
        }
	}

    function resizeKeepAspect($resizeToWidth, $resizeToHeight, $allowUpsize = true)
    {
        $kw = $this->width / $resizeToWidth;
        $kh = $this->height / $resizeToHeight;

        $k = max($kw, $kh);
        if ($k > 1) {
            $resizeToWidthK = $this->width / $k;
            $resizeToHeightK = $this->height / $k;
        } else {
            if (!$allowUpsize) return true;
            $kw = $resizeToWidth / $this->width;
            $kh = $resizeToHeight / $this->height;
            $k = min($kw, $kh);
            $resizeToWidthK = $this->width * $k;
            $resizeToHeightK = $this->height * $k;
        }

        $newImage = imagecreatetruecolor($resizeToWidthK, $resizeToHeightK);
        $white = imagecolorallocate($newImage, 255, 255, 255);
        if (imagecopyresampled($newImage, $this->image, 0, 0, 0, 0, $resizeToWidthK, $resizeToHeightK, $this->width, $this->height)) {
            imagedestroy($this->image);
            $this->image = $newImage;
            return true;
        } else {
            imagedestroy($newImage);
            return false;
        }
	}

    function make($filename, $imageType, $quality = null, $filters = null)
    {

		if (!file_exists(dirname($filename))) {
			@mkdir(dirname($filename), $this->fileAccessMode);
			@chmod(dirname($filename), $this->fileAccessMode);
		}

        switch (strtolower($imageType)) {
            case 'gif':
                    $result = imagegif($this->image, $filename);
                break;
            case 'png':
                    $result = imagepng($this->image, $filename, $quality, $filters);
                break;
            case 'jpg':
            case 'jpeg':
                    $result = imagejpeg($this->image, $filename, $quality);
                break;
                default:
                    return false;
        }
        if ($result) {
            @chmod($filename, $this->fileAccessMode);
        }
        return $result;
    }

}
