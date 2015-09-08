<?php echo $this->fetch('library/page_header.lbi'); ?>
<div class="con">
<!--
 <div class="ect-bg">
  <header class="ect-header ect-margin-tb ect-margin-lr text-center ect-bg icon-write">
     <a href="javascript:history.go(-1)" class="pull-left ico_10"></a> 
     <span><?php echo $this->_var['title']; ?></span> 
     <a href="javascript:;" onClick="openMune()" class="pull-right ect-icon ect-icon1 ect-icon-mune"></a>
 </header>
  <nav class="ect-nav ect-nav-list" style="display:none;">
    <ul class="ect-diaplay-box text-center">
      <li class="ect-box-flex"><a href="index.php?a=index"><i class="ect-icon ect-icon-home"></i><?php echo $this->_var['lang']['home']; ?></a></li>
      <li class="ect-box-flex"><a href="<?php echo url('category/top_all');?>"><i class="ect-icon ect-icon-cate"></i><?php echo $this->_var['lang']['category']; ?></a></li>
      <li class="ect-box-flex"><a href="javascript:openSearch();"><i class="ect-icon ect-icon-search"></i><?php echo $this->_var['lang']['search']; ?></a></li>
      <li class="ect-box-flex"><a href="<?php echo url('flow/cart');?>"><i class="ect-icon ect-icon-flow"></i><?php echo $this->_var['lang']['shopping_cart']; ?></a></li>
      <li class="ect-box-flex"><a href="<?php echo url('user/index');?>"><i class="ect-icon ect-icon-user"></i><?php echo $this->_var['lang']['user_center']; ?></a></li>
    </ul>
  </nav>
-->

<header id="header" class="header">
  <div class="user-header">
    <h1 ><?php echo $this->_var['title']; ?></h1>
    <div class="header_l header_return"> <a class="ico_10_3" href="./<?php if ($_SESSION['user_id'] > 0): ?>?u=<?php echo $_SESSION['user_id']; ?><?php endif; ?>"> 返回 </a> </div>
   <div class="header_r header_search"> <a class="ico_18_3" href="./<?php if ($_SESSION['user_id'] > 0): ?>?u=<?php echo $_SESSION['user_id']; ?><?php endif; ?>"> 会员中心菜单</a> </div>
    
   
  </div>
</header>
<!--<dl class="member-list-menu2">
  <dt class="first">
    <a href="./<?php if ($_SESSION['user_id'] > 0): ?>?u=<?php echo $_SESSION['user_id']; ?><?php endif; ?>">
       <span class="title">返回首页</span>
    </a>
  </dt>
  <dt>
    <a href="<?php echo url('user/index');?>">
       <span class="title">个人中心</span>
    </a>
  </dt>
</dl>
<div class="menu-bg3"></div>-->
<div class="line-top"></div>
 
<dl class="user_top">
  <dt> <?php if ($this->_var['info']['avatar']): ?><img src="<?php echo $this->_var['info']['avatar']; ?>"><?php elseif ($this->_var['info']['headimgurl']): ?><img src="<?php echo $this->_var['info']['headimgurl']; ?>"><?php else: ?><img src="data/common/images/get_avatar.png"><?php endif; ?> </dt>
  <dd>
    <p><?php if ($this->_var['info']['nicheng']): ?>昵称：<?php echo $this->_var['info']['nicheng']; ?><?php elseif ($this->_var['info']['nickname']): ?>昵称：<?php echo $this->_var['info']['nickname']; ?><?php else: ?><?php echo $this->_var['info']['username']; ?><?php endif; ?>

     | <a href="<?php echo url('user/logout');?>" class="ect-colorf"><?php echo $this->_var['lang']['label_logout']; ?></a></p>

	<p><span>ID：yd<?php echo $_SESSION['user_id']; ?></span></p>
    <p><span>会员等级：<?php echo $this->_var['rank_name']; ?></span></p>

    <!--<p><span><?php echo $this->_var['info']['integral']; ?><?php echo $this->_var['info']['integral_name']; ?></span></p>-->
  </dd>
  <div class="user_top_list">
    <ul>

    

      <li>

       <a href="<?php echo url('user/collection_list');?>">

        <span class="sp1"><?php 
