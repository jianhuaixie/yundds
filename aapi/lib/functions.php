<?php
//输出接口数据
function output($data)
{
	header("Content-Type:text/html; charset=utf-8");
	//header("Content-Type:text/html; charset=gbk");
	$r_type = intval($_REQUEST['r_type']);//返回数据格式类型; 0:json_encode;1:array
	$data['act'] = ACT;
	$data['act_index'] = ACT_INDEX;
	//echo EC_CHARSET."<br>";
	
	$user_id = intval($GLOBALS['user_info']['user_id']);
	if ($user_id == 0){
		$data['user_login_status'] = 0;//用户登陆状态：1:成功登陆;0：未成功登陆
	}else{
		$data['user_login_status'] = 1;//用户登陆状态：1:成功登陆;0：未成功登陆
	}
	
	//print_r($data);
	if (EC_CHARSET == 'gbk'){
		gbk2utf8($data);
	}	
	//$data['act_2'] = ACT_2;
	if ($r_type == 0)
	{
		ob_clean();
		echo json_encode($data);
	}else if ($r_type == 1)
	{
		ob_clean();
		print_r($data);
	};
	exit;
}

//将gbk转为utf8格式
function gbk2utf8(&$data) {
	foreach ( $data as $k => $v ) {
		if (is_array ( $v )) {
			gbk2utf8 ($data [$k]);
		} else {
			if(MB_CONV_ENCODE) {
				$encode = mb_detect_encoding($v, array("ASCII","UTF-8","GB2312","GBK","BIG5"));
				//echo $encode;
				if ($encode != 'UTF-8'){
					$data [$k] = mb_convert_encoding($v, 'UTF-8', 'GBK');
				}		   
			}else{
				$data[$k] = iconv('GBK', 'UTF-8', $v);
			}		
		}
	}	
}

//将utf8转为gbk格式
function utf82gbk(&$data) {
	foreach ( $data as $k => $v ) {
		if (is_array ($data[$k])) {
			utf82gbk ($data[$k]);
		} else {
			$encode = mb_detect_encoding($v, array("ASCII","UTF-8","GB2312","GBK","BIG5"));
			if ($encode == 'UTF-8'){
				if(MB_CONV_ENCODE) {
				   $data [$k] = mb_convert_encoding($v, 'GBK', 'UTF-8');				
				}else{
					$data[$k] = iconv('UTF-8', 'GBK', $v);
				}
			}			
		}
	}	
}

//过滤请求
function filter_request(&$request)
{
	if(MAGIC_QUOTES_GPC)
	{
		foreach($request as $k=>$v)
		{
			if(is_array($request[$k]))
			{
				filter_request($request[$k]);
			}
			else
			{
				$request[$k] = stripslashes(trim($v));
			}
		}
	}		
}

function check_login($username,$password){


	if (RELEASE < '20120316') {
		$sql = "select count(*) from information_schema.`COLUMNS` where TABLE_SCHEMA='".$GLOBALS['ecs']->db_name."' and TABLE_NAME = '".$GLOBALS['ecs']->prefix."admin_user'  and COLUMN_NAME = 'ec_salt'";
		$exist_ec_salt = intval($GLOBALS['db']->getOne($sql)) > 0;	
	}
		//return true;
	$ec_salt = '';	
	if (RELEASE >= '20120316' || $exist_ec_salt){
			$sql="SELECT `ec_salt` FROM ". $GLOBALS['ecs']->table('admin_user') ."WHERE user_name = '" . $username."'";
			$ec_salt = $GLOBALS['db']->getOne($sql);					
	}	
	
	$sql = "SELECT user_id, user_name, password, last_login, action_list, last_login".
						" FROM " . $GLOBALS['ecs']->table('admin_user') ." WHERE user_name = '" . $username. "'";	
		
	$row = $GLOBALS['db']->getRow($sql);
	if ($row)
	{ 
		$user_pwd = $row['password'];
		
		if ($user_pwd == $password || $user_pwd == md5($password) || $user_pwd ==  md5(md5($password).$ec_salt) || $user_pwd ==  md5($password.$ec_salt)){
		
			$GLOBALS['user_info'] = $row;
			$root['user_info'] = $row;		
			return true;
		}else{
			$GLOBALS['user_info'] = null;
			unset($GLOBALS['user_info']);		
			return false;		
		}		
	}else{
		$GLOBALS['user_info'] = null;
		unset($GLOBALS['user_info']);		
		return false;
	}	
	
	/*
	if (RELEASE < '20120316') {
		$sql = "select count(*) from information_schema.`COLUMNS` where TABLE_SCHEMA='".$GLOBALS['ecs']->db_name."' and TABLE_NAME = '".$GLOBALS['ecs']->prefix."admin_user'  and COLUMN_NAME = 'ec_salt'";
		$exist_ec_salt = intval($GLOBALS['db']->getOne($sql)) > 0;	
	}
		//return true;
	if (RELEASE >= '20120316' || $exist_ec_salt){
			$sql="SELECT `ec_salt` FROM ". $GLOBALS['ecs']->table('admin_user') ."WHERE user_name = '" . $username."'";
			$ec_salt = $GLOBALS['db']->getOne($sql);
			
			
			if(!empty($ec_salt)){
				$sql = "SELECT user_id, user_name, password, last_login, action_list, last_login".
						" FROM " . $GLOBALS['ecs']->table('admin_user') .
						" WHERE user_name = '" . $username. "' AND password = '" . md5(md5($password).$ec_salt) . "'";
			}else{
				$sql = "SELECT user_id, user_name, password, last_login, action_list, last_login".
						" FROM " . $GLOBALS['ecs']->table('admin_user') .
						" WHERE user_name = '" . $username. "' AND password = '" . md5($password) . "'";
			}
		}else{
				$sql = "SELECT user_id, user_name, password, last_login, action_list, last_login".
						" FROM " . $GLOBALS['ecs']->table('admin_user') .
						" WHERE user_name = '" . $username. "' AND password = '" . md5($password) . "'";	
		}	
		
		
	$row = $GLOBALS['db']->getRow($sql);
	if ($row)
	{ 
		$GLOBALS['user_info'] = $row;
		$root['user_info'] = $row;		
		return true;
	}else{
		$GLOBALS['user_info'] = null;
		unset($GLOBALS['user_info']);
		
		return false;
	}	
	*/
}

