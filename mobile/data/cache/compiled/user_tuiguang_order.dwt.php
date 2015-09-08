<?php echo $this->fetch('library/page_header.lbi'); ?>

<div class="con con2">

<header id="header" class="header">

  <div class="user-header">
    <h1 ><?php echo $this->_var['title']; ?></h1>
    <div class="header_l header_return"> <a class="ico_10_3" href="<?php echo url('user/my_tuiguang');?>"> 返回 </a> </div>
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
 

 <section class="user-promote-order">
    
    <div class="category-list">
     <a class="a1<?php if ($this->_var['tab'] == 0): ?> on<?php endif; ?>" href="index.php?m=default&c=user&a=tuiguang_order">全部</a>
     <a class="a2<?php if ($this->_var['tab'] == 1): ?> on<?php endif; ?>" href="index.php?m=default&c=user&a=tuiguang_order1">待收货</a>
     <a class="a2<?php if ($this->_var['tab'] == 2): ?> on<?php endif; ?>" href="index.php?m=default&c=user&a=tuiguang_order2">已收货</a>
     <a class="a2<?php if ($this->_var['tab'] == 3): ?> on<?php endif; ?>" href="index.php?m=default&c=user&a=tuiguang_order3">换货中</a>
     <a class="a2<?php if ($this->_var['tab'] == 4): ?> on<?php endif; ?>" href="index.php?m=default&c=user&a=tuiguang_order4">已退货</a> 
   </div>
   
    <div class="user-promote-order-box">
      <ul>
       
	 <?php $_from = $this->_var['order_list_info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'order_list_infofo');if (count($_from)):
    foreach ($_from AS $this->_var['order_list_infofo']):
?>
        <li>   
          <h4>
            <span class="sp1">订单编号：<?php echo $this->_var['order_list_infofo']['1']; ?></span>
            <span class="statue"><?php echo $this->_var['order_list_infofo']['8']; ?></span>
          </h4>
          
          <dl>
             <dt>
               <a class="image"><img src="/<?php echo $this->_var['order_list_infofo']['7']; ?>" /></a>
               <p class="title"><a><?php echo $this->_var['order_list_infofo']['6']; ?></a></p>
               <p class="time">购买时间：<?php echo $this->_var['order_list_infofo']['5']; ?></p>
               <p class="price-num">
                 <span class="price">￥<em><?php echo $this->_var['order_list_infofo']['2']; ?></em></span>
                 <span class="num"></span>
               </p>
             </dt>
          </dl>
                 
          <h4>
             <span class="id">买家ID<?php echo $this->_var['order_list_infofo']['3']; ?></span>
             <span class="total"><em></em>
               &nbsp;收益￥<?php echo $this->_var['order_list_infofo']['4']; ?>
             </span> 
          </h4>   
        </li>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
       
        
      </ul>
    </div>
    
</section>

<?php echo $this->fetch('library/search.lbi'); ?>
<?php echo $this->fetch('library/user_footer.lbi'); ?>
</body>
</html>