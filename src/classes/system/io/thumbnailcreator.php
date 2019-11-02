<?php
    // Static class for generate thumbnails for smengine2-4-1
	class ThumbnailCreator {
        // $image - path to initial image
        // $Settings - additional parameters
		function ThumbnailCreate($image, $Settings){
			$Settings["self"]->Page->Kernel->ImportClass("system.io.filesystem", "FileSystem");

			//get image settings
            list($width, $height, $type, $attr) = getimagesize($image);

        	switch ($type){
        		case IMAGETYPE_GIF : $ImRes=@imagecreatefromgif($image); break;    //
        		case IMAGETYPE_JPEG : $ImRes=@imagecreatefromjpeg($image); break;
        		case IMAGETYPE_PNG : $ImRes=@imagecreatefrompng($image); break;
        		case IMAGETYPE_WBMP : $ImRes=@imagecreatefromwbmp($image); break;
        		case IMAGETYPE_XBM : $ImRes=@imagecreatefromxbm($image); break;
        	}

        	if (isset($ImRes)){
                //create new folders
        		$NewThumbImage=str_replace($Settings["filesfolder"], $Settings["thumbfolder"], $image);
	            $pathparts = pathinfo($NewThumbImage);
	            $NewThumbImagePath=$pathparts["dirname"];
	            FileSystem::makeDir("",
			                        $NewThumbImagePath,
			                        $Settings["self"]->Kernel->Settings->GetItem("SETTINGS","DirMode"),
			                        false);
        		if ($width>$Settings["width"] || $height>$Settings["height"]){
        			//get new dimensions




		      		$scale=explode("x", $scale);

		      		$scale[0]=$Settings["width"];
		      		$scale[1]=$Settings["height"];

		      		if ($width>=$height && $width>$scale[0]){
		                $ret0=$scale[0]/$width;
		                $k=($width/$height)/($scale[0]/$scale[1]);
		                if ($k>0 && $k<1)
		                	$ret0=$k*$ret0;
		        	}

		      		if ($width<$height && $height>$scale[1]){
		                $ret0=$scale[1]/$height;
		                $k=($height/$width)/($scale[1]/$scale[0]);
		                if ($k>0 && $k<1)
		                	$ret0=$k*$ret0;
		        	}
		        	$NewThumbWidth=$width*$ret0;
		        	$NewThumbHeight=$height*$ret0;


                    /*
        			$Scale=$width/$height;
     				if ($width>$height){
     					$NewThumbWidth =$Settings["width"];
     					$NewThumbHeight =ceil($NewThumbWidth/$Scale);
     				} elseif ($width<$height) {
     					$NewThumbHeight = $Settings["height"];
     					$NewThumbWidth = ceil($NewThumbHeight*$Scale);
     				} elseif ($width==$height) {
                        if ($Settings["width"]>=$Settings["height"])
                         	$NewThumbHeight = $NewThumbWidth= $Settings["height"];
                        else
                            $NewThumbHeight = $NewThumbWidth= $Settings["width"];
     				}*/

	   				$ImThumbRes = @imagecreatetruecolor($NewThumbWidth, $NewThumbHeight);
                    //resize image
	                imagecopyresized($ImThumbRes,
	                				 $ImRes, 0, 0, 0, 0,
	                				 $NewThumbWidth, $NewThumbHeight,
	                				 $width, $height);

                    // save new image
				    if (isset($ImThumbRes)){
	                    switch ($type){
			        		case IMAGETYPE_GIF : imagegif($ImThumbRes, $NewThumbImage); break;
			        		case IMAGETYPE_JPEG : imagejpeg($ImThumbRes, $NewThumbImage); break;
			        		case IMAGETYPE_PNG : imagepng($ImThumbRes, $NewThumbImage); break;
			        		case IMAGETYPE_WBMP : imagewbmp($ImThumbRes, $NewThumbImage); break;
			        		case IMAGETYPE_XBM : imagexbm($ImThumbRes, $NewThumbImage); break;
			        	}
			        	return true;
			     	}

		     	} else { //
		     		//copy image
		     		if (copy($image, $NewThumbImage))
		     			return true;
   				}
        	}

        	return false;
		} //end of ThumbnailCreate

	} //end of class
?>