$k = array (
  'name' => 'collection_num',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?></span>

        <span class="sp2">关注的商品</span>

       </a>

      </li>

      <li>

        <a href="<?php echo url('user/history_list');?>">

         <span class="sp1"><?php 
$k = array (
  'name' => 'history_num',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?></span>

         <span class="sp2">浏览记录</span>

        </a>

      </li>

      <li class="last">

       <a href="<?php echo url('user/msg_list');?>">

        <span class="sp1"><?php 
$k = array (
  'name' => 'msg_num_all',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?></span>

        <span class="sp2">我的消息</span>

       </a>

      </li>

      

    </ul>

  </div>



</dl>

<div class="blank2"></div>





<section class="user2_list">

   <ul>

   

     <li class="first">

       <a class="title" href="<?php echo url('user/order_list');?>">

          <em><img src="themes/default/images/user_title_icon1.png" /></em>

          <span class="sp1">我的订单</span>

          <i></i>

          <span class="sp2">查看全部订单</span>

       </a>

       <dl class="dl1">

         <dt>

            <a href="<?php echo url('user/not_pay_order_list');?>"> 

              <span class="sp1"><img src="themes/default/images/user_order_icon1.png" />

              <strong><?php 
$k = array (
  'name' => 'not_pay_order_list_num',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?></strong>

              </span>

              <span class="sp2">待付款</span>

         	</a>

         </dt>

         <dt>

            <a href="<?php echo url('user/to_receive_order_list');?>">

              <span class="sp1"><img src="themes/default/images/user_order_icon2.png" />

              <strong><?php 
$k = array (
  'name' => 'to_receive_order_list_num',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?></strong>

              </span>

              <span class="sp2">待收货</span>

            </a>

         </dt>

         <dt>

            <a href="<?php echo url('user/to_comment_order_list');?>">

              <span class="sp1"><img src="themes/default/images/user_order_icon3.png" />

               <strong><?php 
$k = array (
  'name' => 'to_comment_order_list_num',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?></strong>

              </span>

              <span class="sp2">待评价</span>

            </a>

         </dt>

         <dt>

            <a href="<?php echo url('user/to_return_order_list');?>">

              <span class="sp1"><img src="themes/default/images/user_order_icon4.png" />

               <strong><?php 
$k = array (
  'name' => 'to_return_order_list_num',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?></strong>

              </span>

              <span class="sp2">返修/退换</span>

            </a>

         </dt>

       </dl>

     </li>

     

     

     

     

     <li>

       <a class="title" href="<?php echo url('user/account_detail');?>">

          <em><img src="themes/default/images/user_title_icon2.png" /></em>

          <span class="sp1">我的钱包</span>

          <i></i>

          <!--<span class="sp2">查看全部订单</span>-->

       </a>

       <dl class="dl2">

         <dt>

            <a href="<?php echo url('user/account_detail');?>" class="a1">

              <span class="sp1"><?php echo $this->_var['info']['surplus2']; ?></span>

              <span class="sp2">账户余额</span>

            </a>

         </dt>

         

         <dt>

            <a>

              <span class="sp1"><?php echo $this->_var['info']['integral']; ?></span>

              <span class="sp2">积分</span>

            </a>

         </dt>

         

         <dt>

            <a class="a3" href="<?php echo url('user/my_bonus');?>">

              <span class="sp1"><?php 
$k = array (
  'name' => 'user_bonus_num',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?></span>

              <span class="sp2">优惠券</span>

            </a>

         </dt>



       </dl>

     </li>

     

     
     <div class="clear"></div>
     <li class="member">
       <a class="title" href="<?php echo url('user/my_tuiguang');?>">
          <em><img src="themes/default/images/user_title_icon3.png" /></em>
          <span class="sp1">我的推广中心</span>
          <i></i>
       </a>
     </li>
     


     <div class="clear"></div>

     

     <li class="member">

       <a class="title" href="<?php echo url('user/my_setting');?>">

          <em><img src="themes/default/images/user_title_icon5.png" /></em>

          <span class="sp1">个人设置</span>

          <i></i>

          <!--<span class="sp2">查看全部订单</span>-->

       </a>

      

     </li>

     
     
     

     <li class="member">
       <a class="title" href="index.php?m=default&c=Poster&a=poster&user_id=<?php echo $this->_var['user_id']; ?>">
          <em><img src="themes/default/images/user_title_icon5.png" /></em>
          <span class="sp1">我的二维码</span>
          <i></i>
          <!--<span class="sp2">查看全部订单</span>-->

       </a>
     </li>
     
    
     

     <li class="member">
       <a class="title" href="index.php?m=default&c=Poster&a=playbill&user_id=<?php echo $this->_var['user_id']; ?>">
          <em><img src="themes/default/images/user_title_icon5.png" /></em>
          <span class="sp1">我的推广海报</span>
          <i></i>
          <!--<span class="sp2">查看全部订单</span>-->

       </a>
     </li>
     	

     

     <li class="member">

       <a class="title" href="<?php echo url('user/bd_new');?>">

          <em><img src="themes/default/images/user_title_icon5.png" /></em>

          <span class="sp1">账号绑定</span>
          <i></i>

       </a>
     </li>
      

     <li>

       <a class="title" href="<?php echo url('user/service');?>">

          <em><img src="themes/default/images/user_title_icon6.png" /></em>

          <span class="sp1">意见反馈</span>

          <i></i>

          <!--<span class="sp2">查看全部订单</span>-->

       </a>

      

     </li>

     

     

     

   </ul>

</section>





 

   

</div>

<?php echo $this->fetch('library/search.lbi'); ?> <?php echo $this->fetch('library/user_footer.lbi'); ?> 

</body>

</html>

