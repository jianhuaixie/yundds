<?php 
error_reporting(0);
if (!defined('IN_ECS'))
{
    define('IN_ECS', true);
}

header("Content-Type:text/html; charset=utf-8");

//file_put_contents('log_post.txt',print_r($_POST,true));
//@set_magic_quotes_runtime (0);
define('MAGIC_QUOTES_GPC',get_magic_quotes_gpc()?True:False);

define( "AS_LOG_DIR", "./logs/" );
define( "AS_DEBUG", true );

require './lib/log_utils.php';
//logutils::log_obj($_REQUEST);
//logutils::log_obj(MAGIC_QUOTES_GPC);

require('../includes/lib_common.php');
//logutils::log_str('======1======');
require './lib/aapi_init.php';
//logutils::log_str('======2======');
require './lib/functions.php';

define('MB_CONV_ENCODE',function_exists('mb_convert_encoding')?True:False);

if (isset($_REQUEST['i_type']))
{
	$i_type = intval($_REQUEST['i_type']);
}



if ($i_type == 1)
{
	$request = $_REQUEST;
}
else if ($i_type == 2){
	//logutils::log_obj($_REQUEST);
	$json = base64_decode($_REQUEST['requestData']);
	//logutils::log_obj($json);
	$request = json_decode($json,1);
	//logutils::log_obj($request);
}else if ($i_type == 3){
	//logutils::log_obj($_REQUEST);
	if (MAGIC_QUOTES_GPC)
		$json = stripslashes($_REQUEST['requestData']);
	else	
		$json = $_REQUEST['requestData'];
	//logutils::log_obj($json);
	
	//echo '----------1--------<br>';
	//print_r(json_decode($json,1));
	//echo '----------2--------<br>';
	//exit;
	/*
	logutils::log_str('======json_decode a-1======');	
	
	logutils::log_obj(json_decode($json,1));
	
	logutils::log_str('======json_decode a-2======');
	
	logutils::log_str('======json_decode2-1======');	
	logutils::log_obj(json_decode2($json));
	logutils::log_str('======json_decode2-2======');	
	*/
	$request = json_decode($json,1);
	
}
//exit;

//logutils::log_obj($_REQUEST);

if (EC_CHARSET == 'gbk'){
	utf82gbk($request);
}

//logutils::log_obj($request);

//filter_request($request);

//logutils::log_obj($request);
//logutils::log_str(print_r($request,true));

$class = strtolower(strim($request['act']));
define('ACT',$class); //act常量
define('ACT_INDEX',intval($request['act_index']));//回调下标

	
	$username = strim($request['username']);//用户名或邮箱
	$password = strim($request['password']);//密码
	
	check_login($username,$password);
	//logutils::log_obj($GLOBALS['user_info']);
	
	$user_id = intval($GLOBALS['user_info']['user_id']);
	if ($user_id == 0){
		output(array());
	}

	//logutils::log_obj($request);
	//公共初始化
	if(file_exists("./lib/".$class.".action.php"))
	{	
		require_once "./lib/".$class.".action.php";			
		if(class_exists($class))
		{
			$obj = new $class;		
			if(method_exists($obj,"index"))
			{
				$obj->index();
			}
			else
			{
				header("Content-Type:text/html; charset=utf-8");
				exit("Hack attemp!");
			}
		}
		else
		{
			header("Content-Type:text/html; charset=utf-8");
			exit("Hack attemp!");
		}
	}
	else
	{
		header("Content-Type:text/html; charset=utf-8");
		exit("Hack attemp!".ACT);
	}

?>