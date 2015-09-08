<?php echo $this->fetch('library/page_header.lbi'); ?>

<div class="con">

<header id="header" class="header">

  <div class="user-header">
    <h1 ><?php echo $this->_var['title']; ?></h1>
    <div class="header_l header_return"> <a class="ico_10_3" href="<?php echo url('user/index');?><?php if ($_SESSION['user_id'] > 0): ?>&u=<?php echo $_SESSION['user_id']; ?><?php else: ?>&u=0<?php endif; ?>"> 返回 </a> </div>
   <div class="header_r header_search"> <a class="ico_18_3" href="index.php?a=index<?php if ($_SESSION['user_id'] > 0): ?>&u=<?php echo $_SESSION['user_id']; ?><?php else: ?>&u=0<?php endif; ?>"> 会员中心菜单</a> </div>

  </div>

</header>

<!--<dl class="member-list-menu2">
  <dt class="first">
    <a href="index.php?a=index<?php if ($_SESSION['user_id'] > 0): ?>&u=<?php echo $_SESSION['user_id']; ?><?php else: ?>&u=0<?php endif; ?>">
       <span class="title">返回首页</span>
    </a>

  </dt>
  <dt>
    <a href="<?php echo url('user/index');?>">
       <span class="title">个人中心</span>
    </a>
  </dt>
</dl>
<div class="menu-bg3"></div>-->
<div class="line-top"></div>

 <section class="user-promote">
    <section class="user-promote-top">
       <div class=" bg"><img src="themes/default/images/user-promote-bg.png" /></div>
        <div class="user-pic">
          <div>
            <a style=" background:url(<?php if ($this->_var['info']['avatar']): ?><?php echo $this->_var['info']['avatar']; ?><?php elseif ($this->_var['info']['headimgurl']): ?><?php echo $this->_var['info']['headimgurl']; ?><?php else: ?>data/common/images/get_avatar.png<?php endif; ?>) no-repeat; background-size:cover;">
            
            </a>
            <p>
              <span class="grade">推广ID：<?php echo $_SESSION['user_id']; ?></span>
              <span class="grade">推广等级：<em><?php echo $this->_var['fenxiao_rank']; ?></em></span>
              <span class="grade">上家ID：<em><?php echo $this->_var['parent_id']; ?></em></span>
            </p>
          </div>
        </div>
    </section>
    
    <section class="user-promote-show">
       <ul>
          <li>
             <h4><a><img src="themes/default/images/user-promote-ico2.png" /></a></h4>
             
             <div class="demo">
              <dl class="notes">
               <dt class="html">
                 <div class="notesite" id="note_0" data-a="<?php echo $this->_var['day_earningsacount']; ?>" data-b="<?php echo $this->_var['yesterday_earningsacount']; ?>" dir="10"></div>
               </dt>
             </dl>
            </div>
    
    <div class="user-promote-bottom">
        <p><span class="left color1"><?php echo $this->_var['day_earningsacount']; ?></span><span class="right color2"><?php echo $this->_var['yesterday_earningsacount']; ?></span></p>
        <p><span class="left color1">今日收益</span><span class="right color2">昨日收益</span></p>
    </div>
          </li>
          
          
          <li>
             <h4><a><img src="themes/default/images/user-promote-ico1.png" /></a></h4>
             
             <div class="demo">
              <dl class="notes">
               <dt class="html">
                 <div class="notesite" id="note_1" data-a="<?php echo $this->_var['day_attention_acount']; ?>" data-b="<?php echo $this->_var['yesterday_attention_acount']; ?>" dir="10"></div>
               </dt>
             </dl>
            </div>
    
    <div class="user-promote-bottom">
        <p><span class="left color1"><?php echo $this->_var['day_attention_acount']; ?></span><span class="right color2"><?php echo $this->_var['yesterday_attention_acount']; ?></span></p>
        <p><span class="left color1">今日关注</span><span class="right color2">昨日关注</span></p>
    </div>
          </li>
          
          
          <li class="last">
             <h4><a><img src="themes/default/images/user-promote-ico3.png" /></a></h4>
             
             <div class="demo">
              <dl class="notes">
               <dt class="html">
                 <div class="notesite" id="note_2" data-a="<?php echo $this->_var['all_order_amount']; ?>" data-b="<?php echo $this->_var['tuihuo_order_amount']; ?>" dir="10"></div>
               </dt>
             </dl>
            </div>
    
    <div class="user-promote-bottom">
        <p><span class="left color1"><?php echo $this->_var['all_order_amount']; ?></span><span class="right color2"><?php echo $this->_var['tuihuo_order_amount']; ?></span></p>
        <p><span class="left color1">付款订单</span><span class="right color2">退换货订单</span></p>
    </div>
          </li>
          
       </ul>
    </section>
   
    <section class="user-promote-part">
       <ul>
          <li class="part1">
            <a href="index.php?m=default&c=user&a=my_renqi">
             <span class="sp1">我的人气</span>
             <span class="sp2"><?php echo $this->_var['user_allyacount']; ?></span>
            </a>
          </li>
          
          <li class="part2">
            <a href="index.php?m=default&c=user&a=tuiguang_order">
             <span class="sp1">推广订单</span>
             <span class="sp2"><?php echo $this->_var['all_order_amount']; ?></span>
            </a>
          </li>
          
          <li class="part3">
            <a href="index.php?m=default&c=user&a=my_shouyi&n=a1">
             <span class="sp1">推广收益</span>
             <span class="sp2"><?php echo $this->_var['tuiguang_earningsacount']; ?></span>
            </a>
          </li>
          
          <li class="part4">
            
           <a href=<?php if ($this->_var['mobile']): ?>"index.php?m=default&c=user&a=user_redpager"<?php else: ?>"index.php?m=default&c=user&a=bd_new" onclick="if (!confirm('为了您的资金安全，请绑定手机号码')) return false;"<?php endif; ?>>
             <span class="sp1">红包推广</span>
             <span class="sp2"><?php echo $this->_var['bonus_allay_account']; ?></span>
            </a>
          </li>
       </ul>
    </section>
