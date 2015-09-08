<?php
class Helper_virtual {
  public $conn;
  public $username="abc123";
  public $dbname="K73fB4417cB394e4";
  public $password="abc123";
  public $host="localhost:3306";
  public function __construct(){
  	$this->conn=mysql_connect($this->host,$this->username,$this->password);
  	if(!$this->conn){
  		die("连接失败".mysql_error());
  	}	
  	mysql_select_db($this->dbname);
  	mysql_set_charset("utf8",$this->conn);	
  }	
//返回结果集
//还需要取结果集
   public function execute_dql($sql){
		$res=mysql_query($sql);
		return $res;
	}
//直接返回结果的数组	
	public function execute_dql1($sql){
		$res=mysql_query($sql);
		$row=mysql_fetch_array($res);
		$result=$row[0];
		return $result;	
	}
	
//返回模式一最高享受的层数
    
   function getmodel1_highlayer(){
		$res=mysql_query("select max(cengshu) from ydcom_user_ceng where cengshu ");
		$row=mysql_fetch_array($res);
		$res1=$row[0];
		return $res1;
	}
			
//获取直推达到某级别的人数
  function getrec($rec_id,$min_points){
  	$res=mysql_query("select count(*) from ydcom_users where parent_id=$rec_id and rank_points>=$min_points");
  	return $res;
  	//echo "直推"; 
  	//执行到return后就结束该函数
    //放在最下面就不会执行
  }

//获取所有推荐达到某级别的人数
  function getgroup_rec($rec_id,$min_points){
  	$up_uid=$rec_id;
  	$all_ally='';
  	 for (;!empty($up_uid);){
  		$res=mysql_query("select user_id from ydcom_users where parent_id in($up_uid)");
  		$up_uid = '';
  		while ($rt=mysql_fetch_array($res))
  		{
  			$up_uid .= $up_uid ? ",'$rt[user_id]'" : "'$rt[user_id]'";
  			$all_ally.=$all_ally ? ",'$rt[user_id]'" : "'$rt[user_id]'";
  		}
  	}
     if (empty($all_ally)){
     	return 0;
     }
  	//得到所有盟友all_ally
  	$res2=mysql_query("select count(*) from ydcom_users where user_id in($all_ally) and rank_points>=$min_points");
  	$row2=mysql_fetch_array($res2);
  	$amount=$row2[0];
  	return $amount;	

  }

