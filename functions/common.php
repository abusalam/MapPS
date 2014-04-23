<?php
function makeSafe($string){
		$string=str_replace("'","",$string);
		$string=str_replace("\\","",$string);
		$string=str_replace("//","",$string);
		//$string=str_replace("-","",$string);
		//$string=str_replace(")","",$string);
		//$string=str_replace("(","",$string);
		//$string=str_replace("0x27","",$string);
		//$string=str_replace("0x7e","",$string);
		//$string=str_replace("information_schema","",$string);
		
		
		$string=(get_magic_quotes_gpc() ? stripslashes($string) : $string);
		if(function_exists('mysql_real_escape_string')){
			// send a trivial query to initiate mysql connection
			
			return mysql_real_escape_string($string);
		}else{
			return mysql_escape_string($string);
		}
	}
	
function upload_image($upath,$width,$height,$aRatio)
{
	move_uploaded_file($_FILES["file"]["tmp_name"],$upath);
	$image = new SimpleImage();
	$image->load($upath);
	$targetWidth=$width;
	$targetHeight=$height;
	if ($image->getWidth()>=$image->getHeight()) 
		$percentage = ($targetWidth / $image->getWidth());
	else 
		$percentage = ($targetHeight / $image->getHeight());

	$width = round($image->getWidth() * $percentage);
	$height = round($image->getHeight() * $percentage);
	$image->resize($width,$height);
	$image->save($upath);	
}		


		?>