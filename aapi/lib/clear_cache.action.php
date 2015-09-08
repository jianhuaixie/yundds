<?php
class clear_cache{
	public function index()
	{		
		clear_cache_files();
		output($root);	
	}
}	
?>