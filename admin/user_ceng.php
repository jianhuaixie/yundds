<?php

/**
 * ECSHOP 会员等级管理程序
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: HzH $
 * $Id: user_ceng.php 17217 2011-01-19 06:29:08Z HzH $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

$exc = new exchange($ecs->table("user_ceng"), $db, 'rank_id', 'rank_id');
$exc_user = new exchange($ecs->table("users"), $db, 'user_ceng', 'user_ceng');

/*------------------------------------------------------ */
//-- 会员等级列表
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'list')
{
    $ranks = array();
    $ranks = $db->getAll("SELECT * FROM " .$ecs->table('user_ceng'));

    $smarty->assign('ur_here',      '等级层数');
    $smarty->assign('action_link',  array('text' => $_LANG['add_user_rank'], 'href'=>'user_ceng.php?act=add'));
    $smarty->assign('full_page',    1);

    $smarty->assign('user_ranks',   $ranks);

    assign_query_info();
    $smarty->display('user_ceng.htm');
}

/*------------------------------------------------------ */
//-- 翻页，排序
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
    $ranks = array();
    $ranks = $db->getAll("SELECT * FROM " .$ecs->table('user_ceng'));

    $smarty->assign('user_ranks',   $ranks);
    make_json_result($smarty->fetch('user_ceng.htm'));
}

/*------------------------------------------------------ */
//-- 添加会员等级
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'add')
{
    admin_priv('user_ceng');

    $rank['rank_id']      = 0;
    $rank['discount']     = 0;
	$rank['cengshu']     = 0;
	
    $form_action          = 'insert';

    $smarty->assign('rank',        $rank);
    $smarty->assign('ur_here',     $_LANG['add_user_rank']);
    $smarty->assign('action_link', array('text' => $_LANG['05_user_rank_list'], 'href'=>'user_ceng.php?act=list'));
    $smarty->assign('ur_here',     $_LANG['add_user_rank']);
    $smarty->assign('form_action', $form_action);

    assign_query_info();
    $smarty->display('user_ceng_info.htm');
}

/*------------------------------------------------------ */
//-- 增加会员等级到数据库
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'insert')
{
    admin_priv('user_ceng');

	$_POST['cengshu'] = empty($_POST['cengshu']) ? 0 : intval($_POST['cengshu']);//hzh

    $sql = "INSERT INTO " .$ecs->table('user_ceng') ."( ".
                "discount, cengshu".
            ") VALUES (".
                "'$_POST[discount]', '" .intval($_POST['cengshu']). "')";//hzh
    $db->query($sql);

    /* 管理员日志 */
    admin_log(trim($_POST['rank_name']), 'add', 'user_ceng');
    clear_cache_files();

    $lnk[] = array('text' => $_LANG['back_list'],    'href'=>'user_ceng.php?act=list');
    $lnk[] = array('text' => $_LANG['add_continue'], 'href'=>'user_ceng.php?act=add');
    sys_msg($_LANG['add_rank_success'], 0, $lnk);
}

/*------------------------------------------------------ */
//-- 删除会员等级
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'remove')
{
    check_authz_json('user_ceng');

    $rank_id = intval($_GET['id']);

    if ($exc->drop($rank_id))
    {
        /* 更新会员表的等级字段 */
        //$exc_user->edit("user_ceng = 0", $rank_id);//hzh

        //$rank_name = $exc->get_name($rank_id);
        admin_log(addslashes($rank_name), 'remove', 'user_ceng');
        clear_cache_files();
    }

    $url = 'user_ceng.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);

    ecs_header("Location: $url\n");
    exit;

}

/*
 *  修改折扣率
 */
elseif ($_REQUEST['act'] == 'edit_discount')
{
    check_authz_json('user_ceng');

    $rank_id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
    $val = empty($_REQUEST['val']) ? 0 : intval($_REQUEST['val']);

    if ($val < 1 || $val > 100)
    {
        make_json_error($_LANG['js_languages']['discount_invalid']);
    }

    if ($exc->edit("discount = '$val'", $rank_id))
    {
        $rank_name = $exc->get_name($rank_id);
         admin_log(addslashes($rank_name), 'edit', 'user_ceng');
         clear_cache_files();
         make_json_result($val);
    }
    else
    {
        make_json_error($val);
    }
}

/*
 *  修改层数 hzh
 */
elseif ($_REQUEST['act'] == 'edit_cengshu')
{
    check_authz_json('user_ceng');

    $rank_id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
    $val = empty($_REQUEST['val']) ? 0 : intval($_REQUEST['val']);

    if ($exc->edit("cengshu = '$val'", $rank_id))
    {
        $rank_name = $exc->get_name($rank_id);
         admin_log(addslashes($rank_name), 'edit', 'user_ceng');
         clear_cache_files();
         make_json_result($val);
    }
    else
    {
        make_json_error($val);
    }
}


?>