  //返回用户分销等级
  function getuser_fenxiaorank($user_id){
  	$rank_points=$this->execute_dql1("select rank_points from ydcom_users where user_id=$user_id");
  	$user_fukuan_amount=$this->getuser_fukuan_amount($user_id);
  	$rank_points+=$user_fukuan_amount;
  	//c1为用户积分等级
  	$c1=$this->execute_dql1("select fenxiao_rank from ydcom_user_yongjin where $rank_points<=max_points and $rank_points>=min_points");
  	//$z1为进入模二最低门槛
  	$min93=$this->execute_dql1("select max(cengshu)  from ydcom_user_yongjin where cengshu"); 	
  	$z1=$this->execute_dql1("select min_points from ydcom_user_yongjin where cengshu=$min93");
  	//$z2为直推下线人数，满足槛
  	$res81=$this->getrec($user_id, $z1);
  	$row81=mysql_fetch_array($res81);
  	$z2=$row81[0];
  	//c2为直推等级
  	$c2=$this->execute_dql1("select fenxiao_rank from ydcom_user_yongjin where $z2<=max_rec and $z2>=min_rec");
  	//z3为团队推荐满足门槛的人数
  	$z3=$this->getgroup_rec($user_id, $z1);
    //c3团推等级
  	$c3=$this->execute_dql1("select fenxiao_rank from ydcom_user_yongjin where $z3<=max_group_rec and $z3>=min_group_rec");                                                                                    
  	//$user_rank为用户等级
  	$user_rank=min($c1,$c2,$c3);
    $gomodel2=$this->gomodel2();
    if ($user_rank<$gomodel2){
    	if ($c1>=$gomodel2){
    		return $gomodel2;}	
    	return $c1;}
    //已经达到模式二，
    //如果没有下家就返回模式二的最低等级
    return $user_rank;
   
}

//注册时间
function getuser_reg_time($user_id){
	$res=mysql_query("select reg_time from ydcom_users where user_id=$user_id");
    while ($row=mysql_fetch_array($res)){
    	$reg_time=$row[0];
    }
    if ($reg_time){
    	return $reg_time;
    }else {
    	return 0;
    }
}



//返回真实等级
//返回真实等级
//返回真实等级
//返回真实等级
//返回真实等级
function getuser_fenxiaorank_true($user_id){
	$rank_points=$this->execute_dql1("select rank_points from ydcom_users where user_id=$user_id");
	//c1为用户积分等级
	$c1=$this->execute_dql1("select fenxiao_rank from ydcom_user_yongjin where $rank_points<=max_points and $rank_points>=min_points");
	//$z1为进入模二最低门槛
	$min93=$this->execute_dql1("select max(cengshu)  from ydcom_user_yongjin where cengshu");
	$z1=$this->execute_dql1("select min_points from ydcom_user_yongjin where cengshu=$min93");
	//$z2为直推下线人数，满足槛
	$res81=$this->getrec($user_id, $z1);
	$row81=mysql_fetch_array($res81);
	$z2=$row81[0];
	//c2为直推等级
	$c2=$this->execute_dql1("select fenxiao_rank from ydcom_user_yongjin where $z2<=max_rec and $z2>=min_rec");
	//z3为团队推荐满足门槛的人数
	$z3=$this->getgroup_rec($user_id, $z1);
	//c3团推等级
	$c3=$this->execute_dql1("select fenxiao_rank from ydcom_user_yongjin where $z3<=max_group_rec and $z3>=min_group_rec");
	//$user_rank为用户等级
	$user_rank=min($c1,$c2,$c3);
	$gomodel2=$this->gomodel2();
	if ($user_rank<$gomodel2){
		if ($c1>=$gomodel2){
			return $gomodel2;}
			return $c1;}
			//已经达到模式二，
			//如果没有下家就返回模式二的最低等级
			return $user_rank;
			 
}



//返回用户等级，简单
function getuser_rank_simple($user_id) {
	$fenxiao_rank=$this->execute_dql1("select fenxiao_rank from ydcom_users where user_id=$user_id");
	return $fenxiao_rank;
}







//获取用户已付款的等级积分
public function getuser_fukuan_amount($user_id){
	$user_fukuan_amount=0;
	$res=mysql_query("select sum(goods_amount) from ydcom_order_info where user_id=$user_id  and pay_status=2");
	if ($res){
		while ($row=mysql_fetch_array($res)){
			$user_fukuan_amount+=$row[0];
			return $user_fukuan_amount;
		}
	}else{
		return 0;
	}
}


public  function ishave_nextuser($user_id){
	$next_count=$this->execute_dql1("select count(*) from ydcom_users where parent_id=$user_id");
	return $next_count;
}


//返回上家分销等级
  function getup_user_fenxiaorank($user_id){
	$up_user_id=$this->execute_dql1("select parent_id from ydcom_users where user_id=$user_id");
	$up_user_fenxiaorank=$this->getuser_fenxiaorank($up_user_id);
	return $up_user_fenxiaorank;

}


//查询进入模式二的的最低等级
   function gomodel2(){
   	   $res=mysql_query("select min(fenxiao_rank) from ydcom_user_yongjin where cengshu=(-1)");
   	   $row=mysql_fetch_array($res);
   	   $res1=$row[0];
   	   return $res1; 
   }
  
//用户中心的处理函数
//用户中心的处理函数
//用户中心的处理函数
//获取用户分销名称
public function getuser_rank_name($user_id){
	$fenxiao_rank=$this->getuser_fenxiaorank($user_id);
	$res=$this->execute_dql1("select rank_name from ydcom_user_yongjin where fenxiao_rank=$fenxiao_rank");
	return $res;	
}
   
//获取用户能享受的层数
function getuser_level_acount($user_id){
	$fenxiao_rank=$this->getuser_fenxiaorank($user_id);
	$cengshu=$this->execute_dql1("select cengshu from ydcom_user_yongjin where fenxiao_rank=$fenxiao_rank");
	if ($cengshu==-1)return $this->getmodel1_highlayer();
	return $cengshu;
    
}

//显示为第多少层下家
function getwei_level(){
	
	
}

//获取会员的名称
function getuser_wexinname($user_id){
   $nickname=$this->execute_dql1("select nickname from ydcom_wechat_user where ect_uid=$user_id");
   return $nickname;
}

//查询下三层下家id
function getnext_three_id($user_id){
	$up_uid=$user_id;
	$all_ally='';
	for ($i=0;$i<3&!empty($up_uid);$i++){
		$res=mysql_query("select user_id from ydcom_users where parent_id in($up_uid)");
		$up_uid = '';
		while ($rt=mysql_fetch_array($res))
		{
			$up_uid .= $up_uid ? ",'$rt[user_id]'" : "'$rt[user_id]'";
			$all_ally.=$all_ally ? ",'$rt[user_id]'" : "'$rt[user_id]'";
		}
	}
	return $all_ally;
}



//获取上家id
function  getup_user_id($user_id){
	$parent_id=$this->execute_dql1("select parent_id from ydcom_users where user_id=$user_id");
    return $parent_id;
}


//今日日粉丝关注数
function getday_attention_acount($user_id){
	$time1=strtotime('today');
	$time2=time();
	$all_direct_allayid='';
	$isnotattention=0;
	$allcount=0;
	$res=mysql_query("select user_id from ydcom_users where parent_id=$user_id and reg_time>=$time1 and reg_time<=$time2");
	if ($res){
		while ($row=mysql_fetch_array($res)){
			$all_direct_allayid.=$all_direct_allayid ? ",'$row[user_id]'":"'$row[user_id]'";
			//$all_ally.=$all_ally ? ",'$rt[user_id]'" : "'$rt[user_id]'";
		}
	}
	if ($all_direct_allayid){
		$res1=mysql_query("select count(*) from ydcom_wechat_user where ect_uid in($all_direct_allayid) and headimgurl='' ");
	    if ($res1){
	    	while ($row1=mysql_fetch_array($res1)){
	    		$isnotattention=$row1[0];
	    	}
	    }
	    $res2=mysql_query("select count(*) from ydcom_wechat_user where ect_uid in($all_direct_allayid)");
	    if ($res2){
	    	while ($row2=mysql_fetch_array($res2)){
	    		$allcount=$row2[0];
	    	}
	    }
	    
	}
	return $allcount-$isnotattention;
	
	
} 

//昨日粉丝关注数
function getyesterday_attention_acount($user_id){
	$time1=strtotime('yesterday');
	$time2=strtotime('today');
	$all_direct_allayid='';
	$isnotattention=0;
	$allcount=0;
	$res=mysql_query("select user_id from ydcom_users where parent_id=$user_id and reg_time>=$time1 and reg_time<=$time2");
	if ($res){
		while ($row=mysql_fetch_array($res)){
			$all_direct_allayid.=$all_direct_allayid ? ",'$row[user_id]'":"'$row[user_id]'";
			//$all_ally.=$all_ally ? ",'$rt[user_id]'" : "'$rt[user_id]'";
		}
	}
	if ($all_direct_allayid){
		$res1=mysql_query("select count(*) from ydcom_wechat_user where ect_uid in($all_direct_allayid) and headimgurl='' ");
		if ($res1){
			while ($row1=mysql_fetch_array($res1)){
				$isnotattention=$row1[0];
			}
		}
		$res2=mysql_query("select count(*) from ydcom_wechat_user where ect_uid in($all_direct_allayid)");
		if ($res2){
			while ($row2=mysql_fetch_array($res2)){
				$allcount=$row2[0];
			}
		}  
	}
	return $allcount-$isnotattention;

}



//今日收益金额
//每日收益金额
function getday_earningsacount($user_id){
	$time1=strtotime('today');
	$time2=time();
	$day_earningsacount=0;
	$res=mysql_query("select sum(money) from ydcom_fenxiao_log where  user_id=$user_id  and fencheng_time>=$time1 and fencheng_time<=$time2");
	while ($row=mysql_fetch_array($res)){
		$day_earningsacount=$row[0];
	}
	if ($day_earningsacount){
	return $day_earningsacount;
	}else {
		return 0;
	}
}


//昨日收益金额
function getyesterday_earningsacount($user_id){
	$time1=strtotime('yesterday');
	$time2=strtotime('today');
	$day_earningsacount=0;
	$res=mysql_query("select sum(money) from ydcom_fenxiao_log where  user_id=$user_id  and fencheng_time>=$time1 and fencheng_time<=$time2");
	while ($row=mysql_fetch_array($res)){
			$day_earningsacount=$row[0];
		}
	if ($day_earningsacount){
		return $day_earningsacount;
	}else {
		return 0;
	}
}

//推广收益总的
function gettuiguang_earningsacount($user_id){
	$tuiguang_earningsacount=0;
	$res=mysql_query("select sum(money) from ydcom_fenxiao_log where user_id=$user_id  and (separate_type=1  or  separate_type=3)");
	while ($row=mysql_fetch_array($res)){
			$tuiguang_earningsacount=$row[0];
		}
	if ($tuiguang_earningsacount){
			return $tuiguang_earningsacount;
	}else {
		return 0;
	}	
}



//每日付款订单金额
function getday_fukuanmoney($user_id){
	 $time1=strtotime('today');
	 $time2=time();
	 $day_fukuanmoney=0;
	 $res=mysql_query("select sum(order_amount) from ydcom_fenxiao_log where user_id=$user_id  and fencheng_time>=$time1 and fencheng_time<=$time2");
	 while ($row=mysql_fetch_array($res)){
	 		$day_fukuanmoney=$row[0];
	 	}
	 if ($day_fukuanmoney){
	 		return $day_fukuanmoney;
	 }else{
	 	return 0;
	 }
}


//付款订单金额
function getall_fukuanmoney($user_id){
	$fukuanmoney=0;
	$res=mysql_query("select sum(order_amount) from ydcom_fenxiao_log where user_id=$user_id");
	while ($row=mysql_fetch_array($res)){
			$fukuanmoney=$row[0];
		}
	if ($fukuanmoney){
			return $fukuanmoney;
	}else{
		return 0;
	}
}


//退换货订单数
function gettuihuo_order_amount($user_id){
	$tuihuo_order_amount=0;
	$res=mysql_query("select count(*) from ydcom_fenxiao_log where user_id=$user_id and (separate_type=3 or separate_type=4)");
	while ($row=mysql_fetch_array($res)){
		$tuihuo_order_amount=$row[0];
	}
	if ($tuihuo_order_amount){
		return $tuihuo_order_amount;
	}else {
		return 0;
	}
	
}



//每日订单数
function getday_order_amount($user_id){
	$time1=strtotime('today');
	$time2=time();
	$order_amount=0;
	$res=mysql_query("select count(*) from ydcom_fenxiao_log where user_id=$user_id  and fencheng_time>=$time1 and fencheng_time<=$time2");
    if ($res){
    	while ($row=mysql_fetch_array($res)){
    		$order_amount=$row[0];
    	}return $order_amount;
    }else{
    	return 0;
    }

}


//推广订单总数
function getall_order_amount($user_id){
	$order_amount=0;
	$res=mysql_query("select count(*) from ydcom_fenxiao_log where user_id=$user_id ");	
	while ($row=mysql_fetch_array($res)){
			$order_amount=$row[0];
		}
	if ($order_amount){
			return $order_amount;
	}else{
		return 0;
	}

}


//每日退换货金额
function getday_tuihuo_amount($user_id){
	$time1=strtotime('today');
	$time2=time();
	$day_tuihuo_amount=0;
	$res=mysql_query("select sum(money) from ydcom_fenxiao_log  where (separate_type=3 or separate_type=4) and  user_id=$user_id and fencheng_time>=$time1 and fencheng_time<=$time2");
	if($res){
		while ($row=mysql_fetch_array($res)){
		$day_tuihuo_amount=$row[0];
		}return $day_tuihuo_amount;
	}else {
		return 0;
	}
}

//退换货金额
function getall_tuihuo_amount($user_id){
	$all_tuihuo_amount=0;
	$res=mysql_query("select sum(money) from ydcom_fenxiao_log  where separate_type=3 or separate_type=4 and  user_id=$user_id ");
	while ($row=mysql_fetch_array($res)){
			$all_tuihuo_amount=$row[0];
		}
	if($all_tuihuo_amount){
			return $all_tuihuo_amount;
	}else {
		return 0;
	}
}



//获取用户所有下线人数，和id
function getall_allycount_andid($user_id){
	$up_uid=$user_id;
	$all_ally='';
	$count=0;
	for (;!empty($up_uid);){
		$res=mysql_query("select user_id from ydcom_users where parent_id in($up_uid)");
		$up_uid = '';
		while ($rt=mysql_fetch_array($res))
		{
			$up_uid .= $up_uid ? ",'$rt[user_id]'" : "'$rt[user_id]'";
			$all_ally.=$all_ally ? ",'$rt[user_id]'" : "'$rt[user_id]'";
			$count++;
		}
	}
	$res=array($count,$all_ally);
    return $res;
}   





//获取会员拥有人气指数
function getuser_allycount($user_id){
	//查询当前盟友的所有下家人数
	$up_uid=$user_id;
	$count=0;
	for (;!empty($up_uid);){
		$res1=$this->execute_dql("select user_id from ydcom_users where parent_id IN($up_uid) ");
		$up_uid='';
		while ($rt=mysql_fetch_array($res1))
		{
			$up_uid .= $up_uid ? ",'$rt[user_id]'" : "'$rt[user_id]'";
			$count++;
		}
	}
	return $count;
}



//获取直系人气
function getuser_direct_acount($user_id){
	$res=$this->execute_dql1("select count(*) from ydcom_users where parent_id=$user_id ");
    return $res;
}


//获取下家未付款订单能拿到的分佣金和订单id   
function getweifukuan_info($up_uid,$i){
	$weifukuanyongjin=0;
	$weifukuan_order_id='';
	//第一步根据user_id查order_info中的order_id
	$res1 =$this->execute_dql("select order_id  from  ydcom_order_info  where user_id IN($up_uid)   and  pay_status=0");
	while($order_info=mysql_fetch_array($res1)){
		$order_id=$order_info[0];
		$weifukuan_order_id.=$weifukuan_order_id ? ",'$order_info[0]'" : "'$order_info[0]'";
		//第二步根据order_id查order_goods中的goods_id
		$res12=$this->execute_dql("select goods_id,goods_price from ydcom_order_goods where order_id=$order_id ");
		while($row=mysql_fetch_array($res12)){
			$goods_id=$row[0];
			$goods_price=$row[1];
			//第三步根据goods_iD查ydcom_goods中的fengcheng1
			$fencheng1=$this->execute_dql1("select fencheng1 from ydcom_goods where goods_id=$goods_id ");
		    $weifukuanyongjin+=$fencheng1*$goods_price;	
		}
	}
	//计算是第几层的佣金
	$discount=$this->execute_dql1("select discount from ydcom_user_ceng where cengshu=$i");
	$weifukuanyongjin=$weifukuanyongjin*$discount/100;
	$res=array($weifukuanyongjin,$weifukuan_order_id);
	return $res;	
}  

//获取下家已付款订单能拿到的分佣金和订单id
function getyifukuan_info($up_uid,$i){
	$yifukuanyongjin=0;
	$yifukuan_order_id='';
	//第一步根据user_id查order_info中的order_id
	$res1 =$this->execute_dql("select order_id  from  ydcom_order_info  where user_id IN($up_uid)   and  pay_status=2 and (shipping_status=0 or shipping_status=1)");
	while($order_info=mysql_fetch_array($res1)){
		$order_id=$order_info[0];
		$yifukuan_order_id.=$yifukuan_order_id ? ",'$order_info[0]'" : "'$order_info[0]'";
		//第二步根据order_id查order_goods中的goods_id
		$res12=$this->execute_dql("select goods_id,goods_price from ydcom_order_goods where order_id=$order_id ");
		while($row=mysql_fetch_array($res12)){
			$goods_id=$row[0];
			$goods_price=$row[1];
			//第三步根据goods_iD查ydcom_goods中的fengcheng1
			$fencheng1=$this->execute_dql1("select fencheng1 from ydcom_goods where goods_id=$goods_id ");
			$yifukuanyongjin+=$fencheng1*$goods_price;
		}
	}
	//计算是第几层的佣金
	$discount=$this->execute_dql1("select discount from ydcom_user_ceng where cengshu=$i");
	$yifukuanyongjin=$yifukuanyongjin*$discount/100;
	$res=array($yifukuanyongjin,$yifukuan_order_id);
	return $res;
}  
   
//获取下家收货订单能拿到的分佣金和订单id
function getyishouhuo_info($up_uid,$i){
	$yishouhuo=0;
	$yishouhuo_order_id='';
	//第一步根据user_id查order_info中的order_id
	$res1 =$this->execute_dql("select order_id  from  ydcom_order_info  where user_id IN($up_uid)   and  pay_status=2 and  shipping_status=2");
	while($order_info=mysql_fetch_array($res1)){
		$order_id=$order_info[0];
		$yishouhuo_order_id.=$yishouhuo_order_id ? ",'$order_info[0]'" : "'$order_info[0]'";
		//第二步根据order_id查order_goods中的goods_id
		$res12=$this->execute_dql("select goods_id,goods_price from ydcom_order_goods where order_id=$order_id ");
		while($row=mysql_fetch_array($res12)){
			$goods_id=$row[0];
			$goods_price=$row[1];
			//第三步根据goods_iD查ydcom_goods中的fengcheng1
			$fencheng1=$this->execute_dql1("select fencheng1 from ydcom_goods where goods_id=$goods_id ");
			$yishouhuo+=$fencheng1*$goods_price;
		}
	}
	//计算是第几层的佣金
	$discount=$this->execute_dql1("select discount from ydcom_user_ceng where cengshu=$i");
	$yishouhuo=$yishouhuo*$discount/100;
	$res=array($yishouhuo,$yishouhuo_order_id);
	return $res;
}

function getuser_name($user_id){
	$user_name=$this->execute_dql1("select user_name from ydcom_users where user_id=$user_id ");
	return $user_name;
}

public function getuser_headimgurl($user_id){
	$headimgurl=$this->execute_dql1("select headimgurl from ydcom_wechat_user where ect_uid=$user_id");
	return $headimgurl;
}


//模式二用户与上家的佣金差比
function getcha_ratio($user_id){
	$user_fenxiaorank=$this->getuser_fenxiaorank($user_id);
	$up_fenxiaorank=$this->getup_user_fenxiaorank($user_id);
	$user_ratio=$this->execute_dql1("select discount from ydcom_user_yongjin where fenxiao_rank=$user_fenxiaorank ");
	$up_ratio=$this->execute_dql1("select discount from ydcom_user_yongjin where fenxiao_rank=$up_fenxiaorank");
	$cha_ratio=($up_ratio-$user_ratio)/100;
	return $cha_ratio;
}


//获取模式2未付款分佣金信息
function getweifukuan_info_model2($user_id){
	$commission=0;
	$all_order_id='';
	//第一步根据user_id查order_info中的order_id
	$res1 =$this->execute_dql("select order_id  from  ydcom_order_info  where user_id=$user_id   and  pay_status=0");
	while($order_info=mysql_fetch_array($res1)){
		$order_id=$order_info[0];
		$all_order_id.=$all_order_id ? ",'$order_info[0]'" : "'$order_info[0]'";
		//第二步根据order_id查order_goods中的goods_id
		$res12=$this->execute_dql("select goods_id,goods_price from ydcom_order_goods where order_id=$order_id ");
		while($row=mysql_fetch_array($res12)){
			$goods_id=$row[0];
			$goods_price=$row[1];
			//第三步根据goods_iD查ydcom_goods中的fengcheng2
			$fencheng2=$this->execute_dql1("select fencheng2 from ydcom_goods where goods_id=$goods_id ");
		    $commission+=$fencheng2*$goods_price;	
		}		
	}
	$cha_ratio=$this->getcha_ratio($user_id);
	$commission=$cha_ratio*$commission;
	$res=array($commission,$all_order_id);
	return $res;
}


function getyifukuan_info_model2($user_id){
	$commission=0;
	$all_order_id='';
	//第一步根据user_id查order_info中的order_id
	$res1 =$this->execute_dql("select order_id  from  ydcom_order_info  where user_id IN($user_id)   and  pay_status=2  and (shipping_status=0 or shipping_status=1)");
	while($order_info=mysql_fetch_array($res1)){
		$order_id=$order_info[0];
		$all_order_id.=$all_order_id ? ",'$order_info[0]'" : "'$order_info[0]'";
		//第二步根据order_id查order_goods中的goods_id
		$res12=$this->execute_dql("select goods_id,goods_price from ydcom_order_goods where order_id=$order_id ");
		while($row=mysql_fetch_array($res12)){
			$goods_id=$row[0];
			$goods_price=$row[1];
			//第三步根据goods_iD查ydcom_goods中的fengcheng2
			$fencheng2=$this->execute_dql1("select fencheng2 from ydcom_goods where goods_id=$goods_id ");
			$commission+=$fencheng2*$goods_price;
		}
	}
	$cha_ratio=$this->getcha_ratio($user_id);
	$commission=$cha_ratio*$commission;
	$res=array($commission,$all_order_id);
	return $res;
	
	
}

function getyishouhuo_info_model2($user_id){
	$commission=0;
	$all_order_id='';
	//第一步根据user_id查order_info中的order_id
	$res1 =$this->execute_dql("select order_id  from  ydcom_order_info  where user_id IN($user_id)   and  pay_status=2 and shipping_status=2");
	while($order_info=mysql_fetch_array($res1)){
		$order_id=$order_info[0];
		$all_order_id.=$all_order_id ? ",'$order_info[0]'" : "'$order_info[0]'";
		//第二步根据order_id查order_goods中的goods_id
		$res12=$this->execute_dql("select goods_id,goods_price from ydcom_order_goods where order_id=$order_id ");
		while($row=mysql_fetch_array($res12)){
			$goods_id=$row[0];
			$goods_price=$row[1];
			//第三步根据goods_iD查ydcom_goods中的fengcheng2
			$fencheng2=$this->execute_dql1("select fencheng2 from ydcom_goods where goods_id=$goods_id ");
			$commission+=$fencheng2*$goods_price;
		}
	}
	$cha_ratio=$this->getcha_ratio($user_id);
	$commission=$cha_ratio*$commission;
	$res=array($commission,$all_order_id);
	return $res;
}


//已知user_id判断是否关注
public function is_attention($user_id){
   $res=$this->execute_dql("select headimgurl from ydcom_wechat_user where ect_uid=$user_id");
   while ($row=mysql_fetch_array($res)){
        $headimgurl=$row[0];
   }
   if ($headimgurl) {
   	return 1;
   }else{
   	return 0;
   }

}


//获取关注，未关注人数
function getattention_acount($all_ally2){
	$count_all=0;
	$count_wei=0;
	$count_weixin=0;
	$count1=0;
	$count2=0;
	if ($all_ally2){
		$count_all=$this->execute_dql1("select count(*) from ydcom_users  where user_id  in($all_ally2)  ");		
        $res1=$this->execute_dql("select count(*) from ydcom_wechat_user where ect_uid in($all_ally2) and headimgurl=''");
        while ($row=mysql_fetch_array($res1)){
        	$count_wei=$row[0];
        }
        $res2=$this->execute_dql("select count(*) from ydcom_wechat_user where ect_uid in($all_ally2) ");
        while ($row2=mysql_fetch_array($res2)){
        	$count_weixin=$row2[0];
        } 
       /*  $res3=$this->execute_dql("select count(*) from ydcom_wechat_user where ect_uid in($all_ally2)  and headimgurl='' ");
        while ($row3=mysql_fetch_array($res3)){
        	$count_attention=$row3[0];
        } */
    }
    $count1=$count_weixin-$count_wei;
    $count2=$count_all-$count1;
    $res3=array($count1,$count2);  
    return $res3;
}

//已未关注人数
function getattention_acountbyuid($user_id){	
	$all_allayid=$this->getall_allay_id($user_id);
	$res2=$this->getattention_acount($all_allayid);
	return $res2;	
}

//关注的数量

function getattention_acount_direct($user_id){
	$count1=0;
	$count2=0;
	$up_uid=$user_id;
	for (;!empty($up_uid);){
		$res=mysql_query("select user_id from ydcom_users where parent_id in($up_uid)");
		$up_uid = '';
		while ($rt=mysql_fetch_array($res))
		{
			$up_uid.= $up_uid ? ",'$rt[user_id]'" : "'$rt[user_id]'";
			$user_id=$rt[0];
            $res1=$this->is_attention($user_id);
            if ($res1) {
            	$count1++;
            }else {
            	$count2++;
            }
		}
	}
	$res2=array($count1,$count2);
    return $res2;
	
}


//关注的时间
function getuser_attention_time($user_id){
	$attention_time=$this->execute_dql1("select subscribe_time from ydcom_wechat_user where ect_uid=$user_id");
	return $attention_time;
}



//购买后升级,等级积分，和分销等级
function updateuser_fenxiaorankand_rank_points($order_id){
	$user_id=$this->execute_dql1("select user_id from ydcom_order_info where order_id=$order_id");
	$goods_amount=$this->execute_dql1("select goods_amount from ydcom_order_info where order_id=$order_id");
	$rank_points=$this->execute_dql1("select rank_points from ydcom_users where user_id=$user_id");
	//升级
	$rank_points=$rank_points+$goods_amount;
	mysql_query("update ydcom_users set rank_points=$rank_points where user_id=$user_id");
	
	//是否能修改其等级
	$fenxiao_rank_mark=$this->execute_dql1("select fenxiao_rank_mark  from ydcom_users where user_id=$user_id");
	if ($fenxiao_rank_mark==0){
	$fenxiao_rank=$this->getuser_fenxiaorank_true($user_id);
	mysql_query("update ydcom_users set fenxiao_rank=$fenxiao_rank where user_id=$user_id");

	}
}

//退货后降级
function cut_user_fenxiaorankand_rank_points($order_id) {
	$user_id=$this->execute_dql1("select user_id from ydcom_order_info where order_id=$order_id");
	$goods_amount=$this->execute_dql1("select goods_amount from ydcom_order_info where order_id=$order_id");
	$rank_points=$this->execute_dql1("select rank_points from ydcom_users where user_id=$user_id");
	//降级
	$rank_points=$rank_points-$goods_amount;
	mysql_query("update ydcom_users set rank_points=$rank_points where user_id=$user_id");
	
	
	//是否能修改其等级
	$fenxiao_rank_mark=$this->execute_dql1("select fenxiao_rank_mark  from ydcom_users where user_id=$user_id");
	if ($fenxiao_rank_mark==0){
	$fenxiao_rank=$this->getuser_fenxiaorank_true($user_id);
	mysql_query("update ydcom_users set fenxiao_rank=$fenxiao_rank where user_id=$user_id");
	
	}
}







public function close_connect(){
	if(!empty($this->conn)){
		mysql_close($this->conn);
	}
}  




}









?>