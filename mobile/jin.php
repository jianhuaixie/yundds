<?php



require_once 'Helper_virtual.php';
$sqlhelper=new Helper_virtual();
$user_id=$_GET['user_id'];
$user_id1111=$user_id;
$user_rank=$sqlhelper->getuser_fenxiaorank($user_id);
$user_rank_name=$sqlhelper->getuser_rank_name($user_id);
$user_name=$sqlhelper->getuser_name($user_id);
//可享受的层数
$level_acount=$sqlhelper->getuser_level_acount($user_id);
//查询总下家人数和id
$all_allycount_andid=$sqlhelper->getall_allycount_andid($user_id);
$all_allycount=$all_allycount_andid[0];
$all_allyid=$all_allycount_andid[1];
$up_uid=$user_id;
$weifukuan_order_id_yin="";
$yifukuan_order_id_yin="";
$yishouhuo_order_id_yin="";
$myyongjin_yin=0;
$weifukuanyongjin_yin=0;
$yifukuanyongjin_yin=0;
$yishouhuoyongjin_yin=0;
for ($i = 1; $i<=$level_acount; $i++)
{   
	if ($up_uid)
	{
		$res=$sqlhelper->execute_dql("select user_id from ydcom_users   where parent_id in($up_uid)");
		$up_uid = '';
		while ($rt=mysql_fetch_array($res))
		{
			$up_uid.= $up_uid ? ",'$rt[user_id]'" : "'$rt[user_id]'";
		}
	}else{ break;}  
	if ($up_uid) {
		/*分销开发未付款的佣金统计*/
		$res1=$sqlhelper->getweifukuan_info($up_uid,$i);
		$weifukuanyongjin_yin+=$res1[0];
		if ($res1[1])$weifukuan_order_id_yin.=$weifukuan_order_id_yin?",".$res1[1]:$res1[1];		
			/*分销开发已经付款且未收货佣金统计*/
			$res2=$sqlhelper->getyifukuan_info($up_uid,$i);
			$yifukuanyongjin_yin+=$res2[0];
			if ($res2[1])$yifukuan_order_id_yin.=$yifukuan_order_id_yin ? ",".$res2[1] : $res2[1];		
				/*分销开发已收货佣金统计*/
				$res3=$sqlhelper->getyishouhuo_info($up_uid,$i);
				$yishouhuoyongjin_yin+=$res3[0];
				if ($res3[1])$yishouhuo_order_id_yin.=$yishouhuo_order_id_yin ? ",".$res3[1] : $res3[1];	
        }
}

$myyongjin_yin=$weifukuanyongjin_yin+$yifukuanyongjin_yin+$yishouhuoyongjin_yin;

//金牌佣金
//金牌佣金
$up_uid=$user_id;
$weifukuanyongjin_jin=0;
$yifukuanyongjin_jin=0;
$yishouhuoyongjin_jin=0;
$weifukuan_order_id_jin="";
$yifukuan_order_id_jin="";
$yishouhuo_order_id_jin="";
$myyongjin_jin=0;
$gomodel2_minrank=$sqlhelper->gomodel2();
for ($i = 1;$i<6; $i++)
{
	if ($up_uid)
	{
		$res=$sqlhelper->execute_dql("select user_id from  ydcom_users  where parent_id in($up_uid)");
		$up_uid = '';
		//取每一层，一个一个取
		while ($rt=mysql_fetch_array($res))
		{    
			$user_id=$rt[0];
			//当前uid的分销等级
			$user_rank=$sqlhelper->getuser_fenxiaorank($user_id);
			$up_user_rank=$sqlhelper->getup_user_fenxiaorank($user_id);
			//和上家的等级比较
		  if($up_user_rank>$user_rank and $up_user_rank>=$gomodel2_minrank){
			/*分销开发未付款的佣金统计*/
			$res1=$sqlhelper->getweifukuan_info_model2($user_id);
			$weifukuanyongjin_jin+=$res1[0];
			if ($res1[1])$weifukuan_order_id_jin.=$weifukuan_order_id_jin?",".$res1[1]:$res1[1];
				
			   /*分销开发已经付款且未收货佣金统计*/
		        $res2=$sqlhelper->getyifukuan_info_model2($user_id);
		        $yifukuanyongjin_jin+=$res2[0];
		        if ($res2[1])$yifukuan_order_id_jin.=$yifukuan_order_id_jin ? ",".$res2[1] : $res2[1];	  

					   /*分销开发已收货佣金统计*/
				        $res3=$sqlhelper->getyishouhuo_info_model2($user_id);
				        $yishouhuoyongjin_jin+=$res3[0];
				        if ($res3[1])$yishouhuo_order_id_jin.=$yishouhuo_order_id_jin ? ",".$res3[1] : $res3[1];
				        
			   //如果比上家，，，必须是上家，比上家低，，接受他的user_id,做为下个循环的父id
			   $up_uid .= $up_uid? ",'$rt[user_id]'" : "'$rt[user_id]'";
			  }
	    }
	}
}
$myyongjin_jin=$weifukuanyongjin_jin+$yifukuanyongjin_jin+$yishouhuoyongjin_jin;
$all_yongjin=$myyongjin_yin+$myyongjin_jin;
$sqlhelper->close_connect();
?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

