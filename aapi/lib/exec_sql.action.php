<?php
class exec_sql{
	public function index()
	{		
		$sql_list = strim($GLOBALS['request']['sql_list']);
		$clear_cache = $GLOBALS['request']['clear_cache'];
		
	   $sql_list = explode (";", $sql_list);
	   
	   //logutils::log_obj( $sql_list );
	   
	   foreach ( $sql_list as $sql ) {
	   	 //logutils::log_str( $sql );
		 $sync_item = array();
		 $sync_item['succ'] = $GLOBALS['db']->query($sql, 'SILENT');
		 if ($sync_item['succ'] == false){
		 	$sync_item['data'] = $sql; 
		 	$sync_item['errmsg'] = $GLOBALS['db']->error();
		 	$syncitems[] = $sync_item;
		 	break;
		 }	
		 $syncitems[] = $sync_item;	   		
	   }
	   
	   if ($clear_cache == true){
	     clear_cache_files();
	   }
	   
	   
	   $root = array(
			"succ" => true,
			"items" => $syncitems
			);
			
	
		output($root);	
	}
}	
?>