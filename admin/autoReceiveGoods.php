<?php
#!/usr/bin/php -q
/**
 * ECSHOP 超过10天就自动接收的程序
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: goods.php 17217 2011-01-19 06:29:08Z liubo $
*/

define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');

	$time = 10*24*60*60;//十天时间
	$time1=time();//当前时间
	//查出所有未确认收货的订单，时间超过10天的，自动修改收货状态为已收货
	$sql = "SELECT order_id FROM " . $ecs->table('order_info') .
                " WHERE order_status = 0 and ".$time1." - shipping_time > " .$time;
    $res=$db->getAll($sql);
	for($i=0;$i<count($res);$i++){
		$sql2='update '.$ecs->table('order_info').' set order_status = 1 where order_id='.$res[$i]['order_id'];
		$db->query($sql2);
	}
	$res2=$db->getAll($sql);
	var_dump($res2);