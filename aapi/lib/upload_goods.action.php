<?php
class upload_goods{
	public function index()
	{		
	
		$list = $GLOBALS['request']['list'];
		//logutils::log_obj($list);
		$root = array();
		foreach ( $list as $goods ){
			//logutils::log_obj($goods);
			$root['list'][] = $this->up_goods($goods);
		}
		//logutils::log_obj($root);
		output($root);	
	}
	
	function up_goods($goods){
		$goods_id = intval($goods['goods_id']);		
		$data_goods = $goods['data_goods'];
		$data_goods_article = $goods['data_goods_article'];
		$data_goods_attr = $goods['data_goods_attr'];
		$data_goods_cat = $goods['data_goods_cat'];
		$data_goods_gallery = $goods['data_goods_gallery'];
		$data_group_goods = $goods['data_group_goods'];
		$data_link_goods = $goods['data_link_goods'];
		$data_member_price = $goods['data_member_price'];
		$data_volume_price = $goods['data_volume_price'];
		$data_products = $goods['data_products'];		
		$syncfield = strim($goods['syncfield']);
		
		$status = uploadGoods($goods_id, 		
							$data_goods, 		
							$data_goods_article,
							$data_goods_attr,
							$data_goods_cat,
							$data_goods_gallery,
							$data_group_goods, 
							$data_link_goods,
							$data_member_price,
							$data_volume_price,
							$data_products,
							$syncfield);
		$root = array();					
		$root['goods_id'] = $goods_id;	
		if ($status === 'true'){
			$root['status'] = 1;
			$root['error'] = '';			
		}else{
			$root['status'] = 0;
			$root['error'] = $status;	
		}
				
		return $root;					
	}
}	
?>