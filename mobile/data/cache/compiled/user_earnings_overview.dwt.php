<?php echo $this->fetch('library/page_header.lbi'); ?>

<div class="con">
<header id="header" class="header">
  <div class="user-header">
    <h1 >结算概况</h1>
    <div class="header_l header_return"> <a class="ico_10_3" href="<?php echo url('user/my_tuiguang');?>"> 返回 </a> </div>
    <div class="header_r header_search"> <a class="ico_helf" href="javascript:void(0);"> 会员中心菜单</a> </div>
  </div>

</header>

<!--
<dl class="member-list-menu2">
  <dt class="first">
    <p style="margin-bottom:10px; font-size:1.1em;">相关说明:</p>
    <p style="color:#666;"> 1、已关注数是所有已关注官方微信的粉丝数</p>
    <p style="color:#666;"> 2、未关注数是所有未关注官方微信的粉丝数</p>
    <p style="color:#666;"> 3、列表用户只显示自己每层的粉丝数，最多可浏览三层</p>
   
  </dt>

</dl>
-->

<div class="menu-bg3"></div>
<div class="line-top"></div>


 <section class="user-accounts">
    
    <div class="category-list category-list2">
     <a class="a1">日期</a>
     <a class="a2">预计收益</a>
     <a class="a2">结算收益</a>
     <a class="last">&nbsp;</a>  
   </div>
   
    <div class="user-accounts-box user-accounts-box2">
      <ul>
      
    
    <?php if ($this->_var['monthearnning_August_pred'] != 0): ?> 
            <li> 
          <div>
           <a href="index.php?m=default&c=user&a=earnings_overview2&mon=8">
             <span class="a1">2015-08</span>
             <span class="a1">￥<em><?php echo $this->_var['monthearnning_August_pred']; ?></em></span>
             <span class="a3">￥<em><?php echo $this->_var['monthearnning_August_get']; ?></em></span>
             <span  class="last"><i></i></span>
            </a>
          </div> 
        </li>  
  <?php endif; ?> 
      
      
      <?php if ($this->_var['monthearnning_July_pred'] != 0): ?> 
        <li>
          <div>
           <a href="index.php?m=default&c=user&a=earnings_overview2&mon=7">
             <span class="a1">2015-07</span>
             <span class="a1">￥<em><?php echo $this->_var['monthearnning_July_pred']; ?></em></span>
             <span class="a3">￥<em><?php echo $this->_var['monthearnning_July_get']; ?></em></span>
             <span  class="last"><i></i></span>
            </a>
          </div>
        </li>
        <?php endif; ?> 

        
  
        
        
      </ul>
    </div>
    
    <div class="user-accounts-bottom">
      <p>
       <span class="sp1">预计总收益<em><?php echo $this->_var['earnning_pred']; ?></em></span>
       <span class="sp2">结算总收益<em><?php echo $this->_var['earnning_get']; ?></em></span>
      </p>
    </div>
    
</section>

</div>

</body>
</html>