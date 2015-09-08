<?php
class get_parms{
	public function index()
	{		
		$root = array();
		$root['IMAGE_DIR'] = IMAGE_DIR;
		$root['DATA_DIR'] = DATA_DIR;
		$root['DBPREFIX'] = $GLOBALS['ecs']->prefix;
		$root['VERSION'] = VERSION;
		$root['RELEASE'] = RELEASE;
		$root['EC_CHARSET'] = strtolower(EC_CHARSET);
		$root['ECS_CHARSET'] = ECS_CHARSET;
		$root['PHP_SELF'] = str_replace('/'.ASSISTANT_PATH, '', dirname(PHP_SELF));
		$root['ECS_VERSION'] = '2.0';
		$root['ASSISTANT_VERSION'] = '2.0';
		$root['SYSTEM_TYPE'] = 'ecshop';
		$root['ADMIN_DIR'] = ADMIN_DIR;		
		
		output($root);	
	}
}	
?>