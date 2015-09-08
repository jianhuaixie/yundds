<?php
class get_filesize{
	public function index()
	{		
		$filename = strim($GLOBALS['request']['filename']);
		$size = - 1;
		$file = ROOT_PATH . $filename;
		$file = str_replace( "//", "/", $file );
		
		if (file_exists ( $file )) {
			$size = filesize ( $file );
			$size = $size ? $size : 0;
		}else{
			$size = -1;
		}
		$root['size'] = $size;
		output($root);	
	}
}	
?>