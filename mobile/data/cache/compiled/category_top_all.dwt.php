<?php echo $this->fetch('library/page_header.lbi'); ?>

<div class="con">
<header id="header" class="header" >
  <div class="header_l header_return"> <a class="ico_10_3" href="javascript:history.go(-1)"> 返回 </a> </div>
    <h1> 所有分类页 </h1>
  <div class="header_r header_search"> <a class="ico_03_02" href="javascript:openSearch();"> 搜索 </a> </div>
</header>

<div class="line-top"></div>
<div class="clist">
  <ul>
    <?php $_from = $this->_var['category']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['no'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['no']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['no']['iteration']++;
?>
    <?php $_from = $this->_var['cat']['cat_id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child');$this->_foreach['no1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['no1']['total'] > 0):
    foreach ($_from AS $this->_var['child']):
        $this->_foreach['no1']['iteration']++;
?>
    <li class="crow level1">
    <?php if ($this->_var['cat']['cat_id']): ?>
      <div class="crow_row">

        <div class="crow_icon"> <img src="<?php echo $this->_var['child']['cat_image']; ?>" /> </div>
        <div class="crow_title"> <span><?php echo htmlspecialchars($this->_var['child']['name']); ?></span></div>
        <div class="crow_arrow"> <img src="__TPL__/images/ico_11.png"> </div>
        <div>&nbsp;</div>
      </div>
      <?php endif; ?>
    </li>
    <ul class="clist clist_sub clearfix" style="opacity: 1; display: none;">
      <li class="crow"> 
        <?php $_from = $this->_var['child']['cat_id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'childer');$this->_foreach['no2'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['no2']['total'] > 0):
    foreach ($_from AS $this->_var['childer']):
        $this->_foreach['no2']['iteration']++;
?>
        <div class="crow_item"> <a href="<?php echo $this->_var['childer']['url']; ?><?php if ($_SESSION['user_id'] > 0): ?>&u=<?php echo $_SESSION['user_id']; ?><?php endif; ?>"><?php echo htmlspecialchars($this->_var['childer']['name']); ?></a> </div>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </li>
    </ul>

    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </ul>
</div>

<script type="text/javascript" src="__TPL__/js/zepto.min.js"></script> 
<script type="text/javascript">
/*头部搜索点击关闭或者弹出搜索框*/  

function showSearch( ){
	document.getElementById("search_box").style.display="block";
}

function closeSearch(){
	document.getElementById("search_box").style.display="none";
}

/* 搜索验证 */

function check(Id){
	var strings = document.getElementById(Id).value;
	if(strings.replace(/(^\s*)|(\s*$)/g, "").length == 0){
	return false;
	}
	return true;
}


(function($) {
	var btn_up = new Image(), btn_down = new Image();
	btn_up.src = "__TPL__/images/ico_12.png";
	btn_down.src = "__TPL__/images/ico_11.png";
	var Menu = {

		// 初始化事件

		initEvent : function() {

			$().ready(

					function() {

						$("div.clist").click(function(e) {


							Menu.router(e);

						});





						$("#allClass").click(function(e) {





							Menu.showMenu1();





						});





						$(window).on(





								"hashchange",





								function(e) {





									var name = decodeURIComponent(location.hash





											.replace(/^#/, ""));





									if (name != "") {





										Menu.showMenu3(name);





									}else{





										Menu.showMenu1();





									}





								});





					});





		},





		// 事件分发路油





		router : function(_event) {





			var target = $(_event.target || _event.srcElement);





			var _tar = target.closest(".level1");











			// 显示二级菜单





			if (_tar.length > 0) {





				Menu.showMenu2(_tar);





				/*var _gp = target.closest(".crow_row");// 点击事件对应此行的祖父级节点





				var _top = _gp.offset().top;





				setTimeout(function(){





					if (_top > 100) {





						window.scroll(0, _gp.offset().top);





					} else {





						window.scroll(0, _gp.offset().top - 50);





					}					





				},15)*/





				return;





			}





		},





		// 显示一级菜单





		showMenu1 : function() {





			$("#contentsub").hide();





			$("#content").show();





		},





		// 显示二级菜单





		showMenu2 : function($curMenuDom) {





			var next = $curMenuDom.next("ul");





			if (next.css("display") == "none") {





				//$("ul.clist_sub").hide();





				//$("div.crow_arrow").each(function(i, dom) {





				//	$(dom).html(btn_down.cloneNode(true));





				//});





				next.css("opacity", "0").show().animate({





					opacity : 1





				}, 500);





				//next.show();





				$("div.crow_arrow", $curMenuDom).html(btn_up.cloneNode(true));





			} else {





				next.hide();





				$("div.crow_arrow", $curMenuDom).html(btn_down.cloneNode(true));





			}





		},





		





	}





	window.Menu = Menu;





	Menu.initEvent();// 初始化事件





})($);





</script>



<div class="bottom-mg"></div>

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











<?php echo $this->fetch('library/search.lbi'); ?>





<?php echo $this->fetch('library/page_footer_category.lbi'); ?>



</body>





</html>