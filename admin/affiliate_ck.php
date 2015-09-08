<?php



/**

 * ECSHOP 程序说明

 * ===========================================================

 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。

 * 网站地址: http://www.ecshop.com；

 * ----------------------------------------------------------

 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和

 * 使用；不允许对程序代码以任何形式任何目的的再发布。

 * ==========================================================

 * $Author: liubo $

 * $Id: affiliate_ck.php 17217 2011-01-19 06:29:08Z liubo $

 */



define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');
admin_priv('affiliate_ck');
$timestamp = time();
$affiliate = unserialize($GLOBALS['_CFG']['affiliate']);
empty($affiliate) && $affiliate = array();
$separate_on = $affiliate['on'];



/*------------------------------------------------------ */

//-- 分成页

/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'list')
{
    $logdb = get_affiliate_ck();
    $smarty->assign('full_page',  1);
    $smarty->assign('ur_here', $_LANG['affiliate_ck']);
    $smarty->assign('on', $separate_on);
    $smarty->assign('logdb',        $logdb['logdb']);
    $smarty->assign('filter',       $logdb['filter']);
    $smarty->assign('record_count', $logdb['record_count']);
    $smarty->assign('page_count',   $logdb['page_count']);
    if (!empty($_GET['auid']))
    {
        $smarty->assign('action_link',  array('text' => $_LANG['back_note'], 'href'=>"users.php?act=edit&id=$_GET[auid]"));
    }
    assign_query_info();
    $smarty->display('affiliate_ck_list.htm');
}
/*------------------------------------------------------ */
//-- 分页
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
    $logdb = get_affiliate_ck();
    $smarty->assign('logdb',        $logdb['logdb']);
    $smarty->assign('on', $separate_on);
    $smarty->assign('filter',       $logdb['filter']);
    $smarty->assign('record_count', $logdb['record_count']);
    $smarty->assign('page_count',   $logdb['page_count']);

    $sort_flag  = sort_flag($logdb['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('affiliate_ck_list.htm'), '', array('filter' => $logdb['filter'], 'page_count' => $logdb['page_count']));
}
/*
    取消分成，不再能对该订单进行分成
*/
elseif ($_REQUEST['act'] == 'del')
{
    $oid = (int)$_REQUEST['oid'];
    $stat = $db->getOne("SELECT is_separate FROM " . $GLOBALS['ecs']->table('order_info') . " WHERE order_id = '$oid'");
    if (empty($stat))
    {
        $sql = "UPDATE " . $GLOBALS['ecs']->table('order_info') .
               " SET is_separate = 2" .
               " WHERE order_id = '$oid'";
        $db->query($sql);
    }
    $links[] = array('text' => $_LANG['affiliate_ck'], 'href' => 'affiliate_ck.php?act=list');
    sys_msg($_LANG['edit_ok'], 0 ,$links);
}
/*
    撤销某次分成，将已分成的收回来
*/
elseif ($_REQUEST['act'] == 'rollback')
{
    $logid = (int)$_REQUEST['logid'];
    $stat = $db->getRow("SELECT * FROM " . $GLOBALS['ecs']->table('affiliate_log') . " WHERE log_id = '$logid'");
    if (!empty($stat))
    {
        if($stat['separate_type'] == 1)
        {
            //推荐订单分成
            $flag = -2;
        }
        else
        {
            //推荐注册分成
            $flag = -1;
        }
        log_account_change($stat['user_id'], -$stat['money'], 0, -$stat['point'], 0, $_LANG['loginfo']['cancel']);
        $sql = "UPDATE " . $GLOBALS['ecs']->table('affiliate_log') .
               " SET separate_type = '$flag'" .
               " WHERE log_id = '$logid'";
        $db->query($sql);
    }
    $links[] = array('text' => $_LANG['affiliate_ck'], 'href' => 'affiliate_ck.php?act=list');
    sys_msg($_LANG['edit_ok'], 0 ,$links);
}
/*

    分成

*/
elseif ($_REQUEST['act'] == 'separate')
{
    include_once(ROOT_PATH . 'includes/lib_order.php');
    require_once 'SqlHelper.php';
    $sqlhelper=new SqlHelper();
    $affiliate = unserialize($GLOBALS['_CFG']['affiliate']);
    empty($affiliate) && $affiliate = array();
    $separate_by = $affiliate['config']['separate_by'];
    $oid = (int)$_REQUEST['oid'];
    $order_id=$oid;
    //根据订单Id求买家id
    $user_id=$sqlhelper->execute_dql1("select user_id from ydcom_order_info where order_id=$order_id");
               
    //第1步查询出该笔订单的能产生的佣金
    $fencheng1=0;
    $fencheng2=0;  
    //根据order_id查表ydcom_order_goods中的goods_id
    $res0=$sqlhelper->execute_dql("select goods_id,goods_price from ydcom_order_goods where order_id=$order_id ");
    while($row0=mysql_fetch_array($res0)){
    	$goods_id=$row0[0];
    	$goods_price=$row0[1];
    	//根据goods_id查ydcom_goods中的fengcheng1,和fengcheng2;
    	$res02=$sqlhelper->execute_dql("select fencheng1,fencheng2 from ydcom_goods where goods_id=$goods_id ");
    	while($row02=mysql_fetch_array($res02)){
    		$fencheng1+=$row02[0]*$goods_price;
    		$fencheng2+=$row02[1]*$goods_price;
    	}
    }
    
    
    //模式一分成
    $i=0;
    $b1=$sqlhelper->execute_dql1("select parent_id from ydcom_users where user_id=$user_id");
    //b1就是上家id
    for(;$b1>0;){
    	$i++;
    	$c1=$sqlhelper->execute_dql1("select rank_points from ydcom_users where user_id=$b1");
    	//c1为等级积分
    	$d1=$sqlhelper->execute_dql1("select cengshu from ydcom_user_yongjin where $c1>=min_points and $c1<=max_points");
    	//d1为层数
    	if ($d1==-1){
    		//如果层数为-1，那么可享受模式一的最高层数，最高层数赋给d1
    		$d1=$sqlhelper->execute_dql1("select max(cengshu)  from ydcom_user_yongjin where cengshu");	
    	}
    	if ($d1>=$i){
    		$res6=$sqlhelper->execute_dql1("select discount  from ydcom_user_ceng where cengshu=$i");
    		//e1佣金比
    		$e1=$res6/100;
    		//f1为模式1佣金
    		$f1=$fencheng1*$e1;
    		//将分成1写入写入数据库
    		$res7=$sqlhelper->execute_dql("select user_money,user_name from ydcom_users where user_id=$b1");
    		$row7=mysql_fetch_array($res7);
    		$user_name=$row7[1];
    		$user_money=$row7[0]+$f1;
    		//分成，跟新其余额
    		$sqlhelper->execute_dql("update ydcom_users set user_money=$user_money where user_id=$b1");
    		//write_affiliate_log($oid, $up_uid, $row['user_name'], $setmoney, $setpoint, $separate_by);
    		write_affiliate_log($oid, $b1, $user_name, $f1, 0,0);
    		$time=time();
    		$sqlhelper->execute_dql("insert into ydcom_account_log(user_id,user_money,frozen_money,rank_points,pay_points,change_time,change_desc,change_type) values($b1,$f1,0,0,0,$time,'分佣金',2)");	
    		//values($b1,$f1,0,0,0,,"分佣金",2)
    		//insert into ydcom_account_log(user_id,user_money,frozen_money,rank_points,pay_points,change_time,change_desc,change_type)
    	} 
        //查询模式一最高享受的层数
        $highlayer=$sqlhelper->getmodel1_highlayer();
    	if ($highlayer<$i){
    		break;
    	}
    	$b1=$sqlhelper->execute_dql1("select parent_id from ydcom_users where user_id=$b1");
    	//b1为上家   	
    }
    

    //模式二分成
    $b2=$sqlhelper->execute_dql1("select parent_id from ydcom_users where user_id=$user_id");
    //b2就是上家id
    //$a2为买家id
    $a2=$user_id;
    for(;$b2>0;){
    	$d1=$sqlhelper->getuser_fenxiaorank($a2);
    	$d2=$sqlhelper->getuser_fenxiaorank($b2);
    	//a2为当前，b2为上家，d1为当前分销等级，d2为上家等级
    	$gomodel2_minrank=$sqlhelper->gomodel2();
    	if ($d2>$d1 && $d2>=$gomodel2_minrank){
    		//$up_commission为上家分销等级佣金比
    		$res11=$sqlhelper->execute_dql1("select discount from ydcom_user_yongjin where fenxiao_rank=$d2");
    		$up_commission=$res11/100;
    		//当前用户模式二分销等级佣金比
    		$res112=$sqlhelper->execute_dql1("select discount from ydcom_user_yongjin where fenxiao_rank=$d1");
    		$present_commission=$res112/100;
    		//canget_commission可获得的比例
    		$canget_commission=$up_commission-$present_commission;
    		//f2分销2的最终佣金
    		$f2=$fencheng2*$canget_commission;
    		//将分成2写入写入数据库
    		$res12=$sqlhelper->execute_dql("select user_money,user_name from ydcom_users where user_id=$b2");
    		$row12=mysql_fetch_array($res12);
    		$user_name=$row12[1];
    		$user_money=$row12[0]+$f2;
    		//分成，跟新其余额
    		$sqlhelper->execute_dql("update ydcom_users set user_money=$user_money where user_id=$b2");
    		//write_affiliate_log($oid, $up_uid, $row['user_name'], $setmoney, $setpoint, $separate_by);
    		write_affiliate_log($oid, $b2, $user_name, $f2, 0,0);
    		$time=time();
    		$fyj="分佣金";
    		$sqlhelper->execute_dql("insert into ydcom_account_log(user_id,user_money,frozen_money,rank_points,pay_points,change_time,change_desc,change_type) values($b2,$f2,0,0,0,$time,$fyj,2)");
    	}else {
    		break;
    	}
    	$a2=$b2;
    	//b2就是上家id
    	$b2=$sqlhelper->execute_dql1("select parent_id from ydcom_users where user_id=$a2");
    }     
    echo "恭喜分成成功";
    $sqlhelper->execute_dql("update ydcom_order_info set is_separate=1 where order_id=$order_id");
    $sqlhelper->close_connect();

    
   
    
}
function get_affiliate_ck()

{
    $affiliate = unserialize($GLOBALS['_CFG']['affiliate']);
    empty($affiliate) && $affiliate = array();
    $separate_by = $affiliate['config']['separate_by'];
    $sqladd = '';
    if (isset($_REQUEST['status']))
    {
       $sqladd = ' AND o.is_separate = ' . (int)$_REQUEST['status'];
        $filter['status'] = (int)$_REQUEST['status'];
    }
    if (isset($_REQUEST['order_sn']))
    {
        $sqladd = ' AND o.order_sn LIKE \'%' . trim($_REQUEST['order_sn']) . '%\'';
        $filter['order_sn'] = $_REQUEST['order_sn'];
    }
    if (isset($_GET['auid']))
    {
        $sqladd = ' AND a.user_id=' . $_GET['auid'];
    }
    if(!empty($affiliate['on']))
    {
        if(empty($separate_by))
        {
            //推荐注册分成
            $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('order_info') . " o".
                    " LEFT JOIN".$GLOBALS['ecs']->table('users')." u ON o.user_id = u.user_id".
                    " LEFT JOIN " . $GLOBALS['ecs']->table('affiliate_log') . " a ON o.order_id = a.order_id" .
                    " WHERE o.user_id > 0 AND (u.parent_id > 0 AND o.is_separate = 0 OR o.is_separate > 0) $sqladd";
        }
        else

        {

            //推荐订单分成

            $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('order_info') . " o".

                    " LEFT JOIN".$GLOBALS['ecs']->table('users')." u ON o.user_id = u.user_id".

                    " LEFT JOIN " . $GLOBALS['ecs']->table('affiliate_log') . " a ON o.order_id = a.order_id" .

                    " WHERE o.user_id > 0 AND (o.parent_id > 0 AND o.is_separate = 0 OR o.is_separate > 0) $sqladd";

        }

    }

    else

    {

        $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('order_info') . " o".

                " LEFT JOIN".$GLOBALS['ecs']->table('users')." u ON o.user_id = u.user_id".

                " LEFT JOIN " . $GLOBALS['ecs']->table('affiliate_log') . " a ON o.order_id = a.order_id" .

                " WHERE o.user_id > 0 AND o.is_separate > 0 $sqladd";

    }





    $filter['record_count'] = $GLOBALS['db']->getOne($sql);

    $logdb = array();

    /* 分页大小 */

    $filter = page_and_size($filter);



    if(!empty($affiliate['on']))

    {

        if(empty($separate_by))

        {

            //推荐注册分成

            $sql = "SELECT o.*, a.log_id, a.user_id as suid,  a.user_name as auser, a.money, a.point, a.separate_type,u.parent_id as up FROM " . $GLOBALS['ecs']->table('order_info') . " o".

                    " LEFT JOIN".$GLOBALS['ecs']->table('users')." u ON o.user_id = u.user_id".

                    " LEFT JOIN " . $GLOBALS['ecs']->table('affiliate_log') . " a ON o.order_id = a.order_id" .

                    " WHERE o.user_id > 0 AND (u.parent_id > 0 AND o.is_separate = 0 OR o.is_separate > 0) $sqladd".

                    " ORDER BY order_id DESC" .

                    " LIMIT " . $filter['start'] . ",$filter[page_size]";



            /*

                SQL解释：



                列出同时满足以下条件的订单分成情况：

                1、有效订单o.user_id > 0

                2、满足以下情况之一：

                    a.有用户注册上线的未分成订单 u.parent_id > 0 AND o.is_separate = 0

                    b.已分成订单 o.is_separate > 0



            */

        }

        else

        {

            //推荐订单分成

            $sql = "SELECT o.*, a.log_id,a.user_id as suid, a.user_name as auser, a.money, a.point, a.separate_type,u.parent_id as up FROM " . $GLOBALS['ecs']->table('order_info') . " o".

                    " LEFT JOIN".$GLOBALS['ecs']->table('users')." u ON o.user_id = u.user_id".

                    " LEFT JOIN " . $GLOBALS['ecs']->table('affiliate_log') . " a ON o.order_id = a.order_id" .

                    " WHERE o.user_id > 0 AND (o.parent_id > 0 AND o.is_separate = 0 OR o.is_separate > 0) $sqladd" .

                    " ORDER BY order_id DESC" .

                    " LIMIT " . $filter['start'] . ",$filter[page_size]";



            /*

                SQL解释：



                列出同时满足以下条件的订单分成情况：

                1、有效订单o.user_id > 0

                2、满足以下情况之一：

                    a.有订单推荐上线的未分成订单 o.parent_id > 0 AND o.is_separate = 0

                    b.已分成订单 o.is_separate > 0



            */

        }

    }

    else

    {

        //关闭

        $sql = "SELECT o.*, a.log_id,a.user_id as suid, a.user_name as auser, a.money, a.point, a.separate_type,u.parent_id as up FROM " . $GLOBALS['ecs']->table('order_info') . " o".

                " LEFT JOIN".$GLOBALS['ecs']->table('users')." u ON o.user_id = u.user_id".

                " LEFT JOIN " . $GLOBALS['ecs']->table('affiliate_log') . " a ON o.order_id = a.order_id" .

                " WHERE o.user_id > 0 AND o.is_separate > 0 $sqladd" .

                " ORDER BY order_id DESC" .

                " LIMIT " . $filter['start'] . ",$filter[page_size]";

    }





    $query = $GLOBALS['db']->query($sql);

    while ($rt = $GLOBALS['db']->fetch_array($query))

    {

        if(empty($separate_by) && $rt['up'] > 0)

        {

            //按推荐注册分成

            $rt['separate_able'] = 1;

        }

        elseif(!empty($separate_by) && $rt['parent_id'] > 0)

        {

            //按推荐订单分成

            $rt['separate_able'] = 1;

        }

        if(!empty($rt['suid']))

        {

            //在affiliate_log有记录

            //$rt['info'] = sprintf($GLOBALS['_LANG']['separate_info2'], $rt['suid'],  $rt['money']);
			$rt['info'] = sprintf($GLOBALS['_LANG']['separate_info2'], $rt['suid'], $rt['auser'], $rt['money'], $rt['point']);//hzh

            if($rt['separate_type'] == -1 || $rt['separate_type'] == -2)

            {

                //已被撤销

                $rt['is_separate'] = 3;

                $rt['info'] = "<s>" . $rt['info'] . "</s>";

            }

        }

        $logdb[] = $rt;

    }
        //时间处理，
		//时间处理，
		//时间处理，
		//时间处理，
		//时间处理，
		
		$i=0;
		for($i;$i<count($logdb);$i++){
			
		$time=$logdb[$i]['confirm_time'];
		$time1=date('Y-m-d',$time);
		$logdb[$i]['confirm_time']=$time1;
		
		}
	
	

    $arr = array('logdb' => $logdb, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
    return $arr;
}
function write_affiliate_log($oid, $uid, $username, $money, $point, $separate_by)

{

    $time = gmtime();

    $sql = "INSERT INTO " . $GLOBALS['ecs']->table('affiliate_log') . "( order_id, user_id, user_name, time, money, point, separate_type)".

                                                              " VALUES ( '$oid', '$uid', '$username', '$time', '$money', '$point', $separate_by)";

    if ($oid)

    {

        $GLOBALS['db']->query($sql);

    }

}

?>