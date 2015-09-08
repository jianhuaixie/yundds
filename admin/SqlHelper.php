<?php
class SqlHelper {
  public  $conn;
  public  $dbname="b628382c97124173dd283bf7b83f1eec";
  public $username="yundds";
  public $password="9e47deb4b058d4829b214caac3b7f3e5";
  public $host="rdsed8t8e7bzxpvu78nx.mysql.rds.aliyuncs.com:3306";
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
	$res1 =$this->execute_dql("select order_id  from  ydcom_order_info  where user_id IN($up_uid)   and  pay_status=2");
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
	$res1 =$this->execute_dql("select order_id  from  ydcom_order_info  where user_id IN($user_id)   and  pay_status=2");
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
   $res=$this->execute_dql("select subscribe_time from ydcom_wechat_user where ect_uid=$user_id");
   if (!$res){return 0;}
   else{
	while ($row=mysql_fetch_array($res)){
		$time=$row[0];
		if ($time==0)return 0;
		return $time;
	}
   }

}


//获取关注，未关注人数
function getattention_acount($all_ally2){
	$count=0;
	$count2=0;
	if ($all_ally2){
		$res123321=$this->execute_dql("select user_name,reg_time from ydcom_users  where user_id  in($all_ally2) ");
		while ($row123321=mysql_fetch_row($res123321)){
			$ally_name=$row123321[0];
			$time=$row123321[1];
			//反过来查看当前的下家id
			$res1=$this->execute_dql("select user_id from ydcom_users where reg_time=$time ");
			while ($row1=mysql_fetch_array($res1)){
				$user_id=$row1[0];
				//查询当前盟友的所有下家
				$all_count=0;
				$up_uid=$user_id;
				$i=0;
				while($i<=100)
				{    $i++;
				$count = 0;
				while ($up_uid)
				{
					$res2=$this->execute_dql("select user_id from ydcom_users where parent_id IN($up_uid) ");
					$up_uid = '';
					while ($rt=mysql_fetch_array($res2))
					{
						$up_uid .= $up_uid ? ",'$rt[user_id]'" : "'$rt[user_id]'";
						$count++;
					}
				}
				$all_count+=$count;
				}
			}
			$attention_time=$this->is_attention($user_id);
            if ($attention_time){
            	$count1++;
            }else {
            	$count2++;
            }
			
			
	           }        
	           } 
	
$res333=array($count1,$count2);
return $res333;
	
}



public function close_connect(){
	if(!empty($this->conn)){
		mysql_close($this->conn);
	}
}  

	
}

?>