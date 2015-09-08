<?php
class get_goods{
	public function index()
	{		
		$goods_id = strim($GLOBALS['request']['goods_id']);
		$goodsFields = strim($GLOBALS['request']['goodsFields']);
		
//logutils::log_str( "downloadGoods2: goods" );
		$sync_item = array( );
		//logutils::log_str( "sql:11" );
		$sync_item['table'] = 'goods';
		//logutils::log_obj( $sync_item );
	    $sql = "select ".$goodsFields." from ".$GLOBALS['ecs']->table('goods')." where goods_id=".$goods_id;
	    //logutils::log_str( "sql:".$sql );	
		$sync_item['data'] = $GLOBALS['db']->getAll($sql);
		$syncitems[] = $sync_item;
		
		//logutils::log_str( "downloadGoods: goods_article" );
		$sync_item = array( );
		$sync_item['table'] = 'goods_article';		
	    $sql = "select goods_id, article_id, admin_id from ".$GLOBALS['ecs']->table('goods_article')." where goods_id=".$goods_id;	
		$sync_item['data'] = $GLOBALS['db']->getAll($sql);	
		$syncitems[] = $sync_item;

		//logutils::log_str( "downloadGoods: goods_attr" );
		$sync_item = array( );
		$sync_item['table'] = 'goods_attr';		
	    $sql = "select goods_attr_id, goods_id, attr_id, attr_value, attr_price from ".$GLOBALS['ecs']->table('goods_attr')." where goods_id=".$goods_id;	
		$sync_item['data'] = $GLOBALS['db']->getAll($sql);	
		$syncitems[] = $sync_item;

		//logutils::log_str( "downloadGoods: goods_cat" );
		$sync_item = array( );
		$sync_item['table'] = 'goods_cat';		
	    $sql = "select goods_id, cat_id from ".$GLOBALS['ecs']->table('goods_cat')." where goods_id=".$goods_id;	
		$sync_item['data'] = $GLOBALS['db']->getAll($sql);	
		$syncitems[] = $sync_item;

		//logutils::log_str( "downloadGoods: goods_gallery" );
		$sync_item = array( );
		$sync_item['table'] = 'goods_gallery';		
	    $sql = "select goods_id, img_url,img_desc,thumb_url,img_original from ".$GLOBALS['ecs']->table('goods_gallery')." where goods_id=".$goods_id." order by img_id";	
		$sync_item['data'] = $GLOBALS['db']->getAll($sql);	
		$syncitems[] = $sync_item;

		//logutils::log_str( "downloadGoods: group_goods" );
		$sync_item = array( );
		$sync_item['table'] = 'group_goods';		
	    $sql = "select parent_id, goods_id, goods_price, admin_id from ".$GLOBALS['ecs']->table('group_goods')." where parent_id=".$goods_id;	
		$sync_item['data'] = $GLOBALS['db']->getAll($sql);	
		$syncitems[] = $sync_item;

		//logutils::log_str( "downloadGoods: link_goods" );
		$sync_item = array( );
		$sync_item['table'] = 'link_goods';		
	    $sql = "select goods_id, link_goods_id, is_double, admin_id from ".$GLOBALS['ecs']->table('link_goods')." where goods_id=".$goods_id;	
		$sync_item['data'] = $GLOBALS['db']->getAll($sql);	
		$syncitems[] = $sync_item;	

		//logutils::log_str( "downloadGoods: member_price" );
		$sync_item = array( );
		$sync_item['table'] = 'member_price';		
	    $sql = "select goods_id, user_rank, user_price from ".$GLOBALS['ecs']->table('member_price')." where goods_id=".$goods_id;	
		$sync_item['data'] = $GLOBALS['db']->getAll($sql);	
		$syncitems[] = $sync_item;	
		
		if (!preg_match('/^(v2.5.0|v2.5.1|v2.6.0|v2.6.1)$/i',VERSION)){
			$sync_item = array( );
			$sync_item['table'] = 'volume_price';		
			$sql = "select price_type, goods_id, volume_number, volume_price from ".$GLOBALS['ecs']->table('volume_price')." where goods_id=".$goods_id;	
			$sync_item['data'] = $GLOBALS['db']->getAll($sql);	
			$syncitems[] = $sync_item;
		}	

		if (!preg_match('/^(v2.5.0|v2.5.1|v2.6.0|v2.6.1|v2.6.2|v2.7.0|v2.7.1)$/i',VERSION)){
			$sync_item = array( );
			$sync_item['table'] = 'products';		
			$sql = "select product_id, goods_id, goods_attr, product_sn, product_number from ".$GLOBALS['ecs']->table('products')." where goods_id=".$goods_id;	
			$sync_item['data'] = $GLOBALS['db']->getAll($sql);	
			$syncitems[] = $sync_item;
		}		
		//logutils::log_str( "syncitems" );
		//logutils::log_obj( $syncitems );
		
		$pack = array(
			"goods_id" =>$goods_id,
			"succ" => true,
			"items" => $syncitems
		);
		
		$root['pack'] = $pack;
		output($root);	
	}
}	
?>