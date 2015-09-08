<?php echo $this->fetch('library/page_header.lbi'); ?>

<div class="con">

<header id="header" class="header">
  <div class="user-header">
    <h1 ><?php echo $this->_var['title']; ?></h1>
    <div class="header_l header_return"> <a class="ico_10_3" href="javascript:history.go(-1);"> 返回 </a> </div>
    <div class="header_r header_search"> <a class="ico_helf" href="javascript:void(0);"> 会员中心菜单</a> </div>
  </div>

</header>

<dl class="member-list-menu2">
  <dt class="first">
    <p style="margin-bottom:10px; font-size:1.1em;">相关说明:</p>
    <p style="color:#666;"> 1、已关注数只显示该页已关注官方微信的粉丝数</p>
    <p style="color:#666;"> 2、未关注数只显示该页未关注官方微信的粉丝数</p>
    <p style="color:#666;"> 3、列表用户只显示自己每层的粉丝数，最多可浏览三层</p>
   
  </dt>

</dl>

<div class="menu-bg3"></div>
<div class="line-top"></div>



 <section class="user-popularity">
    <div class="category-list">
     <a class="a1 on" href="#">已关注:<?php echo $this->_var['attention_count']; ?></a>
     <a class="a2" href="#">未关注:<?php echo $this->_var['notattention_count']; ?></a>  
   </div>
   <div class="user-popularity-box">
     <ul>
       <?php $_from = $this->_var['attention_allay_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'attention_allay_list_0_79218200_1441678456');if (count($_from)):
    foreach ($_from AS $this->_var['attention_allay_list_0_79218200_1441678456']):
?>
       <a style="display:block;" href="index.php?m=default&c=user&a=my_renqi_2&uid=<?php echo $this->_var['attention_allay_list_0_79218200_1441678456']['1']; ?>&attention=<?php echo $this->_var['attention_count']; ?>&notattention=<?php echo $this->_var['notattention_count']; ?>">
       <li>
         <dl><span class="avatar"><img src="<?php echo $this->_var['attention_allay_list_0_79218200_1441678456']['5']; ?>"/></span></dl>
         <h4><span class="color1">粉丝名称：</span><span class="color2"><?php echo $this->_var['attention_allay_list_0_79218200_1441678456']['0']; ?></span></h4>
         <div>
           <span class="name"><?php echo $this->_var['attention_allay_list_0_79218200_1441678456']['1']; ?></span>
           <span class="num"><?php echo $this->_var['attention_allay_list_0_79218200_1441678456']['2']; ?></span>
           <span class="stute"><?php echo $this->_var['attention_allay_list_0_79218200_1441678456']['3']; ?></span>
           <span class="level">1</span>
         </div>
         <p><?php echo $this->_var['attention_allay_list_0_79218200_1441678456']['4']; ?></p>
         <em><img src="themes/default/images/user-popularity-arrow.png" /></em>
       </li>
       <div style="clear:both;"></div>
       </a>
       <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
     </ul>
     
     <ul>
	 <?php $_from = $this->_var['notattention_allay_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'ab');if (count($_from)):
    foreach ($_from AS $this->_var['ab']):
?>
       <li>
      <a style="display:block;" href="index.php?m=default&c=user&a=my_renqi_2&uid=<?php echo $this->_var['ab']['1']; ?>&attention=<?php echo $this->_var['attention_count']; ?>&notattention=<?php echo $this->_var['notattention_count']; ?>">
         <dl><span class="avatar"><img src="themes/default/images/user_photo.jpg"/></span></dl>
         <h4><span class="color1">粉丝名称：</span><span class="color2"><?php echo $this->_var['ab']['0']; ?></span></h4>
         <div>
           <span class="name"><?php echo $this->_var['ab']['1']; ?></span>
           <span class="num"><?php echo $this->_var['ab']['2']; ?></span>
           <span class="stute"><?php echo $this->_var['ab']['3']; ?></span>
           <span class="level">1</span>
         </div>
         <p><?php echo $this->_var['ab']['4']; ?></p>
         <em><img src="themes/default/images/user-popularity-arrow.png" /></em>
       </li>
       </a>
     <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      
       
     </ul>
     
   </div>
</section>
</div>

<?php echo $this->fetch('library/search.lbi'); ?>
<?php echo $this->fetch('library/user_footer2.lbi'); ?>
<script type="text/javascript">
    $(".category-list a").removeClass("on");
	$(".category-list a:first").addClass("on");
	$(".user-popularity-box ul").css("display","none");
	$(".user-popularity-box ul:first").css("display","block");
	$(".user-popularity .category-list a").click(function(){
		    var a=$(this).index();
		    $(".category-list a").removeClass("on");
			$(this).addClass("on");	
			$(".user-popularity-box ul").css("display","none");
			$(".user-popularity-box ul").eq(a).css("display","block");
		})
</script>
</body>
</html>