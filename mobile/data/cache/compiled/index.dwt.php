<?php echo $this->fetch('library/page_header_index.lbi'); ?>

<div class="con"> 
  <header class="h-header">
    <a href="./<?php if ($_SESSION['user_id'] > 0): ?>?u=<?php echo $_SESSION['user_id']; ?><?php endif; ?>" class="logo"><img src="themes/default/images/yun1/logo2.png"  /></a>
     <div class="search-box">
      <div class="search-center">
        <form action="<?php echo url('category/index');?><?php if ($this->_var['id']): ?>&id=<?php echo $this->_var['id']; ?><?php endif; ?><?php if ($_SESSION['user_id'] > 0): ?>&u=<?php echo $_SESSION['user_id']; ?><?php endif; ?>"  method="post" id="searchForm" name="searchForm">
         <input placeholder="云的商城-专卖正品 质在必得！" name="keywords" type="text" class="h-search-text"  id="keywordBox" />
         <button type="submit" value="搜索" class="h-search-submit" onclick="return check('keywordBox')">
         </button>
         </form>
       </div>
     </div>
     <a class="weixin" target="_blank">
       <img class="weixin1" src="themes/default/images/yun1/h-weixin2.png"  />
     </a>
     <!--<a href="#" class="app">
       <img src="themes/default/images/yun1/h-app.png" />
     </a>-->
  </header>
  
   <div class="menu-bg3"></div>
   <div class="h-out-weixin"><a><img src="<?php if ($this->_var['ewmtj']): ?><?php echo $this->_var['ewmtj']; ?><?php else: ?>/mobile/themes/default/images/yun1/pc-h-weixin2.gif<?php endif; ?>" /></a></div>

  
  <div style="height:49px;"></div>
 
  <div id="focus" class="focus region  ban-focus">
    <div class="hd">
      <ul>
      </ul>
    </div>
    <div class="bd">
      <?php 
