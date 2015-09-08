<?php echo $this->fetch('library/page_header_goods.lbi'); ?>
<div class="con">
  <header id="header" >
  <!--<div class="header_r header_search"> <a class="ico_15" href="share.php?act=share&content=<?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?>&pic=<?php echo $this->_var['goods']['goods_img']; ?>"> 分享 </a> </div>-->
   <div class="user-header2">
    <h1 > </h1>
    <div class="header_l header_return"> <a class="ico_26" href="javascript:history.go(-1);"> 返回 </a> </div>
    <div class="header_r header_search"> <a class="ico_27" href="javascript:void(0);"> 会员中心菜单</a> </div>
    <?php echo $this->fetch('library/page_menu_member.lbi'); ?>    
  </div>
</header>
   <nav class="ect-nav ect-nav-list" style="display:none;"> 
     <?php echo $this->fetch('library/page_menu.lbi'); ?> 
   </nav>
  </div>
  
 <section class="goods_slider">
  <div id="slideBox" class="slideBox  ban-focus">
    <div class="scroller bd">
      <!--<div><a href="javascript:showPic()"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>"  alt="<?php echo $this->_var['goods']['goods_name']; ?>" /></a></div>-->
      <ul id="Gallery2">
      <li><a><img alt="" src="<?php echo $this->_var['goods']['original_img']; ?>"/></a></li>
      <?php if ($this->_var['pictures']): ?> 
      <?php $_from = $this->_var['pictures']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'picture');$this->_foreach['no'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['no']['total'] > 0):
    foreach ($_from AS $this->_var['picture']):
        $this->_foreach['no']['iteration']++;
?> 
      <?php if ($this->_foreach['no']['iteration'] > 1): ?>
      <li><a ><img alt="" src="<?php echo $this->_var['picture']['img_url']; ?>"/></a></li>
      <?php endif; ?> 
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
      <?php endif; ?>
    </ul>
    </div>
    <div class="icons hd">
      <ul>
        <i class="current"></i> <i class="current"></i> <i class="current"></i> <i class="current"></i> <i class="current"></i>
      </ul>
    </div>
  </div>
  <div class="blank2"></div>
