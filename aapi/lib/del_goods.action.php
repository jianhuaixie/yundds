<?php
class del_goods{
	public function index()
	{		
		
		logutils::log_str(print_r($GLOBALS['request'],true));
		
		$goods_ids = strim($GLOBALS['request']['goods_ids']);
		
		$root = drop_goods($goods_ids);
		//logutils::log_str(print_r($root,true));
		//$sql = "select id,parent_id,code,type,store_range,store_dir, value as avalue, sort_order from ecs_shop_config";		
		//$root['list'] = $GLOBALS['db']->getAll($sql);
		//logutils::log_str(print_r($root,true));
		output($root);	
	}
}	
?>