</section>

</div>
<?php echo $this->fetch('library/search.lbi'); ?>
<?php echo $this->fetch('library/user_footer3.lbi'); ?> 
<script type="text/javascript">
//圆形定义
function drawTimer(id, percent) {
    $('#note_' + id).html('<div class="percent"></div><div id="slice"' + (percent > 50 ? ' class="gt50"': '') + '><div class="pie"></div>' + (percent > 50 ? '<div class="pie fill"></div>': '') + '</div>');
    var deg = 360 * percent/100;
    $('#note_' + id + ' #slice .pie').css({
        '-moz-transform': 'rotate(' + deg + 'deg)',
        '-webkit-transform': 'rotate(' + deg + 'deg)',
        '-o-transform': 'rotate(' + deg + 'deg)',
        'transform': 'rotate(' + deg + 'deg)'
    });
	
    percent = Math.floor(percent * 100) / 100;
    arr2 = percent.toString().split('.');
    intr = arr2[0];
	
	intl=100-intr;
    $('#note_' + id + ' .percent').html('<span class="int-right">' + intr + '%</span>');
	$('#note_' + id + ' .percent').prepend('<span class="int-left">' + intl + '%</span>');
}
//计算值
function stopNote(id,note) {
	
	var seconds = (timerFinish - (new Date().getTime())) / 100;
    var percent = 100 - ((seconds / timerSeconds)*100); 
    if (percent <= note) {
        drawTimer(id, percent);
		
    }else{
		var data1 = $('#note_' + id).attr('data-a');
		var data2 = $('#note_' + id).attr('data-b');
        data1= parseFloat(data1);
	    data2= parseFloat(data2);
	    var sum =data1+data2;
		percent1=data1/sum;
	    percent2=data2/sum;
		
		percent1 = (percent1*100).toFixed(0);
		percent2 = (percent2*100).toFixed(0);
	    arr1 = percent1;
        arr2 = percent2;
		$('#note_' + id + ' .percent .int-left').html(arr1+'%');
        $('#note_' + id + ' .percent .int-right').html(arr2+'%');
	}
    
}
//旋转速度
$(document).ready(function() {
    timerSeconds = 50;
    timerFinish = new Date().getTime() + (timerSeconds * 100);
    $('.notesite').each(function(id) {
       data1 = $('#note_' + id).attr('data-a');
	   data2 = $('#note_' + id).attr('data-b');
	   
		data1= parseFloat(data1);
	    data2= parseFloat(data2);
	    var sum =data1+data2;
	   //alert(percent1);
	    percent1=data1/sum;
	    percent2=data2/sum;
	    percent1 =  Math.round(percent1*100)/100*100;
	    percent2 = Math.round(percent2*100)/100*100;
		percent=percent2;
	   
	   $('#note_' + id +'.notesite').removeClass("notesite2");
	   if(data2==0 && data1==0){
		   $('#note_' + id).html('<div class="percent"></div><div id="slice"' + (percent > 50 ? ' class="gt50"': '') + '><div class="pie"></div>' + (percent > 50 ? '<div class="pie fill"></div>': '') + '</div>');		   
		   $('#note_' + id + ' .percent').html('<span class="int-right">' + 0 + '%</span>');
	       $('#note_' + id + ' .percent').prepend('<span class="int-left">' + 0 + '%</span>');
		   $('#note_' + id +'.notesite').addClass("notesite2");
	   }else if(data2==0){
		   $('#note_' + id).html('<div class="percent"></div><div id="slice"' + (percent > 50 ? ' class="gt50"': '') + '><div class="pie"></div>' + (percent > 50 ? '<div class="pie fill"></div>': '') + '</div>');		   
		   $('#note_' + id + ' .percent').html('<span class="int-right">' + 0 + '%</span>');
	       $('#note_' + id + ' .percent').prepend('<span class="int-left">' + 100 + '%</span>');
	   }
	   else{
        var note=percent2;
        timer = setInterval('stopNote(' + id + ', '+ note +')', 0);
	   }
	 
    });
});

</script>
</body>
</html>