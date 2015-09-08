<!DOCTYPE html>
<html>
<head>
<meta name="Generator" content="ECSHOP v2.7.3" />
<meta charset="utf-8" />
<title>云的商城</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<meta name="format-detection" content="telephone=no" />
<meta property="qc:admins" content="14163061664436375" />
<link href="themes/ecmoban_meilishuo/css/yun.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="themes/ecmoban_meilishuo/js/jquery-1.9.1.min.js" ></script> 
<script>
  window.location="mobile";
</script>
</head>
<body>
    
    
    <div class="login ng-scope" ng-controller="loginController" ng-if="true">

        
        <div class="logo">
            <i class="web_wechat_login_logo"></i>
        </div>
        
        
        <div class="login_box">
            <div class="qrcode" ng-class="{hide: isScan}">
                <img class="img" src="themes/ecmoban_meilishuo/images/pc-h-weixin.jpg">
                <p class="sub_title">微信扫码关注我们</p>
                
                <div class="extension">
                    <div class="item">
                        <i class="icon web_wechat_login_phone_icon"></i>
                        <div class="cont">
                            <h4 class="title">请用手机打开</h4>
                            <p class="desc">
                              wwww.yundds.com
                            </p>
                        </div>
                    </div>
                    <div class="item item2">
                        <i class="icon web_wechat_login_scan_icon"></i>
                        <div class="cont">
                            <h4 class="title">扫一扫”</h4>
                            <p class="desc">进入商城首页</p>
                        </div>
                        <div class="login_box login_box2">
                           <div class="qrcode" ng-class="{hide: isScan}">
                              <img class="img" src="themes/ecmoban_meilishuo/images/pc-h-weixin2.png">
                              <p class="sub_title">扫一扫进入商城</p>
                
                          </div>
                        </div>
                       
        
                    </div>
                </div>
                
           </div> 
           
        </div>
       
        
                        
        <div class="copyright">
            <p class="desc">
            <a style="margin-right:1em;" href="http://www.yundds.com/mobile/index.php?m=default&c=article&a=art_list&id=6">关于我们</a><a style="margin-right:1em;" href="http://m.kuaidi100.com" target="_blank">快递查询</a>© 2005-2015 云的商城 版权所有，并保留所有权利。<a href="http://www.miibeian.gov.cn/" target="_blank">粤ICP备15053130号</a></p>
        </div>
        
    </div>
    
 <script type="text/javascript">
    $(".item2").hover(function(){
		
		  $(".login_box2").fadeIn();
		  $(this).addClass("hover");
		},function(){
			 $(".login_box2").fadeOut();;
			  $(this).removeClass("hover");
			})
	
 </script>   
</body>

</html>
