<?php

require_once 'Helper_virtual.php';
$sqlhelper=new Helper_virtual();

$user_id=$_GET['user_id'];



$user_rank=$sqlhelper->getuser_fenxiaorank($user_id);

$gomodel2_rank=$sqlhelper->gomodel2();

if ($user_rank>=$gomodel2_rank){

	header("location:jin.php?user_id=$user_id");

}

$headimgurl=$sqlhelper->getuser_headimgurl($user_id);

$user_rank_name=$sqlhelper->getuser_rank_name($user_id);



$user_name=$sqlhelper->getuser_name($user_id);

//可享受的层数

$level_acount=$sqlhelper->getuser_level_acount($user_id);



//查询总下家人数和id

$all_allycount_andid=$sqlhelper->getall_allycount_andid($user_id);

$all_allycount=$all_allycount_andid[0];

$all_allyid=$all_allycount_andid[1];



$up_uid=$user_id;

$weifukuan_order_id="";

$yifukuan_order_id="";

$yishouhuo_order_id="";

$weifukuanyongjin_all=0;

$yifukuanyongjin_all=0;

$yishouhuoyongjin_all=0;

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

	} else{ break;}  

	if ($up_uid) {

		/*分销开发未付款的佣金统计*/

		$res1=$sqlhelper->getweifukuan_info($up_uid,$i);

		$weifukuanyongjin_all+=$res1[0];

		if ($res1[1])$weifukuan_order_id.=$weifukuan_order_id?",".$res1[1]:$res1[1];		

			/*分销开发已经付款且未收货佣金统计*/

			$res2=$sqlhelper->getyifukuan_info($up_uid,$i);

			$yifukuanyongjin_all+=$res2[0];

			if ($res2[1])$yifukuan_order_id.=$yifukuan_order_id ? ",".$res2[1] : $res2[1];		

				/*分销开发已收货佣金统计*/

				$res3=$sqlhelper->getyishouhuo_info($up_uid,$i);

				$yishouhuoyongjin_all+=$res3[0];

				if ($res3[1])$yishouhuo_order_id.=$yishouhuo_order_id ? ",".$res3[1] : $res3[1];	

			//分层——得到每层的佣金——我的总的佣金	

         $myyongjin=$weifukuanyongjin_all+$yifukuanyongjin_all+$yishouhuoyongjin_all;

        }

}

$sqlhelper->close_connect();





?>

<!DOCTYPE html>



<html>



<head>



<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



<title>云的商城</title>



<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />



<meta name="apple-mobile-web-app-capable" content="yes" />



<meta name="apple-mobile-web-app-status-bar-style" content="black" />



<meta name="format-detection" content="telephone=no" />



<link href="images/touch-icon.png" rel="apple-touch-icon-precomposed" />



<link href="images/favicon.ico" rel="shortcut icon" type="image/x-icon" />





<link rel="stylesheet" href="data/common/bootstrap/css/bootstrap.min.css">



<link rel="stylesheet" href="data/common/bootstrap/css/font-awesome.min.css">



<link rel="stylesheet" href="themes/default/css/ectouch_red.css">



<link rel="stylesheet" href="themes/default/css/style.css">



<link rel="stylesheet" href="themes/default/css/photoswipe.css">







</head>



<body>



<header id="header" class="header">



  <div class="user-header">



    <h1 >推广中心</h1>



    <div class="header_l header_return"> <a class="ico_10_2" href="javascript:history.go(-1);">返回 </a> </div>



    <!--<div class="header_r header_search"> <a class="ico_18_2" href="javascript:void(0);"> 会员中心菜单</a> </div>-->

  </div>



</header>



<div class="line-top"></div>



<dl class="user_top">



  <dt> <img src="<?php if($headimgurl){echo $headimgurl;}else{echo "images/user_photo.jpg";}?>"/> </dt>



  <dd>



    <p>推广id：<?php echo "$user_id"; ?></p>



    <p>推广等级：<?php echo "$user_rank_name"; ?></p> 



  </dd>



  <div class="user_distri_list">



    <ul>



      <li> 累计推广金：<?php echo number_format($myyongjin,2); ?></li>



    </ul>



  </div>







</dl>







<section class="wrap">



  <div class="list_box radius10" style="padding-top:0;padding-bottom:0;"> 

    <ul>

      <li>
       <div class="title">
        <a  href="ally_list.php?all_ally=<?php  echo "$all_allyid"; ?>"><span class="uninclude">&nbsp; &nbsp; </span><span>我的人气</span> <span class="person"><?php echo "$all_allycount"; ?>人</span></a>
          <div class="son_list">
          <dl>
          </dl>

        </div>

       </div> 

      </li>

      <li>

       <div class="title">

          <a class="rongj"><span class="uninclude">&nbsp; &nbsp; </span><span>我的推广金</span> <span class="person">￥<?php echo number_format($myyongjin,2); ?></span></a>

          <div class="son_list">

          <dl>

            <dt><a href="fenyong_orderlist.php?order_id=<?php echo "$weifukuan_order_id";  ?>&order_status=0"><span class="icon2">&nbsp; &nbsp; </span><span>未付款订单推广金</span> <span class="sp">￥<?php echo number_format($weifukuanyongjin_all,2); ?></span></a></dt>



            <dt><a href="fenyong_orderlist.php?order_id=<?php echo "$yifukuan_order_id";  ?>&order_status=1"><span class="icon2">&nbsp; &nbsp; </span><span>已付款订单推广金</span> <span class="sp">￥<?php echo number_format($yifukuanyongjin_all,2); ?></span></a></dt>



            <dt><a href="fenyong_orderlist.php?order_id=<?php echo "$yishouhuo_order_id";  ?>&order_status=2"><span class="icon2">&nbsp; &nbsp; </span><span>已收货订单推广金</span> <span class="sp">￥<?php echo number_format($yishouhuoyongjin_all,2); ?></span></a></dt>
            <dt><a href="index.php?m=default&c=user&a=fenxiang">&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;<span>我的推广二维码</span></a></dt>
          </dl>

        </div>

       </div> 

      </li>

    </ul>

  </div>

  <div class="list_box padd1 radius10" style="padding-top:0;padding-bottom:0;"> 



 </div>



</section>

<div id="content" class="footer mr-t20">

  <p class="region"> 

     

   © 2005-2015 云的商城 版权所有，并保留所有权利。 </p>

</div>

<script type="text/javascript" src="data/common/js/jquery.min.js" ></script> 

<script type="text/javascript" src="themes/default/js/sara.js"></script>

</body>



</html>



<?php 





?>







