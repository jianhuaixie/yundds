<ul class="ect-diaplay-box text-center">
  <li class="ect-box-flex"><a href="./<?php if ($_SESSION['user_id'] > 0): ?>?u=<?php echo $_SESSION['user_id']; ?><?php endif; ?>"><i class="ect-icon ect-icon-home"></i><span>首页</span></a></li>
  <li class="ect-box-flex"><a href="<?php echo url('category/top_all');?>"><i class="ect-icon ect-icon-cate"></i><span>分类</span></a></li>
  <li class="ect-box-flex"><a href="javascript:openSearch();"><i class="ect-icon ect-icon-search"></i><span>搜索</span></a></li>
  <li class="ect-box-flex"><a href="<?php echo url('flow/cart');?>"><i class="ect-icon ect-icon-flow"><strong class="num<?php 
$k = array (
  'name' => 'cart_info_number',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?>"><?php 
$k = array (
  'name' => 'cart_info_number',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?></strong></i><span>购物车</span></a></li>
  <li class="ect-box-flex"><a href="<?php echo url('user/index');?>"><i class="ect-icon ect-icon-user"><strong class="num0">0</strong></i><span>我的</span></a></li>
</ul>