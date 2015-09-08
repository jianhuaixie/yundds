

<dl class="member-list-menu">

  <dt class="first">

    <a href="./<?php if ($_SESSION['user_id'] > 0): ?>?u=<?php echo $_SESSION['user_id']; ?><?php endif; ?>">

       <i class="ico_21"></i>

       <span class="title">首页</span>

    </a>

  </dt>

  

  <dt>

    <a href="<?php echo url('category/top_all');?>">

       <i class="ico_22"></i>

       <span class="title">分类</span>

    </a>

  </dt>

  

  <dt>

    <a href="<?php echo url('flow/cart');?>">

       <i class="ico_23">

       <span class="global-nav__nav-shop-cart-num2" id="carId"><?php 
$k = array (
  'name' => 'cart_info_number',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?></span>

       </i>

    <span class="title">购物车</span>

    </a>

  </dt>

  

  <dt>

    <a href="<?php echo url('user/index');?>">

       <i class="ico_24"></i>

       <span class="title">会员中心</span>

    </a>

  </dt>

  <?php if ($_SESSION['user_id'] > 0): ?>

  <dt class="last">

    <a href="<?php echo url('user/logout');?>">

       <i class="ico_25"></i>

       <span class="title">退出</span>

    </a>

  </dt>

  <?php endif; ?>

</dl>

<div class="menu-bg"></div>