<meta name="apple-mobile-web-app-capable" content="yes" />

<meta name="apple-mobile-web-app-status-bar-style" content="black" />

<meta name="format-detection" content="telephone=no" />

<link href="images/touch-icon.png" rel="apple-touch-icon-precomposed" />

<link href="images/favicon.ico" rel="shortcut icon" type="image/x-icon" />

<link href="ectouch.css?id=1212" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="{$ectouch_themes}/js/jquery-1.4.4.min.js"></script>



</head>

<body>

<header id="header">

 <div class="user-header">

  <h1> 推广中心 </h1>

  <div class="header_l header_return"> <a class="ico_10" href="javascript:history.go(-1);"> 返回 </a> </div>

  <div class="header_r header_search"> <a class="ico_18" href="javascript:void(0);"> 会员中心菜单</a> </div>

 </div>

</header>

<div class="line-top"></div>

<dl class="user_top">

  <dt> <img src="images/user_photo.jpg"> </dt>

  <dd>

    <p>推广id：<?php echo "$user_id1111"; ?></p>

    <p>推广等级：<?php echo "$user_rank_name"; ?></p> 

  </dd>

  <div class="user_distri_list">

    <ul>

      <li> 累计推广金：<?php echo number_format($all_yongjin,2); ?></li>

    </ul>

  </div>



</dl>



<section class="wrap">

  <div class="list_box radius10" style="padding-top:0;padding-bottom:0;"> 

    <ul>

	

      <li>

       <div class="title">

        <span class="uninclude">&nbsp; &nbsp; </span><a  href="ally_list.php?all_ally=<?php  echo "$all_allyid"; ?>"><span>我的人气</span> <span class="person"><?php echo "$all_allycount"; ?>人</span></a>

          <div class="son_list">

          <dl>

          </dl>
        </div>

       </div> 

      </li>



      <li>

       <div class="title">

        <span class="uninclude">&nbsp; &nbsp; </span><span>我的白银推广金</span> <span class="person">￥<?php echo number_format($myyongjin_yin,2); ?></span>

          <div class="son_list">

          <dl>

            <dt><a href="fenyong_orderlist.php?order_id=<?php echo "$weifukuan_order_id_yin";  ?>&order_status=0"><span class="icon2">&nbsp; &nbsp; </span><span>未付款订单推广金</span> <span class="sp">￥<?php echo number_format($weifukuanyongjin_yin,2); ?></span></a></dt>

            <dt><a href="fenyong_orderlist.php?order_id=<?php echo "$yifukuan_order_id_yin";  ?>&order_status=1"><span class="icon2">&nbsp; &nbsp; </span><span>已付款订单推广金</span> <span class="sp">￥<?php echo number_format($yifukuanyongjin_yin,2); ?></span></a></dt>

            <dt><a href="fenyong_orderlist.php?order_id=<?php echo "$yishouhuo_order_id_yin";  ?>&order_status=2"><span class="icon2">&nbsp; &nbsp; </span><span>已收货订单推广金</span> <span class="sp">￥<?php echo number_format($yishouhuoyongjin_yin,2); ?></span></a></dt>


          </dl>

        </div>

       </div> 

      </li>

      

            <li>

       <div class="title">

        <span class="uninclude">&nbsp; &nbsp; </span><span>我的黄金推广金</span> <span class="person">￥<?php echo number_format($myyongjin_jin,2); ?></span>

          <div class="son_list">

          <dl>

            <dt><a href="fenyong_orderlist.php?order_id=<?php echo "$weifukuan_order_id_jin";  ?>&order_status=0"><span class="icon2">&nbsp; &nbsp; </span><span>未付款订单推广金</span> <span class="sp">￥<?php echo number_format($weifukuanyongjin_jin,2); ?></span></a></dt>

            <dt><a href="fenyong_orderlist.php?order_id=<?php echo "$yifukuan_order_id_jin";  ?>&order_status=1"><span class="icon2">&nbsp; &nbsp; </span><span>已付款订单推广金</span> <span class="sp">￥<?php echo number_format($yifukuanyongjin_jin,2); ?></span></a></dt>

            <dt><a href="fenyong_orderlist.php?order_id=<?php echo "$yishouhuo_order_id_jin";  ?>&order_status=2"><span class="icon2">&nbsp; &nbsp; </span><span>已收货订单推广金</span> <span class="sp">￥<?php echo number_format($yishouhuoyongjin_jin,2); ?></span></a></dt>


          </dl>

        </div>

       </div> 

      </li>



    </ul>

  </div>

  <div class="blank3"></div>

  <div class="blank3"></div>

  <div class="list_box padd1 radius10" style="padding-top:0;padding-bottom:0;"> 

 </div>

</section>

</body>

</html>

<?php 











?>