//过滤SQL注入
function strim($string)
{
	return trim(addslashes($string));
}

function checkTableExist($tableName){
	//check table exist
	//$sql = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '". $GLOBALS['ecs']->db_name ."'  AND TABLE_NAME = '".$GLOBALS['ecs']->prefix.$tableName."' LIMIT 1 ";
	$sql = "show tables like '".$GLOBALS['ecs']->prefix.$tableName."'";
	$table = $GLOBALS['db']->getRow($sql);
	return  (empty($table)) ? false : true;
}

function drop_goods($goods_ids){

	//$goods_ids = base64_decode($goods_ids);
	$goods_id_arr = explode (',', $goods_ids );
	 
	//check table exist
	$tableExist = array();
	 
	$tableExist['collect_goods'] = checkTableExist('collect_goods');
	$tableExist['goods_article'] = checkTableExist('goods_article');
	$tableExist['goods_activity'] = checkTableExist('goods_activity');
	$tableExist['goods_attr'] = checkTableExist('goods_attr');
	$tableExist['goods_cat'] = checkTableExist('goods_cat');
	$tableExist['member_price'] = checkTableExist('member_price');
	$tableExist['group_goods'] = checkTableExist('group_goods');
	$tableExist['link_goods'] = checkTableExist('link_goods');
	$tableExist['tag'] = checkTableExist('tag');
	$tableExist['comment'] = checkTableExist('comment');
	$tableExist['booking_goods'] = checkTableExist('booking_goods');
	$tableExist['volume_price'] = checkTableExist('volume_price');
	$tableExist['virtual_card'] = checkTableExist('virtual_card');
	$tableExist['products'] = checkTableExist('products');
	 
	foreach ( $goods_id_arr as $goods_id ) {

		$sql = "SELECT goods_id, goods_name, is_delete, is_real, goods_thumb, " .
				"goods_img, original_img " .
				"FROM " .$GLOBALS['ecs']->table('goods') .
				" WHERE goods_id = '$goods_id'";
		$goods = $GLOBALS['db']->getRow($sql);

		if (!empty($goods['goods_id'])){
			 
			if (!empty($goods['goods_thumb']))
			{
				@unlink('../' . $goods['goods_thumb']);
			}
			if (!empty($goods['goods_img']))
			{
				@unlink('../' . $goods['goods_img']);
			}
			if (!empty($goods['original_img']))
			{
				@unlink('../' . $goods['original_img']);
			}
			$sql = "DELETE FROM " . $GLOBALS['ecs']->table('goods') . " WHERE goods_id = '$goods_id'";
			$GLOBALS['db']->query($sql);

			$sql = "SELECT img_url, thumb_url, img_original " .
					"FROM " . $GLOBALS['ecs']->table('goods_gallery') .
					" WHERE goods_id = '$goods_id' order by img_id";
			$res = $GLOBALS['db']->query($sql);
			while ($row = $GLOBALS['db']->fetchRow($res))
			{
				if (!empty($row['img_url']))
				{
					@unlink('../' . $row['img_url']);
				}
				if (!empty($row['thumb_url']))
				{
					@unlink('../' . $row['thumb_url']);
				}
				if (!empty($row['img_original']))
				{
					@unlink('../' . $row['img_original']);
				}
			}
			 
			$sql = "DELETE FROM " . $GLOBALS['ecs']->table('goods_gallery') . " WHERE goods_id = '$goods_id'";
			$GLOBALS['db']->query($sql);
			 
			if ($tableExist['collect_goods']){
				$sql = "DELETE FROM " . $GLOBALS['ecs']->table('collect_goods') . " WHERE goods_id = '$goods_id'";
				$GLOBALS['db']->query($sql);
			}
			 
			if ($tableExist['goods_article']){
				$sql = "DELETE FROM " . $GLOBALS['ecs']->table('goods_article') . " WHERE goods_id = '$goods_id'";
				$GLOBALS['db']->query($sql);
			}

			if ($tableExist['goods_activity']){
				$sql = "DELETE FROM " . $GLOBALS['ecs']->table('goods_activity') . " WHERE goods_id = '$goods_id'";
				$GLOBALS['db']->query($sql);
			}

			if ($tableExist['goods_attr']){
				$sql = "DELETE FROM " . $GLOBALS['ecs']->table('goods_attr') . " WHERE goods_id = '$goods_id'";
				$GLOBALS['db']->query($sql);
			}
			 
			if ($tableExist['goods_cat']){
				$sql = "DELETE FROM " . $GLOBALS['ecs']->table('goods_cat') . " WHERE goods_id = '$goods_id'";
				$GLOBALS['db']->query($sql);
			}

			if ($tableExist['member_price']){
				$sql = "DELETE FROM " . $GLOBALS['ecs']->table('member_price') . " WHERE goods_id = '$goods_id'";
				$GLOBALS['db']->query($sql);
			}

			if ($tableExist['group_goods']){
				$sql = "DELETE FROM " . $GLOBALS['ecs']->table('group_goods') . " WHERE parent_id = '$goods_id'";
				$GLOBALS['db']->query($sql);

				$sql = "DELETE FROM " . $GLOBALS['ecs']->table('group_goods') . " WHERE goods_id = '$goods_id'";
				$GLOBALS['db']->query($sql);
			}

			if ($tableExist['link_goods']){
				$sql = "DELETE FROM " . $GLOBALS['ecs']->table('link_goods') . " WHERE goods_id = '$goods_id'";
				$GLOBALS['db']->query($sql);

				$sql = "DELETE FROM " . $GLOBALS['ecs']->table('link_goods') . " WHERE link_goods_id = '$goods_id'";
				$GLOBALS['db']->query($sql);
			}

			if ($tableExist['tag']){
				$sql = "DELETE FROM " . $GLOBALS['ecs']->table('tag') . " WHERE goods_id = '$goods_id'";
				$GLOBALS['db']->query($sql);
			}

			if ($tableExist['comment']){
				$sql = "DELETE FROM " . $GLOBALS['ecs']->table('comment') . " WHERE comment_type = 0 AND id_value = '$goods_id'";
				$GLOBALS['db']->query($sql);
			}

			if ($tableExist['booking_goods']){
				$sql = "DELETE FROM " . $GLOBALS['ecs']->table('booking_goods') . " WHERE goods_id = '$goods_id'";
				$GLOBALS['db']->query($sql);
			}

			if ($tableExist['volume_price']){
				$sql = "DELETE FROM " . $GLOBALS['ecs']->table('volume_price') ." WHERE price_type = '1' AND goods_id = '$goods_id'";
				$GLOBALS['db']->query($sql);
			}

			if (($goods['is_real'] != 1) && ($tableExist['virtual_card'])){
				$sql = "DELETE FROM " . $GLOBALS['ecs']->table('virtual_card') . " WHERE goods_id = '$goods_id'";
				$GLOBALS['db']->query($sql);
			}
			 
			if ($tableExist['products']){
				$sql = "DELETE FROM " . $GLOBALS['ecs']->table('products') ." WHERE goods_id = '$goods_id'";
				$GLOBALS['db']->query($sql);
			}
			 
		}

		 
	 $sync_item = array( );
	 $sync_item['table'] = "ecs_goods";
	 $sync_item['guid'] = $goods_id;
	 $sync_item['succ'] = true;
	 //$sync_item['errmsg'] = base64_encode($tmp);
	 	
	 $syncitems[] = $sync_item;
	}
	 
	 
	//clear_cache_files();
	 
	$pack = array(
			"succ" => true,
			"items" => $syncitems
	);

	return $pack;
}

