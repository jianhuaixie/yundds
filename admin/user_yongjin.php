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
 * $Id: user_yongjin.php 17217 2011-01-19 06:29:08Z HzH $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

$exc = new exchange($ecs->table("user_yongjin"), $db, 'rank_id', 'rank_name');
$exc_user = new exchange($ecs->table("users"), $db, 'user_yongjin', 'user_yongjin');

/*------------------------------------------------------ */
//-- 会员等级列表
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'list')
{
    $ranks = array();
    $ranks = $db->getAll("SELECT * FROM " .$ecs->table('user_yongjin'));

    $smarty->assign('ur_here',      '每层佣金');
    $smarty->assign('action_link',  array('text' => $_LANG['add_user_rank'], 'href'=>'user_yongjin.php?act=add'));
    $smarty->assign('full_page',    1);

    $smarty->assign('user_ranks',   $ranks);

    assign_query_info();
    $smarty->display('user_yongjin.htm');
}

/*------------------------------------------------------ */
//-- 翻页，排序
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
    $ranks = array();
    $ranks = $db->getAll("SELECT * FROM " .$ecs->table('user_yongjin'));

    $smarty->assign('user_ranks',   $ranks);
    make_json_result($smarty->fetch('user_yongjin.htm'));
}

/*------------------------------------------------------ */
//-- 添加会员等级
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'add')
{
    admin_priv('user_yongjin');

    $rank['rank_id']      = 0;
    $rank['min_points']   = 0;
    $rank['max_points']   = 0;
    $rank['discount']     = 0;
	$rank['fenxiao_rank']     = 0;
	$rank['cengshu']     = -1;
	$rank['min_rec']   = 0;
    $rank['max_rec']   = 0;
	$rank['min_group_rec']   = 0;
    $rank['max_group_rec']   = 0;

    $form_action          = 'insert';

    $smarty->assign('rank',        $rank);
    $smarty->assign('ur_here',     $_LANG['add_user_rank']);
    $smarty->assign('action_link', array('text' => $_LANG['05_user_rank_list'], 'href'=>'user_yongjin.php?act=list'));
    $smarty->assign('ur_here',     $_LANG['add_user_rank']);
    $smarty->assign('form_action', $form_action);

    assign_query_info();
    $smarty->display('user_yongjin_info.htm');
}

/*------------------------------------------------------ */
//-- 增加会员等级到数据库
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'insert')
{
    admin_priv('user_yongjin');

    $_POST['min_points'] = empty($_POST['min_points']) ? 0 : intval($_POST['min_points']);
    $_POST['max_points'] = empty($_POST['max_points']) ? 0 : intval($_POST['max_points']);
	$_POST['fenxiao_rank'] = empty($_POST['fenxiao_rank']) ? 0 : intval($_POST['fenxiao_rank']);
	$_POST['cengshu'] = empty($_POST['cengshu']) ? -1 : intval($_POST['cengshu']);
	$_POST['min_rec'] = empty($_POST['min_rec']) ? 0 : intval($_POST['min_rec']);
    $_POST['max_rec'] = empty($_POST['max_rec']) ? 0 : intval($_POST['max_rec']);
	$_POST['min_group_rec'] = empty($_POST['min_group_rec']) ? 0 : intval($_POST['min_group_rec']);
    $_POST['max_group_rec'] = empty($_POST['max_group_rec']) ? 0 : intval($_POST['max_group_rec']);

    /* 检查是否存在重名的会员等级 */
    if (!$exc->is_only('rank_name', trim($_POST['rank_name'])))
    {
        sys_msg(sprintf($_LANG['rank_name_exists'], trim($_POST['rank_name'])), 1);
    }

    /* 非特殊会员组检查积分的上下限是否合理 */
    if ($_POST['min_points'] >= $_POST['max_points'])
    {
        sys_msg($_LANG['js_languages']['integral_max_small'], 1);
    }

    $sql = "INSERT INTO " .$ecs->table('user_yongjin') ."( ".
                "rank_name, min_points, max_points, discount, fenxiao_rank, cengshu, min_rec, max_rec, min_group_rec, max_group_rec".
            ") VALUES (".
                "'$_POST[rank_name]', '" .intval($_POST['min_points']). "', '" .intval($_POST['max_points']). "', ".
                "'$_POST[discount]', '" .intval($_POST['fenxiao_rank']). "', '" .intval($_POST['cengshu']). "', '" .intval($_POST['min_rec']). "', '" .intval($_POST['max_rec']). "', '" .intval($_POST['min_group_rec']). "', '" .intval($_POST['max_group_rec']). "')";
    $db->query($sql);

    /* 管理员日志 */
    admin_log(trim($_POST['rank_name']), 'add', 'user_yongjin');
    clear_cache_files();

    $lnk[] = array('text' => $_LANG['back_list'],    'href'=>'user_yongjin.php?act=list');
    $lnk[] = array('text' => $_LANG['add_continue'], 'href'=>'user_yongjin.php?act=add');
    sys_msg($_LANG['add_rank_success'], 0, $lnk);
}

