<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta name="Generator" content="ECTouch 1.0" />

<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

<meta name="Keywords" content="<?php echo $this->_var['meta_keywords']; ?>" />

<meta name="Description" content="<?php echo $this->_var['meta_description']; ?>" />

<title><?php echo $this->_var['page_title']; ?> 触屏版</title>


<link rel="stylesheet" href="__PUBLIC__/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="__PUBLIC__/bootstrap/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo $this->_var['ectouch_css_path']; ?>">
<link rel="stylesheet" href="__TPL__/css/style.css">
<link rel="stylesheet" href="__TPL__/css/user.css">
<link rel="stylesheet" href="__TPL__/css/photoswipe.css">
</head>

<body>
<div class="con">

<header id="header" class="header">
  <div class="user-header">
    <h1 ><?php echo $this->_var['title']; ?></h1>
    <div class="header_l header_return"> <a class="ico_10_3" href="index.php?a=index<?php if ($_SESSION['user_id'] > 0): ?>&u=<?php echo $_SESSION['user_id']; ?><?php else: ?>&u=0<?php endif; ?>"> 返回 </a> </div>
  </div>
</header>
 <div class="line-top"></div>



<section class="login-photo">
   <div class="bg"><a><img src="themes/default/images/user-promote-bg2.png" /></a></div>
   <div class="photo"><a><img src="themes/default/images/link_logo.jpg" /></a></div>
</section>




<div class="login-box">

 <form name="formLogin" action="<?php echo url('user/login');?>" method="post" class="validforms">
   <div class="flow-consignee ect-bg-colorf">

     <section>
      <ul>
   		<li>
    	 <div class="input-text"><b>账&nbsp;&nbsp;&nbsp;&nbsp;号：</b><span class="zhangh"><input placeholder="手机号" name="username" type="text"  class="inputBg" id="username" datatype="*" ></span></div>
        </li>
        <li>

    	<div class="input-text"><b>密&nbsp;&nbsp;&nbsp;&nbsp;码：</b><span>
        
          <input placeholder="请输入密码"  name="password" type="password" id="password" class="inputBg" datatype="*6-20" />
       
          </span></div>
 
         <div class="login-show-button">
            <span><img src="themes/default/images/login-colse.png" /></span>
            <dl>
               <dt></dt>
               <dd class="d1">abc</dd>
               <dd class="d2">
                 <em></em>
                 <em></em>
                 <em></em>
               </dd>
            </dl>
         </div>
        </li>

    
        <?php if ($this->_var['enabled_captcha']): ?>

        <li>
          <div class="input-text code"><b>验证码：</b><span>
             <input name="captcha" type="text" class="inputBg" placeholder="<?php echo $this->_var['lang']['comment_captcha']; ?>">
             </span><img src="<?php echo url('Public/captcha', array('rand'=>$this->_var['rand']));?>" alt="captcha" class="img-yzm pull-right" onClick="this.src='<?php echo url('public/captcha');?>&t='+Math.random()" />
         </div>
        </li>

           
         <?php endif; ?>
        </ul>
      </section>
    </div>


   <input type="hidden" name="back_act" value="<?php echo $this->_var['back_act']; ?>" />
  <div class="ect-padding-lr ect-padding-tb login-bt"> 
  <input type="submit" class="btn btn-info ect-btn-info ect-bg" value="登录" />
  </div>
  
    <p class="ect-checkbox ect-padding-tb ect-margin-tb ect-margin-bottom0 ect-padding-lr ">

     <input type="checkbox" value="1" name="remember" id="remember" class="l-checkbox" />
     <label for="remember">记住密码<i></i></label>
      <?php if ($this->_var['anonymous_buy'] == 1 && $this->_var['step'] == 'flow'): ?>

      <a href="<?php echo url('flow/consignee',array('direct_shopping'=>1));?>" style="float:right;"><?php echo $this->_var['lang']['direct_shopping']; ?></a>
      <?php endif; ?>
  </p>
  
  </form>
  <p class="ect-padding-lr ect-margin-tb text-right ect-margin-bottom0 login-mz" style="clear:both;">
	<a class="ma" href="<?php echo url('user/get_password_phone');?>"><?php echo $this->_var['lang']['forgot_password']; ?></a>  
	<a class="zc" href="<?php echo url('user/register');?>"><?php echo $this->_var['lang']['free_registered']; ?></a>
  </p>

  
</div>

</div>


<div class="clear"></div>


<div class="login-title">
   <span>使用合作账号登录/注册</span>
</div>

<p class="login-way">
    <a class="qq-login" href="<?php echo url('user/third_login',array('type'=>'qq'));?>">
      <span><img src="themes/default/images/login-qq.png">使用QQ账号登录</span>
     </a>
    <a class="weib-login" href="<?php echo url('user/third_login',array('type'=>'sina'));?>">
      <span><img src="themes/default/images/login-weibo.png">使用微博账号登录</span>
    </a>
 </p>
 
 <div class="blank2"></div>






  <!--<div class="login-promise">
    <ul>
      <li><span>七天无理由退换货</span></li>
      <li><span>100%正品</span></li>
    </ul>

  </div>-->
  



  
<?php echo $this->fetch('library/search.lbi'); ?>
<script type="text/javascript" src="__PUBLIC__/js/jquery.min.js" ></script> 

<script type="text/javascript">
   
   $(".login-show-button dl").click(function(){
	     var a=$(".login-show-button dl").attr("class");
		 if(a=="show"){
			   $(this).removeClass("show");
			   $("#password").attr("type","password");
			 }
	      else{
			    $(this).addClass("show");
				$("#password").attr("type","text");
			  }
	   })
	   
	 $(".login-show-button span").click(function(){
		  document.getElementById("password").value="";
		 })
	
	
	
	
	/*var val=document.getElementById("password").value;
	if(val=="请输入密码"){
			 $(".login-show-button span").css("display","none");
			}
		else{
		  $(".login-show-button span").css("display","block");
		}
	
		
	$("#password").keypress(function(){
		var val=document.getElementById("password").value;
		alert(val);
		if(val==""){
			 $(".login-show-button span").css("display","none");
			}
		else{
		  $(".login-show-button span").css("display","block");
		}
		
		})*/
</script>
</body>

</html>







