<?php echo $this->fetch('library/page_header.lbi'); ?>

<div class="con con2">

<header id="header" class="header">

  <div class="user-header">
    <h1 ><?php echo $this->_var['title']; ?></h1>
    <div class="header_l header_return"> <a class="ico_10_3" href="<?php echo url('user/my_tuiguang');?>"> 返回 </a> </div>
   <div class="header_r header_search"> <a class="ico_18_3" href="index.php?a=index<?php if ($_SESSION['user_id'] > 0): ?>&u=<?php echo $_SESSION['user_id']; ?><?php else: ?>&u=0<?php endif; ?>"> 会员中心菜单</a> </div>
 
    
   

  </div>


</header>
 <div class="line-top"></div>


 <section class="user-profit">
 
  <!-- <section class="user-profit">
     <div class="category-list">
       <a class="a1 on" id="pro_a1" href="index.php?m=default&c=user&a=my_shouyi&n=a1">收益金额</a>
       <a class="a2" id="pro_a2" href="index.php?m=default&c=user&a=my_shouyi&n=a2">销售金额</a>  
     </div>
   </section>-->
      
     <section class="user-profit-top show" id="profita1">
          <div class="demo">
              <dl class="notes">
               <dt class="html">
                 <div class="notesite" id="note_0" data-a="<?php echo $this->_var['earnning_thismonth']; ?>" data-b="<?php echo $this->_var['earnning_lastmonth']; ?>" dir="10"></div>
               </dt>
              </dl>
           </div>
         
         <div class="profit-data" >  
            <p class="data-before"><span><?php echo $this->_var['earnning_thismonth']; ?></span><em>本月推广收益</em></p>
            <p class="data-after"><span><?php echo $this->_var['earnning_lastmonth']; ?></span><em>本月渠道收益</em></p>
         </div>
         
         <div class="profit-data profit-data2" >  
            <p class="data-before"><em>本月推广销售</em><span><?php echo $this->_var['sell_tuiguang']; ?></span></p>
            <p class="data-after"><em>本月渠道销售</em><span><?php echo $this->_var['sell_qudao']; ?></span></p>
         </div> 
         
       </section>
       
      <!--<section class="user-profit-top" id="profita2">
           <div class="demo">
              <dl class="notes">
               <dt class="html">
                 <div class="notesite" id="note_1" data-a="<?php echo $this->_var['earnning_tuiguang']; ?>" data-b="<?php echo $this->_var['earnning_qudao']; ?>" dir="10"></div>
               </dt>
              </dl>
           </div>
         
         <div class="profit-data">  
            <p class="data-before"><span><?php echo $this->_var['sell_tuiguang']; ?></span><em>本月推广销售</em></p>
            <p class="data-after"><span><?php echo $this->_var['sell_qudao']; ?></span><em>本月渠道销售</em></p>
         </div> 
       </section>-->
       
        <div class="clear"></div>
        
       <section class="user-profit-link">
         <h4>每月15号结算上月收益</h4>
         <ul>
           <li>
             <a class="title" href="index.php?m=default&c=user&a=earnings_detail">
               <span class="sp1">收益详情</span>
               <i></i>
             </a>
           </li>
           
           <li>
             <a class="title" href="index.php?m=default&c=user&a=earnings_overview">
               <span class="sp2">结算详情</span>
               <i></i>
             </a>
           </li>
           
         </ul>
       </section>
</section>

</div>
<?php echo $this->fetch('library/search.lbi'); ?>
<?php echo $this->fetch('library/user_footer.lbi'); ?>
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
    
    var data1 = $('#note_' + id).attr('data-a');
	var data2 = $('#note_' + id).attr('data-b');
    data1= parseFloat(data1);
    data2= parseFloat(data2);
	
	var sum =data1+data2;
	sum = Math.round(sum*100)/100;
    $('#note_' + id + ' .percent').html('<span class="all">' + sum + '<em>总收益（元）</em></span>');

}

//计算值
function stopNote(id,note) {
	
	var seconds = (timerFinish - (new Date().getTime())) / 100;
    var percent = 100 - ((seconds / timerSeconds)*100); 
    if (percent <= note) {
        drawTimer(id, percent);
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
		   $('#note_' + id + ' .percent').html('<span class="all">' + sum + '<em>总收益（元）</em></span>');
		   $('#note_' + id +'.notesite').addClass("notesite2");
	   }else if(data2==0){
		   $('#note_' + id).html('<div class="percent"></div><div id="slice"' + (percent > 50 ? ' class="gt50"': '') + '><div class="pie"></div>' + (percent > 50 ? '<div class="pie fill"></div>': '') + '</div>');		   
		   $('#note_' + id + ' .percent').html('<span class="all">' + sum + '<em>总收益（元）</em></span>');
	   }
	   else{
		   
    var note=percent2;
        timer = setInterval('stopNote(' + id + ', '+ note +')', 0);
	   }
    });
});

var n=getUrlParams("n");

$(".user-profit .category-list a").removeClass("on");
$(".user-profit-top").removeClass("show");

$('#pro_' + n).addClass("on");
$('#profit' + n).addClass("show");
	  
</script>
</body>
</html>