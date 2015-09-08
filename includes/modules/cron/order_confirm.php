<?php
if (!defined('IN_ECS')){  
    die('Hacking attempt');  
}  
require_once(ROOT_PATH . 'includes/lib_common.php');
require_once(ROOT_PATH . 'includes/lib_order.php');
require_once(ROOT_PATH . 'languages/zh_cn/admin/affiliate_ck.php');
$cron_lang = ROOT_PATH . 'languages/' .$GLOBALS['_CFG']['lang']. '/cron/order_confirm.php';
if (file_exists($cron_lang)) {
    global $_LANG;
    include_once($cron_lang);
}
/* 模块的基本信息 安装的时候用*/
if (isset($set_modules) && $set_modules == TRUE) {
    $i = isset($modules) ? count($modules) : 0;
    /* 代码 */
    $modules[$i]['code']    = basename(__FILE__, '.php');
    /* 描述对应的语言项 */
    $modules[$i]['desc']    = 'my_cron_desc';
    /* 作者 */
    $modules[$i]['author']  = '';
    /* 网址 */
    $modules[$i]['website'] = '';
    /* 版本号 */
    $modules[$i]['version'] = '1.0.0';
    /* 配置信息 一般这一项通过serialize函数保存在cron表的中cron_config这个字段中*/
    $modules[$i]['config']  = array(
        array('name' => 'out_day', 'type' => 'text', 'value' => '30')
    );
    //name：计划任务的名称，type：类型(text,textarea,select…)，value：默认值
    return;
}

//下面是这个计划任务要执行的程序了
$time  = gmtime();
$out_day = empty($cron['out_day']) ? 30 : $cron['out_day'];
$out_time = $out_day*24*3600;

$sql="select * from ".$ecs->table('order_info')." where shipping_time < ($time-$out_time) and shipping_status=1";
$order=$db->getAll($sql);

foreach($order as $o){
  //$sql="update ".$ecs->table('order_info')." set shipping_status=2 where shipping_time < ($time-$out_time) and shipping_status=1 and order_id=$o[order_id]";
  //$db->query($sql);
  
  /* 标记订单为已收货 */  
  $update_status = update_order($o['order_id'], array('shipping_status' => SS_RECEIVED));
  
  /* 记录log */  
  $action_note = "计划任务：定期自动确定收货，订单号：".$o['order_sn']."，执行状态：".($update_status ? '成功' : '失败');  
  order_action($o['order_sn'], OS_CONFIRMED, SS_RECEIVED, PS_PAYED, $action_note, '系统');
  
  //分成
  affiliate($o['order_id']);
}

//确认收货后，自动分成
function affiliate($oid){	
    $affiliate = unserialize($GLOBALS['_CFG']['affiliate']);
    empty($affiliate) && $affiliate = array();

    $separate_by = $affiliate['config']['separate_by'];

    $row = $GLOBALS['db']->getRow("SELECT o.order_sn, o.is_separate, (o.goods_amount - o.discount) AS goods_amount, o.user_id FROM " . $GLOBALS['ecs']->table('order_info') . " o".
                    " LEFT JOIN " . $GLOBALS['ecs']->table('users') . " u ON o.user_id = u.user_id".
            " WHERE order_id = '$oid'");

    $order_sn = $row['order_sn'];

    if (empty($row['is_separate']))
    {
        $affiliate['config']['level_point_all'] = (float)$affiliate['config']['level_point_all'];
        $affiliate['config']['level_money_all'] = (float)$affiliate['config']['level_money_all'];
        if ($affiliate['config']['level_point_all'])
        {
            $affiliate['config']['level_point_all'] /= 100;
        }
        if ($affiliate['config']['level_money_all'])
        {
            $affiliate['config']['level_money_all'] /= 100;
        }
        $money = round($affiliate['config']['level_money_all'] * $row['goods_amount'],2);
        $integral = integral_to_give(array('order_id' => $oid, 'extension_code' => ''));
        $point = round($affiliate['config']['level_point_all'] * intval($integral['rank_points']), 0);

        if(empty($separate_by))
        {
            //推荐注册分成
            $num = count($affiliate['item']);
            for ($i=0; $i < $num; $i++)
            {
                $affiliate['item'][$i]['level_point'] = (float)$affiliate['item'][$i]['level_point'];
                $affiliate['item'][$i]['level_money'] = (float)$affiliate['item'][$i]['level_money'];
                if ($affiliate['item'][$i]['level_point'])
                {
                    $affiliate['item'][$i]['level_point'] /= 100;
                }
                if ($affiliate['item'][$i]['level_money'])
                {
                    $affiliate['item'][$i]['level_money'] /= 100;
                }
                $setmoney = round($money * $affiliate['item'][$i]['level_money'], 2);
                $setpoint = round($point * $affiliate['item'][$i]['level_point'], 0);
                $row = $GLOBALS['db']->getRow("SELECT o.parent_id as user_id,u.user_name FROM " . $GLOBALS['ecs']->table('users') . " o" .
                        " LEFT JOIN" . $GLOBALS['ecs']->table('users') . " u ON o.parent_id = u.user_id".
                        " WHERE o.user_id = '$row[user_id]'"
                    );
                $up_uid = $row['user_id'];
                if (empty($up_uid) || empty($row['user_name']))
                {
                    break;
                }
                else
                {
                    $info = sprintf($GLOBALS['_LANG']['separate_info'], $order_sn, $setmoney, $setpoint);
                    log_account_change($up_uid, $setmoney, 0, $setpoint, 0, $info);
                    write_affiliate_log($oid, $up_uid, $row['user_name'], $setmoney, $setpoint, $separate_by);
                }
            }
        }
        else
        {
            //推荐订单分成
            $row = $GLOBALS['db']->getRow("SELECT o.parent_id, u.user_name FROM " . $GLOBALS['ecs']->table('order_info') . " o" .
                    " LEFT JOIN" . $GLOBALS['ecs']->table('users') . " u ON o.parent_id = u.user_id".
                    " WHERE o.order_id = '$oid'"
                );
            $up_uid = $row['parent_id'];
            if(!empty($up_uid) && $up_uid > 0)
            {
                $info = sprintf($GLOBALS['_LANG']['separate_info'], $order_sn, $money, $point);
                log_account_change($up_uid, $money, 0, $point, 0, $info);
                write_affiliate_log($oid, $up_uid, $row['user_name'], $money, $point, $separate_by);
            }
            else
            {
            }
        }
        $sql = "UPDATE " . $GLOBALS['ecs']->table('order_info') .
               " SET is_separate = 1" .
               " WHERE order_id = '$oid'";
        $GLOBALS['db']->query($sql);
    }
}
//记录分成
function write_affiliate_log($oid, $uid, $username, $money, $point, $separate_by){
    $time = gmtime();
    $sql = "INSERT INTO " . $GLOBALS['ecs']->table('affiliate_log') . "( order_id, user_id, user_name, time, money, point, separate_type)".
                                                              " VALUES ( '$oid', '$uid', '$username', '$time', '$money', '$point', $separate_by)";
    if ($oid){
      $GLOBALS['db']->query($sql);
    }
}
?>