<?php echo $this->fetch('library/user_header.lbi'); ?>


 <form name="formPassword" action="<?php echo url('user/bd_new');?>" method="post"  >
 <input type="hidden" name="flag" id="flag" value="register" />

<section class="user-register">
   <div class="rigister-box">
      <div class="flow-consignee ect-bg-colorf">
   		<ul>
       	  <li>
       	    <div class="input-text"><span>
   	        <input placeholder="请输入手机号" name="mobile" id="mobile_phone"  type="text"></span></div>
          </li>
       </ul>   
      </div> 
      
      <div class="flow-consignee ect-bg-colorf">   
         <ul>
          <li>
            <div class="input-text register-text">
              <span>
               <input placeholder="请输入短信验证码" name="mobile_code" id="mobile_code" type="text" >
              </span>
            </div>
            <div class="get-code">
                <input class="pull-right ect-bg get-ma"  id="zphone" name="sendsms"  type="button" value="获取验证码" onClick="sendSms();" />
            </div>
          </li>

          <li>
            <div class="input-text">
               <span><input placeholder="输入密码" name="password" id="password" type="password" datatype="*6-20" style="width:82%"></span>
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
 


   <input name="act" type="hidden" value="bd_new" />
   <input type="hidden" name="sms_code" value="<?php echo $this->_var['sms_code']; ?>" id="sms_code" />

   <div class="two-btn ect-padding-tb ect-margin-tb text-center">
      <input name="submit"  id="comfirm" type="submit" class="btn btn-info" value="确认绑定" />
   </div>
 </form>
 
   </div> 
</section> 
</div>
<?php echo $this->fetch('library/search.lbi'); ?>
<script type="text/javascript" src="__PUBLIC__/js/jquery.min.js" ></script> 

<script type="text/javascript" src="__PUBLIC__/js/sms.js"></script> 

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
	
	$("#comfirm").click(function(){
		var password=$("#password").val();
		if(password.length<6 || password.length>20){
			alert("密码由6-20位字符组成，区分大小写");
			return false;
		}
	});
	
	$(".user-register .input-text em").click(function(){
		  document.getElementById("password").value=null;
		 })
</script>

</body>



</html>