function uploadRecord2($list, $table, $idfields, $syncfield)
{
	//logutils::clear_log();
	//logutils::log_str( "UploadRecord Begin ".$table );
	
	$table = strtolower($table);
	
	
	//logutils::log_str("data:".$data );
	//logutils::log_str( $delimiter_rn );
	//logutils::log_str( $delimiter_cn );
	

	//logutils::log_obj( $list );
	
	//return NULL;
	
	$idcolarr = explode( ",", $idfields );
	
	//logutils::log_obj( "idfields:".$idfields );
	//logutils::log_obj( "idcolarr:".$idcolarr );
	//logutils::log_str( "idcolarr[0]:".$idcolarr[0] );
	
	foreach ( $list as $row )
	{		
		$sync_item = array( );
		$sync_item['table'] = $table;
		$sync_item['guid'] = ""; 
		$sync_item['succ'] = false;
		$sync_item['errmsg'] = "";
		$sync_item['syncstate'] = AS_SYNC_ADDED; 
		
		if (isset($row[$syncfield]))
		{
			$sync_item['syncstate'] = $row[$syncfield];
			//logutils::log_str( "syncfield_value:".$row[$syncfield] );
		}else{
			//logutils::log_str("syncfield is null");
		}
		
		//logutils::log_str( "syncstate-------------------------:" );
		//logutils::log_str("table:".$table );
		//logutils::log_str( "idfields:".$idfields );
		//logutils::log_str( "syncfield:".$syncfield );
		//logutils::log_str( "syncfield_value:".$row[$syncfield] );
		//logutils::log_str( $sync_item['syncstate'] );
		//logutils::log_str( "syncstate-------------------------:");

		if (($idfields == '') || empty( $idfields )){
			$idcndstr = '1=0';
		}else{
			$idcndstr = "";		
			$linefirst = true;	
			foreach ( $idcolarr as $idcol )
			{
				if ( array_key_exists( $idcol, $row ) )
				{
					if ($linefirst)
					  $sync_item['guid'] = $row[$idcol];
					else 
					  $sync_item['guid'] = $sync_item['guid'].",".$row[$idcol];
	   			 
					$linefirst = false;  
					
					if ( !empty( $idcndstr ) )
					{
						$idcndstr .= " and ";
					}
					$idcndstr .= $idcol."=".$row[$idcol];				
				}			
			}
		} 
		
		if (empty( $idcndstr ))
		{
			$sync_item['succ'] = false;
			$sync_item['errmsg'] = "关键字段不能为空.";	
			$syncitems[] = $sync_item;				
		}
		else{
		//logutils::log_str( "UploadRecord End sync_item " );
		//logutils::log_obj( $sync_item );			
			//==============================switch begin==========================================
			switch ( $sync_item['syncstate'] )
				{
					
				case NULL :
					$sync_item['succ'] = false;
					$sync_item['errmsg'] = "无效的更新状态 syncstate";
					break;					
				case AS_SYNC_DELETED :
					
					if($table == 'category')
					{
				        $sql = 'DELETE FROM ' .$GLOBALS['ecs']->table('goods_cat'). " WHERE cat_id = ".$row['cat_id'];
				        $GLOBALS['db']->query( $sql );					        
				        //if (!eregi('^(v2.5.0|v2.5.1|v2.6.0)$',VERSION))
				        if(!preg_match('/^(v2.5.0|v2.5.1|v2.6.0)$/i',VERSION))
				        {
				        	$sql = 'DELETE FROM ' .$GLOBALS['ecs']->table('cat_recommend'). " WHERE cat_id = ".$row['cat_id'];
				        	$GLOBALS['db']->query( $sql );
				        }
				        
				        $sql = "DELETE FROM " . $GLOBALS['ecs']->table('nav') . "WHERE ctype = 'c' AND cid = '" . $row['cat_id'] . "' AND type = 'middle'";
				        $GLOBALS['db']->query( $sql );						
					}
					
					$sql = "delete from ".$GLOBALS['ecs']->table($table)." where {$idcndstr}";
					//logutils::log_str( $sql );
					if ( !$GLOBALS['db']->query( $sql ) )
					{
						break;
					}
					$sync_item['succ'] = true;
					break;
				case AS_SYNC_UNCHANGED :
					$sync_item['succ'] = true;
					break;
				case AS_SYNC_MODIFIED :
					if ($table == 'goods')
					{
						//logutils::clear_log();
						$sql = "select count(*) from ".$GLOBALS['ecs']->table($table)." where goods_id <> ".$row['goods_id']." and goods_sn = '".$row['goods_sn']."'";
						//logutils::log_str( $sql );
						$count = $GLOBALS['db']->getOne( $sql );
						if ( 0 < $count ) 
						{   
							$sync_item['errmsg'] = "商品编辑失败,商品编号重复.".$row['goods_id'];
							$sync_item['succ'] = false;
							//logutils::log_str( 'uploadGoods1:' );
							//logutils::log_str( $sync_item['errmsg'] );
							break;
						}						
					}
										
					$sql = "select count(*) from ".$GLOBALS['ecs']->table($table)." where {$idcndstr}";
					//logutils::log_str( $sql );
					$count = $GLOBALS['db']->getOne( $sql );
					if ( 0 < $count )
					{
						//logutils::log_obj( $row );
						$fvs = '';
						$linefirst = true;	
						foreach ( $row as $field=>$v )
						{
							//$v = str_replace( "'", "\'", $v );
							if (($field <> $syncfield) and ($field <> 'category_cat_recommend'))
							{
								if ($linefirst)
								  $fvs = $field."="."'".addslashes($v)."'";
								else
								  $fvs = $fvs.",".$field."="."'".addslashes($v)."'";
								$linefirst = false;
							}  
						}
						$sql = "UPDATE ".$GLOBALS['ecs']->table($table)."SET ".$fvs." WHERE {$idcndstr}";
						
						//logutils::log_str( $sql );
						
						if ( !$GLOBALS['db']->query( $sql ) )
						{
							break;
						}
						
						if ($table == 'category') 
						{
							$sql = "select count(*) from ".$GLOBALS['ecs']->table('nav')." where ctype = 'c'  AND type = 'middle' and cid =".$row['cat_id'];
							//logutils::log_str( $sql );
							$count = $GLOBALS['db']->getOne( $sql );
							if ( 0 == $count and $row['show_in_nav'] == 1)
							{
								add_nav($row['cat_id'], $row['cat_name']);
							}else{
					            $sql = "UPDATE " . $GLOBALS['ecs']->table('nav') . " SET ifshow = ".$row['show_in_nav'].", name = '" . $row['cat_name'] . "' WHERE ctype = 'c' AND cid = '" . $row['cat_id'] . "' AND type = 'middle'";
					            //logutils::log_str( $sql );
					            $GLOBALS['db']->query($sql);								
							}
							//if (!eregi('^(v2.5.0|v2.5.1|v2.6.0)$',VERSION))
							if(!preg_match('/^(v2.5.0|v2.5.1|v2.6.0)$/i',VERSION))
							{
								$recommend_type = explode(',', $row['category_cat_recommend'] ); 
								//logutils::log_str( 'recommend_type:' );
								//logutils::log_obj( $recommend_type );
								insert_cat_recommend2($recommend_type, $row['cat_id']);
							}							
						}						
						
						$sync_item['succ'] = true;
						
						break;
					}else{
						$sync_item['errmsg'] = " 数据已经被删除,不能再更新.{$sql}";
						$sync_item['succ'] = false;
						//logutils::log_str( 'uploadGoods2:' );
						//logutils::log_str( $sync_item['errmsg'] );
						break;
					}
					
				case AS_SYNC_ADDED :
					$sql = "select count(*) from ".$GLOBALS['ecs']->table($table)." where {$idcndstr}";
					//logutils::log_str( $sql );
					$count = $GLOBALS['db']->getOne( $sql );
						
					if ( 0 < $count ) 
					{   
						$sync_item['errmsg'] = " 新增失败, 已经存在.{$sql}";
						$sync_item['succ'] = false;
						//logutils::log_str( $sync_item['errmsg'] );
						break;
					}
						
					//logutils::log_obj( $row );
					
					if ($table == 'goods')
					{
						//logutils::clear_log();
						$sql = "select count(*) from ".$GLOBALS['ecs']->table($table)." where goods_sn = '".$row['goods_sn']."'";
						//logutils::log_str( $sql );
						$count = $GLOBALS['db']->getOne( $sql );
						if ( 0 < $count ) 
						{   
							$sync_item['errmsg'] = "商品添加失败,商品编号重复.".$row['goods_sn'];
							$sync_item['succ'] = false;
							//logutils::log_str( $sync_item['errmsg'] );
							break;
						}						
					}
					
					$fs = '';
					$fv = '';
					$linefirst = true;	
					foreach ( $row as $field=>$v )
					{
						//$v = str_replace( "'", "\'", $v );
						if (($field <> $syncfield) and ($field <> 'category_cat_recommend'))
						{
							if ($linefirst)
							  $fs = $field;
							else
							  $fs = $fs.",".$field;
							  
							if ($linefirst)
							  $fv = "'".addslashes($v)."'";
							else
							  $fv = $fv.",'".addslashes($v)."'";
							  
							$linefirst = false;
						}  
					}
					$sql = "INSERT INTO ".$GLOBALS['ecs']->table($table)."(".$fs.") VALUES(".$fv.")";
					//logutils::log_str( $sql );
					
					if ( !$GLOBALS['db']->query( $sql ) )
					{
						break;
					}
					
					if ($table == 'category') 
					{
						if ($row['show_in_nav'] == 1)
						{
							add_nav($row['cat_id'], $row['cat_name']);
						}
						//if (!eregi('^(v2.5.0|v2.5.1|v2.6.0)$',VERSION))
						if(!preg_match('/^(v2.5.0|v2.5.1|v2.6.0)$/i',VERSION))
						{
							$recommend_type = explode(',', $row['category_cat_recommend'] );
							//logutils::log_str( 'recommend_type:' );
							//logutils::log_obj( $recommend_type );
							insert_cat_recommend2($recommend_type, $row['cat_id']);
						}
					}
										
					$sync_item['succ'] = true;
				}//switch ( $sync_item['syncstate'] )
			//====================================switch end=============================================
			//logutils::log_obj( $sync_item );
			$syncitems[] = $sync_item;
		}//if ( !empty( $idcndstr ))			
	}//foreach ( $list as $row )	
		
	$succ = true;
	foreach ( $syncitems as $sync_item )
	{
		if ($sync_item['succ'] == false)
		{
			$succ = false;
			break;
		}
	}
			
	$pack = array(
		"succ" => $succ,
		"items" => $syncitems
	);
	//logutils::log_str( "UploadRecord Return" );
	return $pack;
}