<script type="text/javascript">
TouchSlide({ 
		slideCell:"#slideBox",
		titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
		mainCell:".bd ul", 
		effect:"leftLoop", 
		autoPage:true,//自动分页
		autoPlay:false //自动播放
});
function showPic(){
	var data = document.getElementById("slideBox").className;
	var reCat = /ui-gallery/;
	//str1.indexOf(str2);
	if( reCat.test(data) ){
		document.getElementById("slideBox").className = 'slideBox';
	}else{
		document.getElementById("slideBox").className = 'slideBox ui-gallery';
		//document.getElementById("slideBox").style.position = 'fixed';
	}
}
</script>
</section>


  
  <div class="goods-info ect-padding-tb"> 
    
    <section class="ect-padding-tb ect-padding-lr goods-title">
      <h4 class="title pull-left"><?php echo $this->_var['goods']['goods_style_name']; ?></h4>
      <span class="pull-right text-center <?php if ($this->_var['sc'] == 1): ?>ect-colory<?php endif; ?> ect-padding-lr" onClick="collect(<?php echo $this->_var['goods']['goods_id']; ?>)" id='ECS_COLLECT'> <i class="fa <?php if ($this->_var['sc'] == 1): ?>fa-heart<?php else: ?>fa-heart-o<?php endif; ?>"></i><br>
      <?php echo $this->_var['lang']['btn_collect']; ?> </span> </section>
    <section class="ect-padding-tb ect-padding-lr good-price">
      <p></p>
      <p class="sale-price">
       <span class="price"><?php if ($this->_var['goods']['is_promote'] && $this->_var['goods']['gmt_end_time']): ?><?php echo $this->_var['goods']['promote_price']; ?><?php else: ?><?php echo $this->_var['goods']['shop_price_formated']; ?><?php endif; ?><del><?php echo $this->_var['goods']['shop_price']; ?></del></span>
        <!--<span class="pull-right"><?php echo $this->_var['lang']['sort_sales']; ?>：<?php echo $this->_var['sales_count']; ?> <?php echo $this->_var['lang']['piece']; ?></span>-->
	  </p>
	  <p><?php if ($this->_var['goods']['is_promote'] && $this->_var['goods']['gmt_end_time']): ?><strong id="leftTime" class="price"><?php echo $this->_var['lang']['please_waiting']; ?></strong><?php endif; ?></p>
		 
    </section>
    <?php if ($this->_var['promotion']): ?>
    <section class="ect-margin-tb ect-margin-bottom0 ect-padding-tb goods-promotion ect-padding-lr ">
      <h5><b><?php echo $this->_var['lang']['activity']; ?>：</b></h5>
      <p class="ect-border-top ect-margin-tb"> 
        <?php $_from = $this->_var['promotion']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?> 
        <?php if ($this->_var['item']['type'] == "snatch"): ?> 
        <a href="<?php echo $this->_var['item']['url']; ?>" title="<?php echo $this->_var['lang']['snatch']; ?>"><i class="label tbqb"><?php echo $this->_var['lang']['snatch_act']; ?></i> [<?php echo $this->_var['lang']['snatch']; ?>]<i class="pull-right fa fa-angle-right"></i></a>
        <?php elseif ($this->_var['item']['type'] == "group_buy"): ?> 
        <a href="<?php echo $this->_var['item']['url']; ?>" title="<?php echo $this->_var['lang']['group_buy']; ?>"><i class="label tuan"><?php echo $this->_var['lang']['group_buy_act']; ?></i> [<?php echo $this->_var['lang']['group_buy']; ?>]<i class="pull-right fa fa-angle-right"></i></a> 
        <?php elseif ($this->_var['item']['type'] == "auction"): ?> 
        <a href="<?php echo $this->_var['item']['url']; ?>" title="<?php echo $this->_var['lang']['auction']; ?>"><i class="label pm"><?php echo $this->_var['lang']['auction_act']; ?></i> [<?php echo $this->_var['lang']['auction']; ?>]<i class="pull-right fa fa-angle-right"></i></a>
        <?php elseif ($this->_var['item']['type'] == "favourable"): ?> 
        <a href="<?php echo $this->_var['item']['url']; ?>" title="<?php echo $this->_var['lang'][$this->_var['item']['type']]; ?> <?php echo $this->_var['item']['act_name']; ?><?php echo $this->_var['item']['time']; ?>"> 
        <?php if ($this->_var['item']['act_type'] == 0): ?> 
        <i class="label mz"><?php echo $this->_var['lang']['favourable_mz']; ?></i> 
        <?php elseif ($this->_var['item']['act_type'] == 1): ?> 
        <i class="label mj"><?php echo $this->_var['lang']['favourable_mj']; ?></i> 
        <?php elseif ($this->_var['item']['act_type'] == 2): ?> 
        <i class="label zk"><?php echo $this->_var['lang']['favourable_zk']; ?></i> 
        <?php endif; ?><?php echo $this->_var['item']['act_name']; ?> <i class="pull-right fa fa-angle-right"></i></a> 
        <?php endif; ?> 
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
      </p>
    </section>
    <?php endif; ?> 
    
    
    <section class="goods-more-a goods-more-a2"> 
      <a class="ect-padding-lr ect-padding-tb">
        <span class="Text">选择尺码，颜色分类</span> <span class="pull-right"><i class="fa fa-chevron-right"></i></span>
      </a> 
    </section>
  
     
      <section class="goods-more-a"> 
      <a class="ect-padding-lr ect-padding-tb" href="<?php echo url('goods/comment_list',array('id'=>$this->_var['goods']['goods_id']));?>">
        <span class="Text"><?php echo $this->_var['lang']['goods_comment']; ?></span>
        <span class="pull-right">
        <span class="ect-color"><?php echo $this->_var['comments']['count']; ?></span><?php echo $this->_var['lang']['comment_num']; ?> 
        <span class="ect-color"><?php echo $this->_var['comments']['favorable']; ?>%</span><?php echo $this->_var['lang']['favorable_comment']; ?>
         <i class="fa fa-chevron-right"></i>  
        </span>
       
      </a> 
      </section>
     
     
     <div class="h-product-promise"><a><img src="themes/default/images/index-product-promise.jpg" /></a></div>
     
      <section class="goods-more-a"> 
      <!--<a class="ect-padding-lr ect-padding-tb" href="<?php echo url('goods/info',array('id'=>$this->_var['goods']['goods_id']));?>"><span class="Text"><?php echo $this->_var['lang']['goods_brief']; ?></span> <span class="pull-right"><i class="fa fa-chevron-right"></i></span></a> -->
      <a class="ect-padding-lr ect-padding-tb"><span class="Text"><?php echo $this->_var['lang']['goods_brief']; ?></span> </a> 
      </section>
     
     
  <section class="user-tab ect-border-bottom0 goods-detail">
        <!--<div id="is-nav-tabs" style="height:3.15em; display:none;"></div>-->
        
        <ul class="nav nav-tabs text-center">
          <li class="col-xs-4 active"><a href="#one" role="tab" data-toggle="tab"><?php echo $this->_var['lang']['goods_brief']; ?></a></li>
          <li class="col-xs-4"><a href="#two" role="tab" data-toggle="tab"><?php echo $this->_var['lang']['goods_attr']; ?></a></li>
          <li class="col-xs-4"><a href="#three" role="tab" data-toggle="tab">相关商品</a></li>
        </ul>
        
        <div class="tab-content">
          <div class="tab-pane fade tab-info active in" id="one"><?php 
