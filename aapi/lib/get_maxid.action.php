<?php
class get_maxid{
	public function index()
	{		
		$table = strim($GLOBALS['request']['table']);
		$idfield = strim($GLOBALS['request']['idfield']);
		
		$maxid = -1;
		$sql = "select max(".$idfield.") from ".$GLOBALS['ecs']->table($table);
		$maxid = $GLOBALS['db']->getOne( $sql );
		if ($maxid == 0 or empty($maxid))
		  $maxid = 1;		
		$root['maxid'] = $maxid;
		output($root);	
	}
}	
?>