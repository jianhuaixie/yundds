<?php

require_once 'Helper_virtual.php';
$sqlhelper=new Helper_virtual();
$all_ally = $_GET['all_ally'];
$all_ally2 = stripslashes($all_ally);
$res333=$sqlhelper->getattention_acount($all_ally2);
$count1111=$res333[0];
$count22222=$res333[1];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
<script type="text/javascript" src="themes/default/js/jquery-1.9.1.min.js"></script>
</head>
<body>
<header id="header" class="header">
  <div class="user-header">
    <h1 >我的人气</h1>
    <div class="header_l header_return"> <a class="ico_10_2" href="javascript:history.go(-1);"> 返回 </a> </div>
    <!--<div class="header_r header_search"> <a class="ico_18_2" href="javascript:void(0);"> 会员中心菜单</a> </div>-->
  </div>
</header>
<div class="line-top"></div>
<section class="user_order_list">  
    <div class="category-list">
     <a class="a1 on" href="#">已关注:<?php if($count1111){echo $count1111;}else {echo 0;}?></a>
     <a class="a2" href="#">未关注:<?php if ($count22222){echo $count22222;}else {echo 0;}?></a>  
   </div> 
	<div class="ect-pro-list user-order" style="border-bottom:none;"> 
	       <!--已关注 start-->
		<ul id="J_ItemList">
           <li>
             <dl>
<?php 	


	

	
	
	
	
	
	
if ($all_ally2){
$res123321=$sqlhelper->execute_dql("select user_name,reg_time from ydcom_users  where user_id  in($all_ally2) ");
while ($row123321=mysql_fetch_row($res123321)){
$ally_name=$row123321[0];	
$time=$row123321[1];
//反过来查看当前的下家id
$res1=$sqlhelper->execute_dql("select user_id from ydcom_users where reg_time=$time ");	
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
		$res2=$sqlhelper->execute_dql("select user_id from ydcom_users where parent_id IN($up_uid) ");
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

$attention_time=$sqlhelper->is_attention($user_id);	
$heaimg_url=$sqlhelper->getuser_headimgurl($user_id);
if ($attention_time){
//微信名称
$nickname=$sqlhelper->execute_dql1("select nickname from ydcom_wechat_user where ect_uid=$user_id");
	  ?>
               <dt>
                   <span class="sp1"><img src="<?php echo $heaimg_url?>"></span>
                   <span class="sp2">粉丝微信：<?php if ($nickname){echo "$nickname";}else {echo "$ally_name";}?></span>
                   <span class="sp2">关注日期：<?php  echo date('Y-m-d H:i:s',$attention_time);?></span>
                   <span class="sp2">人气指数：<?php echo "$all_count"; ?></span>
               </dt>
       <?php 
       }
}        
}
       
       



        ?>
              </dl>
          </li>
		</ul>
        <!--已关注 end-->
        <!--未关注 start-->
		<ul id="J_ItemList">
           <li>
             <dl>
           <?php 
             
             
             
             
             
             
           if ($all_ally2){
           	$res123321=$sqlhelper->execute_dql("select user_name,reg_time from ydcom_users  where user_id  in($all_ally2) ");
           	while ($row123321=mysql_fetch_row($res123321)){
           		$ally_name=$row123321[0];
           		$time=$row123321[1];
           		//反过来查看当前的下家id
           		$res1=$sqlhelper->execute_dql("select user_id from ydcom_users where reg_time=$time ");
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
           				$res2=$sqlhelper->execute_dql("select user_id from ydcom_users where parent_id IN($up_uid) ");
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
           		$attention_time=$sqlhelper->is_attention($user_id);
           		if (!$attention_time){
           	  ?>
               <dt>
                   <span class="sp1"><img src="images/user_photo.jpg"></span>
                   <span class="sp2">粉丝名称：<?php echo "$ally_name";?></span>
                   <span class="sp2">人气指数：<?php echo "$all_count"; ?></span>
               </dt>
                  <?php 
           }
           }        
           }            
             
             
             


               
               
               
               
               
               
               
               
               
               
               
   ?>            
             </dl>
          </li>
		</ul>
        <!--未关注 end-->
        
	</div>
</section>
<script type="text/javascript">
    $(".category-list a").removeClass("on");
	$(".category-list a:first").addClass("on");
	$(".user-order li").css("display","none");
	$(".user-order li:first").css("display","block");
	$(".category-list a").click(function(){
		    var a=$(this).index();
		    $(".category-list a").removeClass("on");
			$(this).addClass("on");
			$(".user-order li").css("display","none");
			$(".user-order li").eq(a).css("display","block");
		})
</script>
<?php

 







?>
<div id="content" class="footer mr-t20">
  <p class="region">  
   © 2005-2015 云的商城 版权所有，并保留所有权利。 </p>
</div>
</body>
</html>
<?php



?>