$k = array (
  'name' => 'ads',
  'id' => '13',
  'num' => '1',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?><br/><br/> <?php echo $this->_var['goods']['goods_desc']; ?></div>
          <div class="tab-pane fade tab-att" id="two">
            <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#dddddd">
              <?php $_from = $this->_var['properties']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'property_group');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['property_group']):
?>
              <!--<tr>
                <th colspan="2" bgcolor="#FFFFFF"><?php echo htmlspecialchars($this->_var['key']); ?></th>
              </tr>-->
              <?php $_from = $this->_var['property_group']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'property');if (count($_from)):
    foreach ($_from AS $this->_var['property']):
?>
              <tr>
                <td bgcolor="#FFFFFF" align="left" width="40%" class="f1">[<?php echo htmlspecialchars($this->_var['property']['name']); ?>]</td>
                <td bgcolor="#FFFFFF" align="left" width="60%"><?php echo $this->_var['property']['value']; ?></td>
              </tr>
              <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
              <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </table>
          </div>


  <div id="three" class=" tab-pane fade  goods-related ect-padding-lr ect-padding-tb">
   <!-- <p><strong><?php echo $this->_var['lang']['releate_goods']; ?>：</strong></p>-->
    
    <div  class="picScroll  ban-focus">
      <div class="hd">
        <ul>
        </ul>
      </div>
      <div class="bd">
        <ul>
          <?php $_from = $this->_var['related_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods_0_00441300_1441613111');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods_0_00441300_1441613111']):
        $this->_foreach['goods']['iteration']++;
?>
          <li><a href="<?php echo $this->_var['goods_0_00441300_1441613111']['url']; ?>"><img src="<?php echo $this->_var['goods_0_00441300_1441613111']['goods_thumb']; ?>" /></a>
            <p class="ect-color"> 
              <?php if ($this->_var['goods_0_00441300_1441613111']['promote_price']): ?> 
              <?php echo $this->_var['goods_0_00441300_1441613111']['formated_promote_price']; ?>
              <?php else: ?> 
              <?php echo $this->_var['goods_0_00441300_1441613111']['shop_price']; ?>
              <?php endif; ?> 
            </p>
            <p class="text-left"><?php echo $this->_var['goods_0_00441300_1441613111']['short_name']; ?></p>
          </li>
          <?php if ($this->_foreach['goods']['iteration'] % 3 == 0): ?></ul><ul><?php endif; ?>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </ul>
      </div>
    </div>
    
     
  </div>

        </div>
      </section>
 
  </div>
  
   <section class="good-select">
    <form action="javascript:addToCart(<?php echo $this->_var['goods']['goods_id']; ?>)" method="post" name="ECS_FORMBUY" id="ECS_FORMBUY" >
      <section class="ect-padding-lr ect-padding-tb goods-option">
        <div class="select-product">
          <a><img src="<?php echo $this->_var['goods']['goods_img']; ?>" /></a>
          <p><?php echo $this->_var['goods']['goods_style_name']; ?></p>
          <p class="price-total">商品总价：<span id="ECS_GOODS_AMOUNT"></span></p>
        </div>
        <div class="goods-optionc"> 
          <?php $_from = $this->_var['specification']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('spec_key', 'spec');$this->_foreach['spec'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['spec']['total'] > 0):
    foreach ($_from AS $this->_var['spec_key'] => $this->_var['spec']):
        $this->_foreach['spec']['iteration']++;
