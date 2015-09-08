<?php echo $this->fetch('library/page_header.lbi'); ?>

<div class="con">

<header id="header" class="header">
  <div class="user-header">
    <h1 >收益概况</h1>
    <div class="header_l header_return"> <a class="ico_10_3" href="javascript:history.go(-1);"> 返回 </a> </div>
    <div class="header_r header_search"> <a class="ico_helf" href="javascript:void(0);"> 会员中心菜单</a> </div>
  </div>

</header>

<dl class="member-list-menu2">
  <dt class="first">
    <p style="margin-bottom:10px; font-size:1.1em;">相关说明:</p>
    <p style="color:#666;"> 1、销售金额是当月所有推广订单的成交总额</p>
    <p style="color:#666;"> 2、收益金额是当月所有推广订单的收益总额</p>
  </dt>
</dl>

<div class="menu-bg3"></div>
<div class="line-top"></div>

 <section class="user-accounts">
    
    <div class="category-list category-list4">
     <a class="a1">日期</a>
     <a class="a2">销售金额</a>
     <a class="a2">订单数</a>
     <a class="a2">收益金额</a>
     <a class="last">&nbsp;</a>  
   </div>
   

    <div class="user-accounts-box user-accounts-box4">
      <ul>
 
        <?php if ($this->_var['order_amount_August'] != 0): ?>
         <li>
           <div>
           <a href="index.php?m=default&c=user&a=earnings_detail2&mon=8">
             <span class="a1">2015-08</span>
             <span class="a1">￥<em><?php echo $this->_var['order_amount_August']; ?></em></span>
             <span class="a1">2</span>
             <span class="a3">￥<em><?php echo $this->_var['money_August']; ?></em></span>
             <span  class="last"><i></i></span>
            </a>
          </div>
        </li>
        <?php endif; ?> 
        
        
        <?php if ($this->_var['order_amount_July'] != 0): ?>
         <li>
           <div>
           <a href="index.php?m=default&c=user&a=earnings_detail2&mon=7">
             <span class="a1">2015-07</span>
             <span class="a1">￥<em><?php echo $this->_var['order_amount_July']; ?></em></span>
             <span class="a1">3</span>
             <span class="a3">￥<em><?php echo $this->_var['money_July']; ?></em></span>
             <span  class="last"><i></i></span>
            </a>
          </div>
        </li>
       <?php endif; ?> 
        
      </ul>
    </div>

  
    <div class="user-accounts-bottom">
      <p>
       <span class="sp1">销售总额<em><?php echo $this->_var['order_amount_all']; ?></em></span>
       <span class="sp2">收益总额<em><?php echo $this->_var['money_all']; ?></em></span>
       <span class="sp3">收益总额<em><?php echo $this->_var['money_all']; ?></em></span>
      </p>
    </div>
    
  
  
</section>

</div>
<?php echo $this->fetch('library/user_footer3.lbi'); ?>
</body>
</html>