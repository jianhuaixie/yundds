<?php
class upload_file{
	public function index()
	{		
		
		//logutils::log_obj($_FILES['upload_img']);
		if(isset($_FILES['upload_img']))
		{
		
			$filename = ROOT_PATH.strim($GLOBALS['request']['filename']);
			
			//logutils::log_str($filename);
			
			$dir = dirname($filename);
			if (!is_dir($dir)) { 
				mkpathA($dir);
			}
			
			if (saveFile($_FILES['upload_img']['tmp_name'],$filename)){	
				$root['status'] = 1;	
			}else{
				$root['status'] = 0;	
			}
		}else{
			$root['status'] = 0;
		}	
		//logutils::log_obj($root);
	
		output($root);	
	}
}	
?>