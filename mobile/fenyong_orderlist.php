
<?php
require_once 'Helper_virtual.php';
$sqlhelper=new Helper_virtual();
$order_id=$_GET['order_id'];
$order_id2 = stripslashes($order_id);
$order_status=$_GET['order_status'];
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
<body >

<header id="header" class="header">

  <div class="user-header">

    <h1 >我的佣金</h1>

    <div class="header_l header_return"> <a class="ico_10_2" href="javascript:history.go(-1);"> 返回 </a> </div>

    <!--<div class="header_r header_search"> <a class="ico_18_2" href="javascript:void(0);"> 会员中心菜单</a> </div>-->
  </div>

</header>
<div class="line-top"></div>
<?php 

if($order_id){

$res=$sqlhelper->execute_dql("select order_sn,user_id,goods_amount,add_time from ydcom_order_info  where order_id in($order_id2)");
while($row=mysql_fetch_row($res)){
   $order_sn=$row[0];
   $order_amount=$row[2];
   $user_id=$row[1];
    $order_time=$row[3];
   $order_user_name=$sqlhelper->execute_dql1("select user_name from ydcom_users where user_id=$user_id");
                //反过来判断当前的订单id
                $res1=$sqlhelper->execute_dql("select order_id from ydcom_order_info where order_sn=$order_sn");
				$row1=mysql_fetch_array($res1);
				$order_id=$row1[0];
				$res12=$sqlhelper->execute_dql("select goods_id from ydcom_order_goods where order_id=$order_id "); 
				while($row=mysql_fetch_array($res12)){
					$goods_id=$row[0];
					$img_url=$sqlhelper->execute_dql1("select goods_img from ydcom_goods where goods_id=$goods_id ");
				}
   ?>
 <section class="user_order_list">
	<div class="ect-pro-list user-order" style="border-bottom:none;">
		<ul id="J_ItemList">
           <li>
             <div><span>我的盟友：<?php echo"$order_user_name";?></span></div>
             <dl>
               <dt>
                 
                   <span class="sp1"><img src="/<?php  echo "$img_url";?>"></span>
                   <span class="sp2">订单状态：<strong class="ect-color"><?php 
                   if ($order_status==0){
echo "未付款";
}elseif ($order_status==1){
echo "已付款";
}elseif ($order_status==2){
echo  "已收货";
}
                   ?></strong></span>
                   <span class="sp2">订单金额：<strong class="ect-color"><?php echo"$order_amount";?></strong></span>
                   <span class="sp2">下单时间：<strong class="ect-color"><?php  echo date('Y-m-d ',$order_time);?></strong></span>
               </dt>
             </dl>
          </li>
       
		</ul>
	</div>
</section>
   <?php   
   
   
	
}

}

else {
	?>
    
	<div class="notics"><span>暂无记录</span></div>
	
	<?php	
}

?>
<div id="content" class="footer mr-t20">
  <p class="region"> 
     
   © 2005-2015 云的商城 版权所有，并保留所有权利。 </p>
</div>
</body></html>
<?php 




?>