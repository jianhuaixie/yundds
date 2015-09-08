<?php

/**
 * ECSHOP 供应商列表
 * ============================================================================
 * ecshop 模板堂 
 * @author: Leah 
 * @since: 2013/10/12
 */
define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require(dirname(__FILE__) . '/includes/lib_seller_store.php');

$act = !isset($_REQUEST['act']) ? 'info' : $_REQUEST['act'];
assign_template();
/**
 * 商家店铺页面
 */
if($act == 'info') {
	
	$smarty->assign('store',$store);
	$smarty->assign('store_slide',get_store_slide($store['seller_id']));
	$smarty->assign('store_windows',get_store_window($store['seller_id'],$store['seller_theme']));
	$smarty->assign('store_nav',get_store_nav($store['seller_id']));
	$smarty->assign('store_cate',get_store_cat(0,$store['seller_id'],$store_id));
	//店铺热销排行
	$top_goods=get_seller_top10($store['seller_id']);
	$smarty->assign('top_goods',$top_goods);
    $smarty->display($store['seller_theme'].'/seller_store.dwt');
}

?>