function mkpathA($mkpath, $mode = 0777) {
	$path_arr = explode ( '/', $mkpath );
	$path = "";
	foreach ( $path_arr as $value ) {
		if (! empty ( $value )) {
			if (empty ( $path )){
				if (strpos($value,':') >0){
					$path = $value;
				}else{
					$path = '/'.$value;
				}
			}	
			else
				$path .= '/' . $value;
			if (!file_exists ( $path ))
			{
			  @mkdir ( $path, $mode );
			} 
		}
	}
	if (file_exists ( $mkpath ))
		return true;
	return false;
}
	/**
	 * 保存文件
	 * @param string $source 源文件路径
	 * @param string $target 目录文件路径
	 * @return bool
	 */
	function saveFile($source, $target)
	{
		if(!isUploadFile($source))
			$succeed = false;
		elseif(@copy($source, $target))
			$succeed = true;
		elseif(function_exists('move_uploaded_file') && @move_uploaded_file($source, $target))
			$succeed = true;
		elseif (@is_readable($source) && (@$fp_s = fopen($source, 'rb')) && (@$fp_t = fopen($target, 'wb')))
		{
			while (!feof($fp_s))
			{
				$s = @fread($fp_s, 1024 * 512);
				@fwrite($fp_t, $s);
			}
			fclose($fp_s);
			fclose($fp_t);
			$succeed = true;
		}

		if($succeed)
		{
			@chmod($target, 0644);
			@unlink($source);
		}

		return $succeed;
	}

	/**
	 * 获取是否充许上传文件
	 * @param string $source 文件路径
	 * @return bool
	 */
	function isUploadFile($source)
	{
		return $source && ($source != 'none') && (is_uploaded_file($source) || is_uploaded_file(str_replace('\\\\', '\\', $source)));
	}	
	
	

