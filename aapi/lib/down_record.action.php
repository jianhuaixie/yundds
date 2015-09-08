<?php
class down_record{
	public function index()
	{		
		$sql = trim($GLOBALS['request']['sql']);
		//logutils::log_str($sql);
		$sql = base64_decode($sql);
		//logutils::log_str($sql);
		//$sql = "select goods_name, goods_sn from ecs_goods where 1=1  limit 2,1";		
		$root['list'] = $GLOBALS['db']->getAll($sql);
		//header("Content-Type:text/html; charset=gbk");
		//print_r($root['list']);
		//exit;
		output($root);	
	}
}	
?>