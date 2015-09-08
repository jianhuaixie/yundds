<?php echo $this->fetch('library/page_header.lbi'); ?>
<div class="con">
<header id="header" class="header">
  <div class="user-header">
    <h1 >品牌街</h1>
    <div class="header_l header_return"> <a class="ico_10_3" href="./<?php if ($_SESSION['user_id'] > 0): ?>?u=<?php echo $_SESSION['user_id']; ?><?php endif; ?>"> 返回首页 </a> </div>
   <div class="header_r header_search"> <a class="ico_18_3" href="javascript:void(0);"> 会员中心菜单</a> </div>
   
   
  </div>
</header>
<dl class="member-list-menu2">
  <dt class="first">
    <a href="./<?php if ($_SESSION['user_id'] > 0): ?>?u=<?php echo $_SESSION['user_id']; ?><?php endif; ?>">
       <!--<i class="ico_21"></i>-->
       <span class="title">返回首页</span>
    </a>
  </dt>
  <dt>
    <a href="<?php echo url('user/index');?>">
       <!--<i class="ico_24"></i>-->
       <span class="title">个人中心</span>
    </a>
  </dt>
</dl>
<div class="menu-bg3"></div>
 <div class="line-top"></div>

  <div class="bran_list" id="J_ItemList" style="opacity:1;">
    <ul class="single_item">
    </ul>
    <a href="javascript:;" class="get_more"></a> </div>
</div>
<?php echo $this->fetch('library/search.lbi'); ?>
<?php echo $this->fetch('library/page_footer_refresh.lbi'); ?>
<script type="text/javascript">
get_asynclist("<?php echo url('brand/asynclist', array('page'=>$this->_var['page'], 'sort'=>$this->_var['sort'], 'order'=>$this->_var['order']));?>" , '__TPL__/images/loader.gif');
</script> 
</body></html>