function add_nav($cat_id, $cat_name)
{
  //logutils::log_str( "add_nav: begin " );	
  $vieworder = $GLOBALS['db']->getOne("SELECT max(vieworder) FROM ". $GLOBALS['ecs']->table('nav') . " WHERE type = 'middle'");
  $vieworder += 2;
  $sql = "INSERT INTO " . $GLOBALS['ecs']->table('nav') .
     " (name,ctype,cid,ifshow,vieworder,opennew,url,type)".
      " VALUES('" . $cat_name . "', 'c', '".$cat_id."','1','$vieworder','0', '" . build_uri('category', array('cid'=> $cat_id)) . "','middle')";
  //logutils::log_str( $sql );
  $GLOBALS['db']->query($sql);

}

/**
 *
 * @access  public
 * @param   array   $recommend_type
 * @param   integer $cat_id 
 *
 * @return void
 */
function insert_cat_recommend2($recommend_type, $cat_id)
{
    if (!empty($recommend_type))
    {
        $recommend_res = $GLOBALS['db']->getAll("SELECT recommend_type FROM " . $GLOBALS['ecs']->table("cat_recommend") . " WHERE cat_id=" . $cat_id);
        if (empty($recommend_res))
        {
            foreach($recommend_type as $data)
            {
                $data = intval($data);
                $GLOBALS['db']->query("INSERT INTO " . $GLOBALS['ecs']->table("cat_recommend") . "(cat_id, recommend_type) VALUES ('$cat_id', '$data')");
            }
        }
        else
        {
            $old_data = array();
            foreach($recommend_res as $data)
            {
                $old_data[] = $data['recommend_type'];
            }
            $delete_array = array_diff($old_data, $recommend_type);
            if (!empty($delete_array))
            {
                $GLOBALS['db']->query("DELETE FROM " . $GLOBALS['ecs']->table("cat_recommend") . " WHERE cat_id=$cat_id AND recommend_type " . db_create_in($delete_array));
            }
            $insert_array = array_diff($recommend_type, $old_data);
            if (!empty($insert_array))
            {
                foreach($insert_array as $data)
                {
                    $data = intval($data);
                    $GLOBALS['db']->query("INSERT INTO " . $GLOBALS['ecs']->table("cat_recommend") . "(cat_id, recommend_type) VALUES ('$cat_id', '$data')");
                }
            }
        }
    }
    else
    {
        $GLOBALS['db']->query("DELETE FROM ". $GLOBALS['ecs']->table("cat_recommend") . " WHERE cat_id=" . $cat_id);
    }
}