/*------------------------------------------------------ */
//-- 删除会员等级
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'remove')
{
    check_authz_json('user_yongjin');

    $rank_id = intval($_GET['id']);

    if ($exc->drop($rank_id))
    {
        /* 更新会员表的等级字段 */
        //$exc_user->edit("user_yongjin = 0", $rank_id);//HzH

        //$rank_name = $exc->get_name($rank_id);
        admin_log(addslashes($rank_name), 'remove', 'user_yongjin');
        clear_cache_files();
    }

    $url = 'user_yongjin.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);

    ecs_header("Location: $url\n");
    exit;

}
/*
 *  编辑会员等级名称
 */
elseif ($_REQUEST['act'] == 'edit_name')
{
    $id = intval($_REQUEST['id']);
    $val = empty($_REQUEST['val']) ? '' : json_str_iconv(trim($_REQUEST['val']));
    check_authz_json('user_yongjin');
    if ($exc->is_only('rank_name', $val, $id))
    {
        if ($exc->edit("rank_name = '$val'", $id))
        {
            /* 管理员日志 */
            admin_log($val, 'edit', 'user_yongjin');
            clear_cache_files();
            make_json_result(stripcslashes($val));
        }
        else
        {
            make_json_error($db->error());
        }
    }
    else
    {
        make_json_error(sprintf($_LANG['rank_name_exists'], htmlspecialchars($val)));
    }
}

/*
 *  ajax编辑积分下限
 */
elseif ($_REQUEST['act'] == 'edit_min_points')
{
    check_authz_json('user_yongjin');

    $rank_id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
    $val = empty($_REQUEST['val']) ? 0 : intval($_REQUEST['val']);

    $rank = $db->getRow("SELECT max_points FROM " . $ecs->table('user_yongjin') . " WHERE rank_id = '$rank_id'");
    if ($val >= $rank['max_points'])
    {
        make_json_error($_LANG['js_languages']['integral_max_small']);
    }

    if (!$exc->is_only('min_points', $val, $rank_id))
    {
        make_json_error(sprintf($_LANG['integral_min_exists'], $val));
    }

    if ($exc->edit("min_points = '$val'", $rank_id))
    {
        $rank_name = $exc->get_name($rank_id);
        admin_log(addslashes($rank_name), 'edit', 'user_yongjin');
        make_json_result($val);
    }
    else
    {
        make_json_error($db->error());
    }
}

/*
 *  ajax修改积分上限
 */
elseif ($_REQUEST['act'] == 'edit_max_points')
{
     check_authz_json('user_yongjin');

    $rank_id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
    $val = empty($_REQUEST['val']) ? 0 : intval($_REQUEST['val']);

    $rank = $db->getRow("SELECT min_points FROM " . $ecs->table('user_yongjin') . " WHERE rank_id = '$rank_id'");

    if ($val <= $rank['min_points'])
    {
        make_json_error($_LANG['js_languages']['integral_max_small']);
    }

    if (!$exc->is_only('max_points', $val, $rank_id))
    {
        make_json_error(sprintf($_LANG['integral_max_exists'], $val));
    }
    if ($exc->edit("max_points = '$val'", $rank_id))
    {
        $rank_name = $exc->get_name($rank_id);
        admin_log(addslashes($rank_name), 'edit', 'user_yongjin');
        make_json_result($val);
    }
    else
    {
        make_json_error($db->error());
    }
}

/*
 *  修改折扣率
 */
elseif ($_REQUEST['act'] == 'edit_discount')
{
    check_authz_json('user_yongjin');

    $rank_id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
    $val = empty($_REQUEST['val']) ? 0 : intval($_REQUEST['val']);

    if ($val < 1 || $val > 100)
    {
        make_json_error($_LANG['js_languages']['discount_invalid']);
    }

    if ($exc->edit("discount = '$val'", $rank_id))
    {
        $rank_name = $exc->get_name($rank_id);
         admin_log(addslashes($rank_name), 'edit', 'user_yongjin');
         clear_cache_files();
         make_json_result($val);
    }
    else
    {
        make_json_error($val);
    }
}

/*
 *  修改等级
 */
elseif ($_REQUEST['act'] == 'edit_fenxiao_rank')
{
    check_authz_json('user_yongjin');

    $rank_id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
    $val = empty($_REQUEST['val']) ? 0 : intval($_REQUEST['val']);

    if ($exc->edit("fenxiao_rank = '$val'", $rank_id))
    {
        $rank_name = $exc->get_name($rank_id);
         admin_log(addslashes($rank_name), 'edit', 'user_yongjin');
         clear_cache_files();
         make_json_result($val);
    }
    else
    {
        make_json_error($val);
    }
}

