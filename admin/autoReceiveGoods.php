<?php
#!/usr/bin/php -q
/**
 * ECSHOP ����10����Զ����յĳ���
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: goods.php 17217 2011-01-19 06:29:08Z liubo $
*/

define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');

	$time = 10*24*60*60;//ʮ��ʱ��
	$time1=time();//��ǰʱ��
	//�������δȷ���ջ��Ķ�����ʱ�䳬��10��ģ��Զ��޸��ջ�״̬Ϊ���ջ�
	$sql = "SELECT order_id FROM " . $ecs->table('order_info') .
                " WHERE order_status = 0 and ".$time1." - shipping_time > " .$time;
    $res=$db->getAll($sql);
	for($i=0;$i<count($res);$i++){
		$sql2='update '.$ecs->table('order_info').' set order_status = 1 where order_id='.$res[$i]['order_id'];
		$db->query($sql2);
	}
	$res2=$db->getAll($sql);
	var_dump($res2);