function goodsImgList($goods_id){
	$imgList = array();
	$imgIndex = 0;
	$sql = "select original_img, goods_img, goods_thumb from ".$GLOBALS['ecs']->table('goods')." where goods_id=".$goods_id. "  LIMIT 1";	
	$rows = $GLOBALS['db']->GetAll($sql); 
	if ( $rows )
	{
		foreach ( $rows as $row )
		{
			$imgIndex = 0;
			$imgList[$imgIndex] = $row['original_img'];
			
			$imgIndex = $imgIndex + 1;
			$imgList[$imgIndex] = $row['goods_img'];
			
			$imgIndex = $imgIndex + 1;
			$imgList[$imgIndex] = $row['goods_thumb'];
		}
	}

	$sql = "select img_original, img_url, thumb_url from ".$GLOBALS['ecs']->table('goods_gallery')." where goods_id=".$goods_id." order by img_id";	
	$rows = $GLOBALS['db']->GetAll($sql); 
	if ( $rows )
	{
		foreach ( $rows as $row )
		{
			$imgIndex = $imgIndex + 1;
			$imgList[$imgIndex] = $row['img_original'];
			
			$imgIndex = $imgIndex + 1;
			$imgList[$imgIndex] = $row['img_url'];
			
			$imgIndex = $imgIndex + 1;
			$imgList[$imgIndex] = $row['thumb_url'];
		}
	}	
	
	//logutils::log_obj($imgList);
	return $imgList;
}