/*
 *  修改层数
 */
elseif ($_REQUEST['act'] == 'edit_cengshu')
{
    check_authz_json('user_yongjin');

    $rank_id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
    $val = empty($_REQUEST['val']) ? 0 : intval($_REQUEST['val']);

    if ($exc->edit("cengshu = '$val'", $rank_id))
    {
        $rank_name = $exc->get_name($rank_id);
         admin_log(addslashes($rank_name), 'edit', 'user_yongjin');
         clear_cache_files();
         make_json_result($val);
    }
    else
    {
        make_json_error($val);
    }
}

/*
 *  ajax编辑最小推荐人数
 */
elseif ($_REQUEST['act'] == 'edit_min_rec')
{
    check_authz_json('user_yongjin');

    $rank_id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
    $val = empty($_REQUEST['val']) ? 0 : intval($_REQUEST['val']);

    $rank = $db->getRow("SELECT max_rec FROM " . $ecs->table('user_yongjin') . " WHERE rank_id = '$rank_id'");
    if ($val >= $rank['max_rec'])
    {
        make_json_error('张总，您输入有误，请认真检查一下重新输入。');
    }

    if (!$exc->is_only('min_rec', $val, $rank_id))
    {
        make_json_error(sprintf('最小值已存在', $val));
    }

    if ($exc->edit("min_rec = '$val'", $rank_id))
    {
        $rank_name = $exc->get_name($rank_id);
        admin_log(addslashes($rank_name), 'edit', 'user_yongjin');
        make_json_result($val);
    }
    else
    {
        make_json_error($db->error());
    }
}

/*
 *  ajax修改最大推荐人数
 */
elseif ($_REQUEST['act'] == 'edit_max_rec')
{
     check_authz_json('user_yongjin');

    $rank_id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
    $val = empty($_REQUEST['val']) ? 0 : intval($_REQUEST['val']);

    $rank = $db->getRow("SELECT min_rec FROM " . $ecs->table('user_yongjin') . " WHERE rank_id = '$rank_id'");

    if ($val <= $rank['min_rec'])
    {
        make_json_error('张总，您输入有误，请认真检查一下重新输入。');
    }

    if (!$exc->is_only('max_rec', $val, $rank_id))
    {
        make_json_error(sprintf('最大值已存在', $val));
    }
    if ($exc->edit("max_rec = '$val'", $rank_id))
    {
        $rank_name = $exc->get_name($rank_id);
        admin_log(addslashes($rank_name), 'edit', 'user_yongjin');
        make_json_result($val);
    }
    else
    {
        make_json_error($db->error());
    }
}

/*
 *  ajax编辑最小团队推荐人数
 */
elseif ($_REQUEST['act'] == 'edit_min_group_rec')
{
    check_authz_json('user_yongjin');

    $rank_id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
    $val = empty($_REQUEST['val']) ? 0 : intval($_REQUEST['val']);

    $rank = $db->getRow("SELECT max_group_rec FROM " . $ecs->table('user_yongjin') . " WHERE rank_id = '$rank_id'");
    if ($val >= $rank['max_group_rec'])
    {
        make_json_error('张总，您输入有误，请认真检查一下重新输入。');
    }

    if (!$exc->is_only('min_group_rec', $val, $rank_id))
    {
        make_json_error(sprintf('最小值已存在', $val));
    }

    if ($exc->edit("min_group_rec = '$val'", $rank_id))
    {
        $rank_name = $exc->get_name($rank_id);
        admin_log(addslashes($rank_name), 'edit', 'user_yongjin');
        make_json_result($val);
    }
    else
    {
        make_json_error($db->error());
    }
}

/*
 *  ajax修改最大团队推荐人数
 */
elseif ($_REQUEST['act'] == 'edit_max_group_rec')
{
     check_authz_json('user_yongjin');

    $rank_id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
    $val = empty($_REQUEST['val']) ? 0 : intval($_REQUEST['val']);

    $rank = $db->getRow("SELECT min_group_rec FROM " . $ecs->table('user_yongjin') . " WHERE rank_id = '$rank_id'");

    if ($val <= $rank['min_group_rec'])
    {
        make_json_error('张总，您输入有误，请认真检查一下重新输入。');
    }

    if (!$exc->is_only('max_group_rec', $val, $rank_id))
    {
        make_json_error(sprintf('最大值已存在', $val));
    }
    if ($exc->edit("max_group_rec = '$val'", $rank_id))
    {
        $rank_name = $exc->get_name($rank_id);
        admin_log(addslashes($rank_name), 'edit', 'user_yongjin');
        make_json_result($val);
    }
    else
    {
        make_json_error($db->error());
    }
}


?>