?>
          <div class="goods-option-con"> <span><?php echo $this->_var['spec']['name']; ?></span>
            <div class="goods-option-conr"> 
               
              <?php if ($this->_var['spec']['attr_type'] == 1): ?> 
              <?php if ($this->_var['cfg']['GOODSATTR_STYLE'] == 1): ?> 
              <?php $_from = $this->_var['spec']['values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'value');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['value']):
?>
              <input type="radio" name="spec_<?php echo $this->_var['spec_key']; ?>" value="<?php echo $this->_var['value']['id']; ?>" id="spec_value_<?php echo $this->_var['value']['id']; ?>"  onclick="changePrice()" />
              <label for="spec_value_<?php echo $this->_var['value']['id']; ?>"><?php echo $this->_var['value']['label']; ?></label>
              <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
              <input type="hidden" name="spec_list" value="<?php echo $this->_var['key']; ?>" />
              <?php else: ?>
              <select name="spec_<?php echo $this->_var['spec_key']; ?>" onchange="changePrice()">
                <?php $_from = $this->_var['spec']['values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'value');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['value']):
?>
                <option label="<?php echo $this->_var['value']['label']; ?>" value="<?php echo $this->_var['value']['id']; ?>"><?php echo $this->_var['value']['label']; ?> <?php if ($this->_var['value']['price'] > 0): ?><?php echo $this->_var['lang']['plus']; ?><?php elseif ($this->_var['value']['price'] < 0): ?><?php echo $this->_var['lang']['minus']; ?><?php endif; ?><?php if ($this->_var['value']['price'] != 0): ?><?php echo $this->_var['value']['format_price']; ?><?php endif; ?></option>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
              </select>
              <input type="hidden" name="spec_list" value="<?php echo $this->_var['key']; ?>" />
              <?php endif; ?> 
              <?php else: ?> 
              <?php $_from = $this->_var['spec']['values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'value');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['value']):
?>
              <input type="checkbox" name="spec_<?php echo $this->_var['spec_key']; ?>" value="<?php echo $this->_var['value']['id']; ?>" id="spec_value_<?php echo $this->_var['value']['id']; ?>" onclick="changePrice()" />
              <label for="spec_value_<?php echo $this->_var['value']['id']; ?>"><?php echo $this->_var['value']['label']; ?> [<?php if ($this->_var['value']['price'] > 0): ?><?php echo $this->_var['lang']['plus']; ?><?php elseif ($this->_var['value']['price'] < 0): ?><?php echo $this->_var['lang']['minus']; ?><?php endif; ?> <?php echo $this->_var['value']['format_price']; ?>]</label>
              <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
              <?php endif; ?> 
            </div>
          </div>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
        </div>
        <div class="goods-num"><span class="pull-left"><?php echo $this->_var['lang']['number']; ?>：</span> 
          <?php if ($this->_var['goods']['goods_id'] > 0 && $this->_var['goods']['is_gift'] == 0 && $this->_var['goods']['parent_id'] == 0): ?>
          <div class="input-group pull-left wrap"><span class="input-group-addon sup" onClick="changePrice('1')">-</span>
            <input type="text" class="form-contro form-num"  name="number" id="goods_number" autocomplete="off" value="1" onFocus="back_goods_number()"  onblur="changePrice('2')"/>
            <span class="input-group-addon plus" onClick="changePrice('3')">+</span></div>
          <?php else: ?>
          <input type="text" class="form-contro form-num" readonly value="<?php echo $this->_var['goods']['goods_number']; ?> "/>
          <?php endif; ?> 
           <!--<span class="pull-right"><?php echo $this->_var['lang']['amount']; ?>：<b class="ect-colory" id="ECS_GOODS_AMOUNT"></b></span> -->
           <div class="product-show">
             <span class="product-sum" id="kucun">库存：<?php echo $this->_var['goods']['goods_number']; ?></span>
           </div>
        </div>
        <div class="goods-close"></div>
      </section>
     
      <div class="ect-padding-lr ect-padding-tb goods-submit">
      
      <div class="good-bt-left"><a type="botton" class="btn btn-info ect-btn-info ect-colorf ect-bg" href="javascript:addToCart_quick(<?php echo $this->_var['goods']['goods_id']; ?>)"><?php echo $this->_var['lang']['add_to_cart']; ?></a></div>
      <div class="good-bt-right"><a type="botton" class="btn btn-info ect-btn-info ect-colorf ect-bg" href="javascript:addToCart(<?php echo $this->_var['goods']['goods_id']; ?>)"><?php echo $this->_var['lang']['buy_now']; ?></a></div>

      </div>
      <div class="clear"></div>

    </form>
   </section>
     

  <footer class="logo"></footer>
</div>




<section class="goods_slider goods_slider2 view-box ">
  <div id="slideBox2" class="slideBox slideBox2  ban-focus"  style="width:100%; height:100%;">
    
    <div class="bd">
      <ul>
 <?php if ($this->_var['pictures']): ?> 
      <?php $_from = $this->_var['pictures']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'picture');$this->_foreach['no'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['no']['total'] > 0):
    foreach ($_from AS $this->_var['picture']):
        $this->_foreach['no']['iteration']++;
?> 
      <?php if ($this->_foreach['no']['iteration'] > 0): ?>
       <li>
            <div class="img_view1">

      <div class="parent" style="overflow: hidden; position: relative;">
        <div class="panzoom" style="transform: matrix(1, 0, 0, 1, 0,0); backface-visibility: hidden; transform-origin: 50% 50% 0px; cursor: move; transition: none; -webkit-transition: none;">
        
          <img src="<?php echo $this->_var['picture']['img_url']; ?>">
          
        </div>
      </div>


    </div>

        </li>
        <?php endif; ?> 
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
      <?php endif; ?>
     
      </ul>
    </div>
    
    <div class="icons icons2 hd">
      <ul>
        <i class="current"></i> <i class="current"></i> <i class="current"></i> <i class="current"></i> <i class="current"></i>
      </ul>
    </div>
    
    <div class="img-view-close"><a></a></div>
    
  </div>
 </section>
  <div class="blank2"></div>


  

<div style="height:10px;"></div>
<div class="s-action2">
    <a class="s-weixin" target="_blank" href="http://meiqia.com/chat/559c79fb4eae35054d000003?specifyGr=1&from=售前客服"><em></em><span>客服</span></a>
    <a class="s-home"  href="./<?php if ($_SESSION['user_id'] > 0): ?>?u=<?php echo $_SESSION['user_id']; ?><?php endif; ?>"><em></em><span>首页</span></a>
    <a class="s-colect" onClick="collect(<?php echo $this->_var['goods']['goods_id']; ?>)" id='ECS_COLLECT'><span class="<?php if ($this->_var['sc'] == 1): ?>ect-colory<?php endif; ?>"><i class="fa <?php if ($this->_var['sc'] == 1): ?>fa-heart<?php else: ?>fa-heart-o<?php endif; ?>"></i></span><span>收藏</span></a>
      
    <!--<button class="cart" type="button" onclick="addToCart_quick(<?php echo $this->_var['goods']['goods_id']; ?>);">加入购物车</button>
    <button class="buy" type="button" onclick="addToCart(<?php echo $this->_var['goods']['goods_id']; ?>)">立刻购买</button>-->
    <button class="cart" type="button" >加入购物车</button>
    <button class="buy" type="button" >立刻购买</button>
    
</div>

<div class="menu-bg2"></div>
<?php echo $this->fetch('library/search.lbi'); ?>
 <?php echo $this->fetch('library/page_footer_goods.lbi'); ?> 
 
 
<script type="text/javascript">
 $(".menu-bg2").css("display","none");
</script>
<script type="text/javascript">
/*banner滚动图片*/
	   //var a = $("#focus .bd li").first().innerHeight();
	  // alert(a);
	   //$("#focus .bd").css("height",a);
	  // $("#focus .bd").css("overflow","hidden");
	   
	   TouchSlide({
	   slideCell : "#slideBox2",
	   titCell : ".hd ul", // 开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
	   mainCell : ".bd ul",
	   effect : "leftLoop",
	   autoPlay : false, // 自动播放
	   autoPage : true, // 自动分页
	   delayTime: 200, // 毫秒；切换效果持续时间（执行一次效果用多少毫秒）
	   interTime: 2500, // 毫秒；自动运行间隔（隔多少毫秒后执行下一个效果）
	   //switchLoad : "_src" // 切换加载，真实图片路径为"_src"
  
	})
 </script>
   <script>
        (function() {
          var $section = $('.img_view1')
            $section.find('.panzoom').panzoom({
            $zoomIn: $section.find(".zoom-in"),
            $zoomOut: $section.find(".zoom-out"),
            $zoomRange: $section.find(".zoom-range"),
            $reset: $section.find(".reset")
          });
        })();
		$("#Gallery2 li").click(function(){
			  $(".goods_slider2").css("height","100%");
			})
		$(".img-view-close a").click(function(){
			  $(".goods_slider2").css("height","0");
			})
      </script>

  
          
<script type="text/javascript" src="__TPL__/js/lefttime.js"></script>

<script type="text/javascript">
//document.addEventListener('DOMContentLoaded', function(){Code.photoSwipe('a', '#Gallery');}, false);


/*倒计时*/
var goods_id = <?php echo $this->_var['goods']['goods_id']; ?>;
var goodsattr_style = 1;
var goodsId = <?php echo $this->_var['goods_id']; ?>;

var gmt_end_time = "<?php echo empty($this->_var['goods']['gmt_end_time']) ? '0' : $this->_var['goods']['gmt_end_time']; ?>";
<?php $_from = $this->_var['lang']['goods_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
var now_time = <?php echo $this->_var['now_time']; ?>;

var use_how_oos = <?php echo C('use_how_oos');?>;
onload = function(){
  changePrice(2);
  fixpng();
  try {onload_leftTime();}
  catch (e) {}
}
function back_goods_number(){
 var goods_number = document.getElementById('goods_number').value;
  document.getElementById('back_number').value = goods_number;
}
/**
 * 点选可选属性或改变数量时修改商品价格的函数
 */
function changePrice(type)
{
  var qty = document.forms['ECS_FORMBUY'].elements['number'].value;
  if(type == 1){qty--;}
  if(type == 3){qty++;}
  if(qty <=0 ){qty=1;}
  if(!/^[0-9]*$/.test(qty)){qty = document.getElementById('back_number').value;}
  document.getElementById('goods_number').value = qty;
  var attr = getSelectedAttributes(document.forms['ECS_FORMBUY']);
  $.get('<?php echo url("goods/price");?>', {'id':goodsId,'attr':attr,'number':qty}, function(data){
    changePriceResponse(data);
  }, 'json');
}
/**
 * 接收返回的信息
 */
function changePriceResponse(res){
  if (res.err_msg.length > 0){
    alert(res.err_msg);
  } else {
    if (document.getElementById('ECS_GOODS_AMOUNT'))
      document.getElementById('ECS_GOODS_AMOUNT').innerHTML = res.result;
	  //document.getElementById('kucun').innerHTML = res.attr_ku;//hzh
  }
}

/**
 * 接收返回的信息
 */
function changePriceResponse(res){
  if (res.err_msg.length > 0){
    alert(res.err_msg);
  } else {
    if (document.getElementById('ECS_GOODS_AMOUNT'))
      document.getElementById('ECS_GOODS_AMOUNT').innerHTML = res.result;
	  document.getElementById('kucun').innerHTML = "库存：" + res.attr_ku;//hzh
  }
}
/*判断user-tab是否距顶，距顶悬浮*/
var nav_tabs_top = $(".user-tab .nav-tabs").offset().top;//获取nav-tabs距离顶部的位
function func_scroll(){//定义一个事件效果置
	var documentTop = $(document).scrollTop();//获取滚动条距离顶部距离
	if(nav_tabs_top <= documentTop){
		$(".user-tab").addClass("user-tab-fixed");
		$("#is-nav-tabs").css("display","block");
	}else{
		$(".user-tab").removeClass("user-tab-fixed");
		$("#is-nav-tabs").css("display","none");		
	}
}

window.onscroll = function () {
	 func_scroll();
}
</script> 
<script type="text/javascript">
				TouchSlide({ 
					slideCell:"#picScroll",
					titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
					autoPage:"true", //自动分页
					pnLoop:"false", // 前后按钮不循环
					switchLoad:"_src" //切换加载，真实图片路径为"_src" 
				});
</script>



<script type="text/javascript">
  $(".goods-more-a2 a").click(function(){ 
	    $(".good-select").slideToggle();
		$(".menu-bg2").css("display","block");
	  })
  $(".goods-close").click(function(){
	    $(".good-select").slideToggle();
        $(".menu-bg2").css("display","none");
	  })
 $(".menu-bg2").click(function(){
	   $(".good-select").slideToggle();
       $(".menu-bg2").css("display","none");
	   
	  })
	  
	  $(".s-action2 .buy").click(function(){
		  
	   $(".good-select").slideToggle();
       $(".menu-bg2").css("display","none"); 
		  
     })
	 
	 $(".s-action2 .cart").click(function(){
		 $(".good-select").slideToggle();
         $(".menu-bg2").css("display","none"); 
	})
</script>


</body>
</html>