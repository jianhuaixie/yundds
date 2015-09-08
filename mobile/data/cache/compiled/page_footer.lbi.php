<div id="content" class="footer mr-t20">

  <!--<div class="in">
    <div class="search_box">
      <form method="post" action="search.php" name="searchForm" id="searchForm_id">
        <input name="keywords" type="text" id="keywordfoot" />
        <button class="ico_07" type="submit" value="搜索" onclick="return check('keywordfoot')"> </button>
      </form>
    </div>
    <a href="./" class="homeBtn"> <span class="ico_05"> </span> </a> <a href="#top" class="gotop"> <span class="ico_06"> </span> <p> TOP </p>
    </a>
  </div>-->
  
  
  <div class="back-top">
     <a href="javascript:scroll(0,0)" class="gotop2">
      <img  src="themes/default/images/yun1/back-top.png"  />
      <!--<span></span>
      <p>回顶部</p>-->
     </a>
    </div>
    
  <p class="region"> 
    <?php if ($this->_var['icp_number']): ?> 
    客服热线：<?php echo $this->_var['service_phone']; ?><br/><?php echo $this->_var['copyright']; ?><br/><a href="http://www.miibeian.gov.cn/" target="_blank"> <?php echo $this->_var['icp_number']; ?> </a> 
    <?php endif; ?> 
    </p>
  <!--<div class="favLink region"> <a href="http://www.yundds.com"> powered by 云的商城 </a> </div>-->
</div>


   <footer>
    <nav class="ect-nav">
        <ul class="ect-diaplay-box text-center">
            <li class="ect-box-flex"><a href="./<?php if ($_SESSION['user_id'] > 0): ?>?u=<?php echo $_SESSION['user_id']; ?><?php endif; ?>"><i class="ect-icon ect-icon-home"></i><span>首页</span></a></li>
            <li class="ect-box-flex"><a href="<?php echo url('category/top_all');?><?php if ($_SESSION['user_id'] > 0): ?>&u=<?php echo $_SESSION['user_id']; ?><?php endif; ?>"><i class="ect-icon ect-icon-cate"></i><span>分类</span></a></li>
            <li class="ect-box-flex"><a href="javascript:openSearch();"><i class="ect-icon ect-icon-search"></i><span>搜索</span></a></li>
            <li class="ect-box-flex"><a href="<?php echo url('flow/cart');?><?php if ($_SESSION['user_id'] > 0): ?>&u=<?php echo $_SESSION['user_id']; ?><?php endif; ?>"><i class="ect-icon ect-icon-flow"><strong class="num<?php 
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
            <li class="ect-box-flex"><a href="<?php echo url('user/index');?><?php if ($_SESSION['user_id'] > 0): ?>&u=<?php echo $_SESSION['user_id']; ?><?php endif; ?>"><i class="ect-icon ect-icon-user"><strong class="num0">0</strong></i><span>我的</span></a></li>
        </ul>
    </nav>
  </footer>

<div class="bottom-mg"></div>
<script type="text/javascript" src="__PUBLIC__/js/jquery.min.js" ></script> 
<script type="text/javascript" src="__TPL__/js/lazyload/jquery.js"></script>
<script type="text/javascript" src="__TPL__/js/lazyload/jquery.lazyload.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.json.js" ></script> 
<script type="text/javascript" src="__PUBLIC__/js/common.js"></script> 
<script type="text/javascript" src="__PUBLIC__/js/jquery.more.js"></script> 
<script type="text/javascript" src="__PUBLIC__/js/utils.js" ></script> 

<script src="__TPL__/js/ectouch.js"></script> 
<script src="__TPL__/js/simple-inheritance.min.js"></script> 
<script src="__TPL__/js/code-photoswipe-1.0.11.min.js"></script> 
<script src="__PUBLIC__/bootstrap/js/bootstrap.min.js"></script> 
<script src="__TPL__/js/jquery.scrollUp.min.js"></script> 
<script type="text/javascript" src="__PUBLIC__/js/validform.js" ></script>

<script type="text/javascript" src="__TPL__/js/sara.js"></script> 

<script language="javascript">
	
	/*弹出评论层并隐藏其他层*/
	function openSearch(){
		if($(".con").is(":visible")){
			$(".con").hide();	
			$(".search").show();
		}
	}
	function closeSearch(){
		if($(".con").is(":hidden")){
			$(".con").show();	
			$(".search").hide();
		}
	}
</script> 
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?5d74410ecd08fa640c2f30939878c4eb";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>