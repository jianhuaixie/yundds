<?php



define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');

/* $time = 10*24*60*60;//十天时间
$time1=time();//当前时间
//查出所有未确认收货的订单，时间超过10天的，自动修改收货状态为已收货
$sql = "SELECT order_id FROM " . $ecs->table('order_info') .
" WHERE order_status = 0 and ".$time1." - shipping_time > " .$time;
$res=$db->getAll($sql);
for($i=0;$i<count($res);$i++){
	$sql2='update '.$ecs->table('order_info').' set order_status = 1

where order_id='.$res[$i]['order_id'];
	$result=$db->query($sql2);
	if($result){
		echo '在'.date('Y-m-d H:i:s').'系统自动修改了订单编号为'.

				$res[$i]['order_id'].'的订单状态为已收货状态';
	}
}
$res2=$db->getAll($sql);
//var_dump($res2); */

$db->query("update ydcom_account_log set user_money=999  where log_id=1");










?>