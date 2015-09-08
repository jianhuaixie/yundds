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
    <h1 >手机快速注册</h1>
    <div class="header_l header_return"> <a class="ico_10_3" href="<?php echo url('user/my_tuiguang');?>"> 返回 </a> </div>
  </div>
</header>
 <div class="line-top"></div>

<div class="user-register"> 
 <?php if ($this->_var['shop_reg_closed'] == 1): ?>
    <p class="text-center" style="font-size: x-large;"><?php echo $this->_var['lang']['shop_register_closed']; ?></p>

    <?php else: ?>
  <?php if ($this->_var['enabled_sms_signin'] == 1): ?>
<!--  <ul class="nav nav-tabs" role="tablist">
    <li class="active"><a href="#one" role="tab" data-toggle="tab"><?php echo $this->_var['lang']['mobile_login']; ?></a></li>
    <li><a href="#two" role="tab" data-toggle="tab"><?php echo $this->_var['lang']['emaill_login']; ?></a></li>
  </ul>-->
  <div class="tab-content rigister-box">
    <div class="tab-pane active" id="one">

      <form action="<?php echo url('user/register');?>" method="post" name="formUser" onsubmit="return register2();">
        <input type="hidden" name="flag" id="flag" value="register" />

        <div class="flow-consignee ect-bg-colorf">
          <ul>
            <li>
              <div class="input-text"><span>
                <input placeholder="<?php echo $this->_var['lang']['no_mobile']; ?>" class="inputBg" name="mobile" id="mobile_phone" type="text">
                </span></div>
            </li>
 
          </ul>
        </div>

        
       <div class="flow-consignee ect-bg-colorf">
          <ul>
             <!--<div class="register-notice"><span>该手机号已注册</span></div>-->
            <li>
              <div class="input-text register-text">
              <span><input placeholder="请输入短信验证码" class="inputBg" name="mobile_code" id="mobile_code" type="text" ></span>
              </div>
              
              <div class="get-code">
                <input class="pull-right ect-bg get-ma"  id="zphone" name="sendsms" type="button" value="<?php echo $this->_var['lang']['get_code']; ?>" onClick="sendSms();" />
              </div>
              
         
            </li>
             
            <li>
              <div class="input-text">
                <span><input  placeholder="请设置登录密码" class="inputBg" name="password" id="password" type="password" datatype="*6-20"></span>	
                <em><img src="themes/default/images/register-close.png" /></em>
              </div>
              
              <div class="login-show-button">
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
            
             <p class="register-notice2">密码由6-20位字符组成，区分大小写</p>
             
          </ul>
        </div>
        
         <!--<p class="ect-padding-lr ect-margin-bottom0"><label style="font-size:10px;"><?php echo $this->_var['lang']['sms_signin_register']; ?></label></p>-->
        <p class="ect-checkbox ect-padding-tb ect-margin-tb ect-margin-bottom0">
          <input id="agreement1" name="agreement" type="checkbox" value="1" checked="checked" >
          <label for="agreement1"><?php echo $this->_var['lang']['agreement']; ?><i></i></label>
        </p>
        
        <div class="ect-padding-tb register-bt">
          <input name="enabled_sms" type="hidden" value="1" />
          <input type="hidden" name="sms_code" value="<?php echo $this->_var['sms_code']; ?>" id="sms_code" />
          <input type="hidden" name="back_act" value="<?php echo $this->_var['back_act']; ?>" />
          <button name="Submit" type="submit" class="btn btn-info ect-btn-info ect-colorf ect-bg">完成</button>
        </div>

      </form>
    </div>
    <script type="text/javascript" src="__PUBLIC__/js/sms.js"></script> 
    <?php endif; ?>
    
    
    <div class="tab-pane" id="two">
      <form action="<?php echo url('user/register');?>" method="post" name="formUser" class="validforms" >
        <input type="hidden" name="flag" id="flag" value="register" />
        <div class="flow-consignee ect-bg-colorf">
          <ul>
          <li>
              <div class="input-text"><b><?php echo $this->_var['lang']['label_username']; ?>：</b><span>
                <input placeholder="<?php echo $this->_var['lang']['no_username']; ?>" name="username" type="text" id="username" datatype="*3-15" errormsg="<?php echo $this->_var['lang']['msg_mast_length']; ?>" />

                </span></div>
            </li>

            <li>
              <div class="input-text"><b><?php echo $this->_var['lang']['email']; ?>：</b><span>
                <input placeholder="<?php echo $this->_var['lang']['no_emaill']; ?>" name="email" type="text" id="email" datatype="e" />
                </span></div>
            </li>
            <li>
              <div class="input-text"><b><?php echo $this->_var['lang']['password']; ?>：</b><span>
                <input  placeholder="<?php echo $this->_var['lang']['no_password']; ?>" class="inputBg" name="password" id="password1" type="password" datatype="*6-16">

                <input  placeholder="<?php echo $this->_var['lang']['no_password']; ?>" class="inputBg" id="password_text" type="text" style="display:none;">
                </span><i class="glyphicon glyphicon-eye-open" onClick="clickText();"></i></div>

            </li>

			<?php $_from = $this->_var['extend_info_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'field');if (count($_from)):
    foreach ($_from AS $this->_var['field']):
?>
			<?php if ($this->_var['field']['id'] == 6): ?>
			<li>
        <div class="form-select"> <i class="fa fa-sort"></i>

		  <select name='sel_question'>
		  	<option value='0'><?php echo $this->_var['lang']['sel_question']; ?></option>
                  <?php $_from = $this->_var['password_question']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'question');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['question']):
