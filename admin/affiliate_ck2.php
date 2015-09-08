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

 * $Id: affiliate_ck2.php 17217 2011-01-19 06:29:08Z liubo $

 */



define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');
admin_priv('affiliate_ck2');
$timestamp = time();
$affiliate = unserialize($GLOBALS['_CFG']['affiliate']);
empty($affiliate) && $affiliate = array();
$separate_on = $affiliate['on'];


/*------------------------------------------------------ */

//-- 分成页

/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'list')
{
    $logdb = get_affiliate_ck2();
    $smarty->assign('full_page',  1);
    $smarty->assign('ur_here', $_LANG['affiliate_ck2']);
    $smarty->assign('on', $separate_on);
    $smarty->assign('logdb',        $logdb['logdb']);
    $smarty->assign('filter',       $logdb['filter']);
    $smarty->assign('record_count', $logdb['record_count']);
    $smarty->assign('page_count',   $logdb['page_count']);

    assign_query_info();
    $smarty->display('affiliate_ck_list2.htm');
}
/*------------------------------------------------------ */
//-- 分页
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
    $logdb = get_affiliate_ck2();
    $smarty->assign('logdb',        $logdb['logdb']);
    $smarty->assign('on', $separate_on);
    $smarty->assign('filter',       $logdb['filter']);
    $smarty->assign('record_count', $logdb['record_count']);
    $smarty->assign('page_count',   $logdb['page_count']);

    $sort_flag  = sort_flag($logdb['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('affiliate_ck_list2.htm'), '', array('filter' => $logdb['filter'], 'page_count' => $logdb['page_count']));
}
/*
    取消分成，不再能对该订单进行分成
*/


function get_affiliate_ck2()

{
    $affiliate = unserialize($GLOBALS['_CFG']['affiliate']);
    empty($affiliate) && $affiliate = array();
    $separate_by = $affiliate['config']['separate_by'];
    $sqladd = '';
	if (isset($_REQUEST['status']))
    {
       $sqladd = ' WHERE separate_type = ' . (int)$_REQUEST['status'];
        $filter['status'] = (int)$_REQUEST['status'];
    }
    if (isset($_REQUEST['order_sn']))
    {
        $sqladd = ' WHERE order_sn LIKE \'%' . trim($_REQUEST['order_sn']) . '%\'';
        $filter['order_sn'] = $_REQUEST['order_sn'];
    }

    $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('fenxiao_log') . "$sqladd";

    $filter['record_count'] = $GLOBALS['db']->getOne($sql);

    $logdb = array();

    /* 分页大小 */

    $filter = page_and_size($filter);


	//推荐注册分成

	$sql = "SELECT * FROM " . $GLOBALS['ecs']->table('fenxiao_log') . " $sqladd" .

			" ORDER BY order_id DESC" .

			" LIMIT " . $filter['start'] . ",$filter[page_size]";

   $query = $GLOBALS['db']->query($sql);

    while ($rt = $GLOBALS['db']->fetch_array($query))
    {
        //$rt['fukuan_time'] = local_date($GLOBALS['_CFG']['time_format'], $rt['fukuan_time']);
		$rt['fukuan_time'] = date("Y-m-d H:i:s", $rt['fencheng_time']);
		//$rt['confirm_time'] = date($GLOBALS['_CFG']['time_format'], $rt['confirm_time']);
		if($rt['confirm_time'] == 0){
			$rt['confirm_time'] = '未确认收货';
		}else{
			$rt['confirm_time'] = date($GLOBALS['_CFG']['time_format'], $rt['confirm_time']);
		}
		$logdb[] = $rt;
    }
    $arr = array('logdb' => $logdb, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
    return $arr;
	
}

/*------------------------------------------------------ */
//-- 批量导出EXCEL hzh
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'batch')
{
    admin_priv('affiliate_ck2');
    $action = isset($_POST['sel_action']) ? trim($_POST['sel_action']) : 'def';

    if (isset($_POST['checkboxes']))
    {
        switch ($action)
        {
           case 'export':
			   require(dirname(__FILE__) . '/excel_fencheng.php');
               break;

           default :
               break;
        }

        clear_cache_files();
	}
}
?>