function uploadGoods(
		$goods_id, 
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
		$syncfield
		)
{
		
	//$data_goods = str_iconv(ECS_CHARSET, EC_CHARSET, $data_goods);
	//$data_goods_article = str_iconv(ECS_CHARSET, EC_CHARSET, $data_goods_article);
	//$data_goods_attr = str_iconv(ECS_CHARSET, EC_CHARSET, $data_goods_attr);
	//$data_goods_cat = str_iconv(ECS_CHARSET, EC_CHARSET, $data_goods_cat);
	//$data_goods_gallery = str_iconv(ECS_CHARSET, EC_CHARSET, $data_goods_gallery);
	//$data_group_goods = str_iconv(ECS_CHARSET, EC_CHARSET, $data_group_goods);
	//$data_link_goods = str_iconv(ECS_CHARSET, EC_CHARSET, $data_link_goods);
	//$data_member_price = str_iconv(ECS_CHARSET, EC_CHARSET, $data_member_price);
	
	//logutils::clear_log();
	//logutils::log_str( "uploadGoods Begin goods_id:".$goods_id );
	//logutils::log_str( $data_goods );	

	$oldImgList = goodsImgList($goods_id); //add by chenfq 20090829
	
	$pack = uploadRecord2($data_goods, 'goods', 'goods_id', $syncfield);

	//logutils::log_str( "uploadGoods_goods" );
	$errmsg = '';
	if ($pack['succ'] == false)
	{	
		foreach ( $pack['items'] as $sync_item )
		{
			if ($sync_item['succ'] == false)
			{
				$errmsg = $errmsg.",".$sync_item['errmsg'];
			}
		}
		//logutils::log_obj( $pack );
		//logutils::log_str( "1errmsg:".$errmsg );
		return $errmsg;	
	}	
	

	if (!Empty($data_goods_attr))
	{
		//logutils::log_str( "uploadGoods_goods_attr1" );
		$sql = "delete from ".$GLOBALS['ecs']->table('goods_attr')." where goods_id = $goods_id";
		//logutils::log_str( $sql );
		$GLOBALS['db']->query( $sql ); //idfields = 'goods_id'
			
		unset($pack);
		//logutils::clear_log();
		$pack = uploadRecord2($data_goods_attr, 'goods_attr', 'goods_attr_id', $syncfield);
		
		//logutils::log_str( "uploadGoods_goods_attr2" );
		if ($pack['succ'] == false)
		{	
			foreach ( $pack['items'] as $sync_item )
			{
				if ($sync_item['succ'] == false)
				{
					$errmsg = $errmsg.",".$sync_item['errmsg'];
				}
			}
			//logutils::log_obj( $pack );
			//logutils::log_str( "2errmsg:".$errmsg );
			return $errmsg;	
		}			
	}
	
	$sql = "delete from ".$GLOBALS['ecs']->table('goods_article')." where goods_id = $goods_id";
	//logutils::log_str( $sql );
	$GLOBALS['db']->query( $sql );//idfields = 'goods_id,article_id'
	if (!Empty($data_goods_article))
	{	
		unset($pack);
		$pack = uploadRecord2($data_goods_article, 'goods_article', '', $syncfield);
		
		//logutils::log_str( "uploadGoods_goods_article" );
		
		if ($pack['succ'] == false) 
		{	
			foreach ( $pack['items'] as $sync_item )
			{
				if ($sync_item['succ'] == false)
				{
					$errmsg = $errmsg.",".$sync_item['errmsg'];
				}
			}
			//logutils::log_obj( $pack );
			//logutils::log_str( "3errmsg:".$errmsg );
			return $errmsg;	
		}
	
	}
	$sql = "delete from ".$GLOBALS['ecs']->table('goods_cat')." where goods_id = $goods_id";
	//logutils::log_str( $sql );
	$GLOBALS['db']->query( $sql ); //idfields = 'goods_id,cat_id'
	if (!Empty($data_goods_cat))
	{	
		unset($pack);	
		$pack = uploadRecord2($data_goods_cat, 'goods_cat', '', $syncfield);
		//logutils::log_str( "uploadGoods_goods_cat" );
		
		if ($pack['succ'] == false) 
		{	
			foreach ( $pack['items'] as $sync_item )
			{
				if ($sync_item['succ'] == false)
				{
					$errmsg = $errmsg.",".$sync_item['errmsg'];
				}
			}
			//logutils::log_obj( $pack );
			//logutils::log_str( "4errmsg:".$errmsg );
			return $errmsg;	
		}
	}		
	$sql = "delete from ".$GLOBALS['ecs']->table('goods_gallery')." where goods_id = $goods_id";
	//logutils::log_str( $sql );
	$GLOBALS['db']->query( $sql );//idfields = 'img_id'
	if (!Empty($data_goods_gallery))
	{	
		unset($pack);	
		$pack = uploadRecord2($data_goods_gallery, 'goods_gallery', '', $syncfield);
		//logutils::log_str( "uploadGoods_goods" );
		
		if ($pack['succ'] == false)
		{	
			foreach ( $pack['items'] as $sync_item )
			{
				if ($sync_item['succ'] == false)
				{
					$errmsg = $errmsg.",".$sync_item['errmsg'];
				}
			}
			//logutils::log_obj( $pack );
			//logutils::log_str( "5errmsg:".$errmsg );
			return $errmsg;	
		}
	}	
	$sql = "delete from ".$GLOBALS['ecs']->table('group_goods')." where parent_id = $goods_id";
	//logutils::log_str( $sql );
	$GLOBALS['db']->query( $sql );//idfields = 'parent_id,goods_id'
	if (!Empty($data_group_goods))
	{	
		unset($pack);	
		$pack = uploadRecord2($data_group_goods, 'group_goods', '',  $syncfield);
		//logutils::log_str( "uploadGoods_group_goods" );
		
		if ($pack['succ'] == false) 
		{	
			foreach ( $pack['items'] as $sync_item )
			{
				if ($sync_item['succ'] == false)
				{
					$errmsg = $errmsg.",".$sync_item['errmsg'];
				}
			}
			//logutils::log_obj( $pack );
			//logutils::log_str( "6errmsg:".$errmsg );
			return $errmsg;	
		}
	}	
	$sql = "delete from ".$GLOBALS['ecs']->table('link_goods')." where goods_id = $goods_id";
	//logutils::log_str( $sql );
	$GLOBALS['db']->query( $sql );//idfields = 'goods_id,link_goods_id'
	if (!Empty($data_link_goods))
	{	
		unset($pack);	
		$pack = uploadRecord2($data_link_goods, 'link_goods', '', $syncfield);
		//logutils::log_str( "uploadGoods_link_goods" );
		
		if ($pack['succ'] == false)
		{	
			foreach ( $pack['items'] as $sync_item )
			{
				if ($sync_item['succ'] == false)
				{
					$errmsg = $errmsg.",".$sync_item['errmsg'];
				}
			}
			//logutils::log_obj( $pack );
			//logutils::log_str( "7errmsg:".$errmsg );
			return $errmsg;	
		}
	}	
	$sql = "delete from ".$GLOBALS['ecs']->table('member_price')." where goods_id = $goods_id";
	//logutils::log_str( $sql );
	$GLOBALS['db']->query( $sql );//idfields = 'price_id'
	if (!Empty($data_member_price))
	{	
		unset($pack);	
		$pack = uploadRecord2($data_member_price, 'member_price', '', $syncfield);
		//logutils::log_str( "uploadGoods_member_price" );
		
		if ($pack['succ'] == false)
		{	
			foreach ( $pack['items'] as $sync_item )
			{
				if ($sync_item['succ'] == false)
				{
					$errmsg = $errmsg.",".$sync_item['errmsg'];
				}
			}
			//logutils::log_obj( $pack );
			//logutils::log_str( "8errmsg:".$errmsg );
			return $errmsg;	
		}
	}
	
	if ((!preg_match('/^(v2.5.0|v2.5.1|v2.6.0|v2.6.1)$/i',VERSION)) && ($data_volume_price <> '-1')){
		$sql = "delete from ".$GLOBALS['ecs']->table('volume_price')." where goods_id = $goods_id";
		//logutils::log_str( $sql );
		$GLOBALS['db']->query( $sql );//idfields = 'price_id'
		if (!Empty($data_volume_price))
		{	
			unset($pack);	
			$pack = uploadRecord2($data_volume_price, 'volume_price', '', $syncfield);
			//logutils::log_str( "uploadGoods_member_price" );
			
			if ($pack['succ'] == false)
			{	
				foreach ( $pack['items'] as $sync_item )
				{
					if ($sync_item['succ'] == false)
					{
						$errmsg = $errmsg.",".$sync_item['errmsg'];
					}
				}
				//logutils::log_obj( $pack );
				//logutils::log_str( "8errmsg:".$errmsg );
				return $errmsg;	
			}
		}		
	}
	
	if ((!preg_match('/^(v2.5.0|v2.5.1|v2.6.0|v2.6.1|v2.6.2|v2.7.0|v2.7.1)$/i',VERSION)) && ($data_products <> '-1')){
		$sql = "delete from ".$GLOBALS['ecs']->table('products')." where goods_id = $goods_id";
		$GLOBALS['db']->query( $sql );
		if (!Empty($data_products))
		{			
			unset($pack);
			//logutils::clear_log();
			$pack = uploadRecord2($data_products, 'products', 'product_id', $syncfield);
			
			//logutils::log_str( "uploadGoods_goods_attr2" );
			if ($pack['succ'] == false)
			{	
				foreach ( $pack['items'] as $sync_item )
				{
					if ($sync_item['succ'] == false)
					{
						$errmsg = $errmsg.",".$sync_item['errmsg'];
					}
				}
				//logutils::log_obj( $pack );
				//logutils::log_str( "2errmsg:".$errmsg );
				return $errmsg;	
			}
		}		
	}	
	
	//logutils::log_str( "uploadGoods End goods_id:".$goods_id );
	
	$newImgList = goodsImgList($goods_id); //add by chenfq 20090829
	$total = count($oldImgList);
	
	//logutils::log_obj( $oldImgList );
	//logutils::log_obj( $newImgList );
	
	for($i=0;$i<$total;$i++){
		if (!in_array($oldImgList[$i], $newImgList)){
			//$file = ROOT_PATH . $oldImgList[$i];
			//$file = str_replace( "\\", "/", $file );
			$file = '../' . $oldImgList[$i];
			if (file_exists ( $file )) {
				//logutils::log_str( "delete:".$file );
				@unlink($file);
			}						
		}
	}
	
	
    //clear_cache_files();
    
	return 'true';
			
}	
?>