?>
   					 <option value="<?php echo $this->_var['key']; ?>"><?php echo $this->_var['question']; ?></option>

                  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </select>

        </div>
      </li>
      <li>
        <div class="input-text"><b class="pull-left"><?php echo $this->_var['lang']['passwd_answer']; ?>:</b> <span>
          <input placeholder="<?php echo $this->_var['lang']['passwd_answer']; ?>" name="passwd_answer" type="text" value="<?php echo $this->_var['profile']['passwd_answer']; ?>" />
          </span></div>
      </li>
			<?php else: ?>
			<li>
				<div class="input-text"><b><?php echo $this->_var['field']['reg_field_name']; ?>：</b>
				<span>
					<input name="extend_field<?php echo $this->_var['field']['id']; ?>" type="text" size="25" class="inputBg" <?php if ($this->_var['field']['is_need']): ?> style="width:85%;"<?php endif; ?> /><?php if ($this->_var['field']['is_need']): ?><font style="color:#FF0000;float:right"> *</font><?php endif; ?>

                </span></div>
			</li>
			<?php endif; ?>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
             <?php if ($this->_var['enabled_captcha']): ?>
            <li>
              <div class="input-text code"><b><?php echo $this->_var['lang']['code']; ?>：</b><span>
                <input placeholder="<?php echo $this->_var['lang']['no_code']; ?>"  name="captcha" id="captcha" type="text" datatype="*" />
                </span><img class="pull-right" src="<?php echo url('public/captcha', array('rand'=>$this->_var['rand']));?>" alt="captcha"  onClick="this.src='<?php echo url('public/captcha');?>&t='+Math.random()" /></div>
            </li>
             <?php endif; ?>
          </ul>
        </div>
        
        
        <p class="ect-checkbox ect-padding-tb ect-margin-tb ect-margin-bottom0 ect-padding-lr">
          <input id="agreement" name="agreement" type="checkbox" value="1" checked="checked" />
          <label for="agreement"> <?php echo $this->_var['lang']['agreement']; ?><i></i></label>
        </p>
        <div class="ect-padding-lr ect-padding-tb">
          <input name="act" type="hidden" value="act_register" />
          <input name="enabled_sms" type="hidden" value="0" />
          <input type="hidden" name="back_act" value="<?php echo $this->_var['back_act']; ?>" />
          <button name="Submit" type="submit" class="btn btn-info ect-btn-info ect-colorf ect-bg"><?php echo $this->_var['lang']['next']; ?></button>

        </div>
      </form>
    </div>
  </div>
</div>
<?php endif; ?>


<div class="blank3"></div>

</div>
<?php echo $this->fetch('library/search.lbi'); ?> 
<script type="text/javascript" src="__PUBLIC__/js/jquery.min.js" ></script> 


<script type="text/javascript">
   
   $(".user-register .login-show-button dl").click(function(){
	     var a=$(".user-register .login-show-button dl").attr("class");
		 if(a=="show"){
			   $(this).removeClass("show");
			   $("#password").attr("type","password");
			 }
	      else{
			    $(this).addClass("show");
				$("#password").attr("type","text");
			  }
	   })
	$(".user-register .input-text em").click(function(){
		  document.getElementById("password").value=null;
		 })   
</script>