$k = array (
  'name' => 'ads',
  'id' => '1',
  'num' => '6',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?>
    </div>
  </div>

 
 <script type="text/javascript">

/*banner滚动图片*/
	   //var a = $("#focus .bd li").first().innerHeight();
	  // alert(a);
	   //$("#focus .bd").css("height",a);
	  // $("#focus .bd").css("overflow","hidden");

	   TouchSlide({
	   slideCell : "#focus",
	   titCell : ".hd ul", // 开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
	   mainCell : ".bd ul",
	   effect : "leftLoop",
	   autoPlay : true, // 自动播放
	   autoPage : true, // 自动分页
	   delayTime: 200, // 毫秒；切换效果持续时间（执行一次效果用多少毫秒）
	   interTime: 2500, // 毫秒；自动运行间隔（隔多少毫秒后执行下一个效果）
	   //switchLoad : "_src" // 切换加载，真实图片路径为"_src"

	})
</script>



<section class="h-category-top">
   <ul>
      <li>
        <a><img src="themes/default/images/h-category-01.jpg"></a>
      </li>
      <li>
        <a><img src="themes/default/images/h-category-02.jpg"></a>
      </li>
      <li>
        <a><img src="themes/default/images/h-category-03.jpg"></a>
      </li>
      <li>
        <a><img src="themes/default/images/h-category-04.jpg"></a>
      </li>
      <li>
        <a><img src="themes/default/images/h-category-05.jpg"></a>
      </li>
      <li>
        <a><img src="themes/default/images/h-category-06.jpg"></a>
      </li>
      <li>
        <a><img src="themes/default/images/h-category-07.jpg"></a>
      </li>
      <li>
        <a><img src="themes/default/images/h-category-08.jpg"></a>
      </li>
   </ul>
</section>



<section class="h-day-update">
   <div class="h-left">
     <a><img src="themes/default/images/h-update-img1.png"></a>
   </div>
   <div class="h-right">
     <ul>
       <li>
          <a><img src="themes/default/images/h-update-img2.png"></a>
       </li>
       <li>
          <a><img src="themes/default/images/h-update-img2.png"></a>
       </li>
       <li>
          <a><img src="themes/default/images/h-update-img2.png"></a>
       </li>
       <li>
          <a><img src="themes/default/images/h-update-img2.png"></a>
       </li>
     </ul>
   </div>
</section>




  <nav class="h-nav">
     <ul>
        <li class="a1">
          <a href="index.php?c=article&a=art_list&id=6<?php if ($_SESSION['user_id'] > 0): ?>&u=<?php echo $_SESSION['user_id']; ?><?php endif; ?>">
             <img src="themes/default/images/yun1/h-nav-help.jpg"  />
             <p style="display:none;">
               <span>帮助中心</span>
               <i>category</i>
             </p>
          </a>


        </li>
        <li  class="a2">
          <a href="<?php echo url('user/index');?><?php if ($_SESSION['user_id'] > 0): ?>&u=<?php echo $_SESSION['user_id']; ?><?php endif; ?>">
             <img src="themes/default/images/yun1/h-nav2.png"  />
              <p style="display:none;">
               <span>我的云的</span>
               <i>my yundds</i>
             </p>
          </a>
        </li>
        <li class="a3">
          <a>
             <img src="themes/default/images/yun1/h-nav-tel2.jpg"  />
             <p style="display:none;">
               <span>热线客服</span>
               <i>cart</i>

             </p>
          </a>
        </li>
     </ul>
  </nav>


<dl class="member-list-menu2">
  <dt class="first">
    <p style="margin-bottom:10px; font-size:1.1em;">客服上班时间:</p>
    <p style="color:#666;"> 9:00--18:00(周一到周日)</p>
    <div style="height:0.3em;"></div>
    <p style="color:#666;"> 客服热线：400-8034-988</p>
   
  </dt>
</dl>
<div class="menu-bg3"></div>


<section class="h-floor">
<?php 
$k = array (
  'name' => 'ads',
  'id' => '8',
  'num' => '1',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?>
</section>


<section class="h-brand-hot">
  <div class="brabd-top">
     <h4>热门品牌<em>hot brand</em></h4>
     <p>
       <a class="on">全部</a>
       <a >美妆品牌</a>
       <a>服装品牌</a>
       <a>更多>></a>
     </p>  
  </div>
  <div class="clear"></div>
  <div class="brand-content">
     <div class="cont-left">
        
           <div id="brand0" class="focus b-left ban-focus">
              <div class="hd">
                <ul>
                </ul>
              </div>
              <div class="bd">
                 <ul>
                   <li><a><img src="themes/default/images/h-update-img1.png" /></a></li>
                   <li><a><img src="themes/default/images/h-brand-left.jpg" /></a></li>
                 </ul>
              </div>
           </div>
           
       <script type="text/javascript">

	   TouchSlide({
	   slideCell : "#brand0",
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
    
        
     </div>
     <div class="cont-right">
         
         <div class="category">
           
           <div id="brand1" class="focus b-right ban-focus">
              <div class="hd">
                <ul>
                </ul>
              </div>
              <div class="bd">
                 <ul>
                   <li>
                     <dl>
                        <dt><a><img src="themes/default/images/h-brand-right-01.jpg" /></a></dt>
                        <dt><a><img src="themes/default/images/h-brand-right-01.jpg" /></a></dt>
                        <dt><a><img src="themes/default/images/h-brand-right-01.jpg" /></a></dt>
                        
                        <dt><a><img src="themes/default/images/h-brand-right-01.jpg" /></a></dt>
                        <dt><a><img src="themes/default/images/h-brand-right-01.jpg" /></a></dt>
                        <dt><a><img src="themes/default/images/h-brand-right-01.jpg" /></a></dt>
                        
                        <dt><a><img src="themes/default/images/h-brand-right-01.jpg" /></a></dt>
                        <dt><a><img src="themes/default/images/h-brand-right-01.jpg" /></a></dt>
                        <dt><a><img src="themes/default/images/h-brand-right-01.jpg" /></a></dt>
                        
                        <dt><a><img src="themes/default/images/h-brand-right-01.jpg" /></a></dt>
                        <dt><a><img src="themes/default/images/h-brand-right-01.jpg" /></a></dt>
                        <dt><a><img src="themes/default/images/h-brand-right-01.jpg" /></a></dt>
                     </dl>
                   </li>

                 </ul>
              </div>
           </div>
        
         </div>
         <div class="category">
           
           <div id="brand2" class="focus b-right ban-focus">
              <div class="hd">
                <ul>
                </ul>
              </div>
              <div class="bd">
                 <ul>

                   <li>
                     <dl>
                        <dt><a><img src="themes/default/images/h-brand-right-02.jpg" /></a></dt>
                        <dt><a><img src="themes/default/images/h-brand-right-02.jpg" /></a></dt>
                        <dt><a><img src="themes/default/images/h-brand-right-02.jpg" /></a></dt>
                        
                        <dt><a><img src="themes/default/images/h-brand-right-02.jpg" /></a></dt>
                        <dt><a><img src="themes/default/images/h-brand-right-02.jpg" /></a></dt>
                        <dt><a><img src="themes/default/images/h-brand-right-02.jpg" /></a></dt>
                        
                        <dt><a><img src="themes/default/images/h-brand-right-02.jpg" /></a></dt>
                        <dt><a><img src="themes/default/images/h-brand-right-02.jpg" /></a></dt>
                        <dt><a><img src="themes/default/images/h-brand-right-02.jpg" /></a></dt>
                        
                        <dt><a><img src="themes/default/images/h-brand-right-02.jpg" /></a></dt>
                        <dt><a><img src="themes/default/images/h-brand-right-02.jpg" /></a></dt>
                        <dt><a><img src="themes/default/images/h-brand-right-02.jpg" /></a></dt>
                     </dl>
                   </li>
                  
                 </ul>
              </div>
           </div>
        
         </div>
         
         
         
         <div class="category">
           
           <div id="brand3" class="focus b-right ban-focus">
              <div class="hd">
                <ul>
                </ul>
              </div>
              <div class="bd">
                 <ul>

                   <li>
                     <dl>
                        <dt><a><img src="themes/default/images/h-brand-right-01.jpg" /></a></dt>
                        <dt><a><img src="themes/default/images/h-brand-right-01.jpg" /></a></dt>
                        <dt><a><img src="themes/default/images/h-brand-right-01.jpg" /></a></dt>
                        
                        <dt><a><img src="themes/default/images/h-brand-right-01.jpg" /></a></dt>
                        <dt><a><img src="themes/default/images/h-brand-right-01.jpg" /></a></dt>
                        <dt><a><img src="themes/default/images/h-brand-right-01.jpg" /></a></dt>
                        
                        <dt><a><img src="themes/default/images/h-brand-right-02.jpg" /></a></dt>
                        <dt><a><img src="themes/default/images/h-brand-right-02.jpg" /></a></dt>
                        <dt><a><img src="themes/default/images/h-brand-right-02.jpg" /></a></dt>
                        
                        <dt><a><img src="themes/default/images/h-brand-right-02.jpg" /></a></dt>
                        <dt><a><img src="themes/default/images/h-brand-right-02.jpg" /></a></dt>
                        <dt><a><img src="themes/default/images/h-brand-right-02.jpg" /></a></dt>
                     </dl>
                   </li>
                  
                 </ul>
              </div>
           </div>
        
         </div>
         
         
         
     </div>
  </div>
</section>

<script type="text/javascript">
	   TouchSlide({
	   slideCell : "#brand1",
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
        
       <script type="text/javascript">

	   TouchSlide({
	   slideCell : "#brand2",
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
    
    <script type="text/javascript">
	   TouchSlide({
	   slideCell : "#brand3",
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
       





<!--<section class="index-countdown">
  <div class="time-text" id="time_text">
    距离活动开始还有
     <span id="t_d">00</span>天
     <span id="t_h">00</span>时
     <span id="t_m">00</span>分
     <span id="t_s">00</span>秒
  </div>
</section>-->





<!--<sectoin class="index-coupon">
  <ul>
     <li>
        <a>
           <img src="themes/default/images/index-coupons-ico1.png"></a>
        </a>
        
     </li>
     
     <li>
        <a href="user.php?act=act_add_bonus&bonus_sn=1000009341">
           <img src="themes/default/images/index-coupons-ico2.png"></a>
        </a>
     </li>
     
     <li>
        <a href="user.php?act=act_add_bonus&bonus_sn=1000001219">
           <img src="themes/default/images/index-coupons-ico3.png"></a>
        </a>
     </li>
  </ul>
</sectoin>
<div class="index-bg"></div>
<div  class="index-show-weixin"><img src="themes/default/images/index-weixin-ico.png" /></div>-->



<section class="h-floor">
<div class="h-floor-title"><span>本周新品</span> <a href="index.php?m=default&c=category&type=new">查看更多>></a></div>
<div class="h-banner"><?php 
$k = array (
  'name' => 'ads',
  'id' => '13',
  'num' => '1',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?></div>
<?php echo $this->fetch('library/recommend_xinpin.lbi'); ?>
</section>




<?php echo $this->fetch('library/index_rukou.lbi'); ?>


<div class="h-product-promise"><a><img src="themes/default/images/index-product-promise.jpg" /></a></div>


<section class="h-floor">
<div class="h-floor-title"><span>今日最大牌</span> 
<a href="index.php?c=brand<?php if ($_SESSION['user_id'] > 0): ?>&u=<?php echo $_SESSION['user_id']; ?><?php endif; ?>">查看更多>></a></div>
<?php 
$k = array (
  'name' => 'ads',
  'id' => '14',
  'num' => '10',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?>
</section>



<section class="h-floor">
<div class="h-floor-title"><span>热门商品</span> <a href="index.php?m=default&c=category&type=new">查看更多>></a></div>
<div class="h-banner"><?php 
$k = array (
  'name' => 'ads',
  'id' => '13',
  'num' => '1',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?></div>
<?php echo $this->fetch('library/recommend_new.lbi'); ?>
</section>



<?php echo $this->fetch('library/index_rukou2.lbi'); ?>






  <?php echo $this->fetch('library/recommend_best.lbi'); ?>




<?php if ($this->_var['guanzhu'] == 0): ?>
<section class="index-care">
<a href="http://mp.weixin.qq.com/s?__biz=MzIyOTAwNDQwNw==&mid=207543134&idx=1&sn=1ade1cb1a2d6d8e6e87340570378574e#rd" target="_blank">
  <p>
   <span class="img"><img src="<?php if ($this->_var['p_headimgurl']): ?><?php echo $this->_var['p_headimgurl']; ?><?php else: ?>images/logo.png<?php endif; ?>" /></span>
   <span class="sp"><?php if ($this->_var['p_nickname']): ?><?php echo $this->_var['p_nickname']; ?><?php else: ?>云的商城<?php endif; ?></span>
   <span class="sp">推荐</span>
  </p>
   
   <span class="button">立即关注</span>
</a>
</section>

<?php endif; ?>

</div>
<?php echo $this->fetch('library/search.lbi'); ?>
<?php echo $this->fetch('library/page_footer.lbi'); ?> 
<div class="bottom-mg"></div>


<!--<a  key ="55e44e87efbfb0241247cfb3" logo_style="fixed"  href="http://www.anquan.org" >
<script src="http://static.anquan.org/static/outer/js/aq_auth.js"></script>
</a>-->

<script>
  $(".h-nav li.a3").click(function(){

			    $(".member-list-menu2").css("display","block");

				$(".menu-bg3").css("display","block");

		})

		$(".menu-bg3").click(function(){

			   $(".member-list-menu2").css("display","none");

			   $(".menu-bg3").css("display","none");

			})
</script>
   <script type="text/javascript">
     $(".weixin").click(function(){
		   $(".menu-bg3").css("display","block");
		   $(".h-out-weixin").css("display","block");
		 })
	$(".menu-bg3").click(function(){
		  $(".menu-bg3").css("display","none");
		   $(".h-out-weixin").css("display","none");
		})

//红包弹出微信
 $(".index-coupon li:first").find("a").click(function(){
		   $(".index-bg").css("display","block");
		   $(".index-show-weixin").css("display","block");
		 })
	$(".index-bg").click(function(){
		  $(".index-bg").css("display","none");
		   $(".index-show-weixin").css("display","none");
		})
		


/*倒计时*/
/*function GetRTime(){
	   var StartTime=new Date('2015/08/17 23:59:59');
       var EndTime = new Date('2015/08/20 23:59:59');
       var NowTime = new Date();
	   
	   
	   if(StartTime.getTime()>=NowTime.getTime()){
       var t =StartTime.getTime() - NowTime.getTime();
       var d=Math.floor(t/1000/60/60/24);
       var h=Math.floor(t/1000/60/60%24);
       var m=Math.floor(t/1000/60%60);
       var s=Math.floor(t/1000%60);
       document.getElementById("time_text").innerHTML = "距离活动开始还有<span>"+ d + "</span>天<span>"+ h +"</span>时<span>"+ m +"</span>分<span>"+ s +"</span>秒";
	   
	   }
	   else{
	   var et =EndTime.getTime() - NowTime.getTime();
       var ed=Math.floor(et/1000/60/60/24);
       var eh=Math.floor(et/1000/60/60%24);
       var em=Math.floor(et/1000/60%60);
       var es=Math.floor(et/1000%60);
       document.getElementById("time_text").innerHTML = "距离活动结束还有<span>"+ ed + "</span>天<span>"+ eh +"</span>时<span>"+ em +"</span>分<span>"+ es +"</span>秒";
	   
		   
		   }
       if(EndTime.getTime()<NowTime.getTime()){
	     $(".index-countdown").remove();
		 $(".index-coupon").remove();
	   }   
		
   }
   setInterval(GetRTime,0);*/
   </script>

<script>
 $(".h-brand-hot .brand-content .cont-right .category:first").addClass("show");
  $(".h-brand-hot .brabd-top p a").click(function(){
	    var tem=$(".h-brand-hot .brabd-top p a").index(this);
		var leng=$(".h-brand-hot .brabd-top p a").size();

		if(tem==leng-1){	
		}
		else{
		$(".h-brand-hot .brabd-top p a").removeClass("on");
		$(this).addClass("on");
		$(".h-brand-hot .brand-content .cont-right .category").removeClass("show");
		$(".h-brand-hot .brand-content .cont-right .category").eq(tem).addClass("show");
		}
	  })
</script>


<script type="text/javascript">
get_asynclist("<?php echo url('index/ajax_goods', array('type'=>'best'));?>" , '__TPL__/images/loader.gif');
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
</body>
</html>