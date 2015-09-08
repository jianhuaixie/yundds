<?php
class upload_record{
	public function index()
	{		
		
		$table = strim($GLOBALS['request']['table']);
		$idfields = strim($GLOBALS['request']['idfields']);
		$syncfield = strim($GLOBALS['request']['syncfield']);
		
		$list = $GLOBALS['request']['list'];
		
		//logutils::log_str(print_r($list,true));
		
		$root = uploadRecord2($list, $table, $idfields, $syncfield);
		
		//logutils::log_str(print_r($root,true));
		//$sql = "select id,parent_id,code,type,store_range,store_dir, value as avalue, sort_order from ecs_shop_config";		
		//$root['list'] = $GLOBALS['db']->getAll($sql);
		logutils::log_str(print_r($root,true));
		output($root);	
	}
}	
?>