<!DOCTYPE html>

<html lang="zh-CN">

<head>

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>会员绑定</title>

	<link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/bootstrap/css/bootstrap.min.css" />
	<script src="<?php echo __PUBLIC__;?>/js/jquery.min.js"></script>
	<script src="<?php echo __PUBLIC__;?>/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo __PUBLIC__;?>/js/validform.js"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css?v=2024">
</head>

<body class="login-bg">

<div class="container-fluid" style="margin-top: 1.6rem;">

	<div class="row">

	<div class="col-sm-12 col-md-12 ">

		<div class="panel panel-default ">

			<div class="panel-heading">
              <a >绑定/注册</a>
            </div>
            
           <div class="panel-tab">
              <a  id="one" class="on">老用户</a><a id="two" class="new-user">新用户</a>
           </div>
           <div class="clear"></div> 
           
       <div class="panel-box">
			<div class="panel-body tab-pane panel-old  active">

			<form action="<?php echo url('wechat/plugin_action', array('name'=>'bd'));?>" method="post" class="form-horizontal validforms" role="form" onsubmit="if(!confirm('您确认要进行绑定操作吗'))return false;">

				<div class="form-group">

				    <!--<label class="col-sm-2 control-label">手机号</label>

				    <div class="col-sm-10">

				      <input type="text" class="form-control" placeholder="手机号" name="data[username]" datatype="*" />

				    </div>-->
                    
                    <b><i class="user_ico"></i></b>
                    <span><input placeholder="手机号" name="data[username]" type="text"  class="inputBg"  datatype="*" ></span>
                
                </div>
                <div class="login-line1"></div>
			  	<div class="form-group" >

				    <!--<label class="col-sm-2 control-label">密码</label>

				    <div class="col-sm-10">

				      <input type="password" class="form-control" placeholder="密码" name="data[password]" datatype="*6-16" />

				    </div>-->
                    
                    <b><i class="password_ico"></i></b>
                    <span><input placeholder="密码"  name="data[password]" type="password" class="inputBg" datatype="*6-16" /></span>

			  	</div>
                <div class="login-line1"></div>
			  	<div class="form-group">

				    <div class="col-sm-offset-2 col-sm-10">

						<input type="submit" class="btn btn-primary" value="确认" />

						<input type="reset" class="btn btn-default" value="重置" />

				    </div>

				 </div>

				<div class="form-group form-group-bottom">

					<p class="col-sm-12 control-label">1、如果您是老用户请输入帐号进行绑定。</p>

					<p class="col-sm-12 control-label">2、新用户输入用户名和密码进行注册并绑定。</p>

					<p class="col-sm-12 control-label">3、绑定后的帐号可以登录到其他终端。</p>

				</div>

			</form>

			</div>
            
           
           <!--新用户 start-->
           <div class="panel-body tab-pane panel-new">

			<form action="<?php echo url('wechat/plugin_action', array('name'=>'bd'));?>" method="post" class="form-horizontal validforms" role="form" onsubmit="if(!confirm('您确认要进行绑定操作吗'))return false;">

				<div class="form-group">

				    <!--<label class="col-sm-2 control-label">手机号</label>

				    <div class="col-sm-10">

				      <input type="text" class="form-control" placeholder="手机号" name="data[username]" datatype="*" />

				    </div>-->
                    
                    <b><i class="user_ico"></i></b>
                    <span><input placeholder="手机号" name="data[username]" type="text"  class="inputBg"  datatype="*" ></span>
                
                </div>
                <div class="login-line1"></div>
			  	<div class="form-group" >

				    <!--<label class="col-sm-2 control-label">密码</label>

				    <div class="col-sm-10">

				      <input type="password" class="form-control" placeholder="密码" name="data[password]" datatype="*6-16" />

				    </div>-->
                    
                    <b><i class="password_ico"></i></b>
                    <span><input placeholder="密码"  name="data[password]" type="password" class="inputBg" datatype="*6-16" /></span>

			  	</div>
                <div class="login-line1"></div>
			  	<div class="form-group">

				    <div class="col-sm-offset-2 col-sm-10">

						<input type="submit" class="btn btn-primary" value="确认" />

						<input type="reset" class="btn btn-default" value="重置" />

				    </div>

				 </div>

				

			</form>

			</div>
           
           <!--新用户 end-->
</div>


		</div>

	</div>

	</div>

</div>
<script type="text/javascript">
  $(".panel-tab a").click(function(){
	    $(".panel-tab a").removeClass("on");
		$(this).addClass("on");
	    var a=$(this).index();
		
		$(".panel-body").removeClass("active");
		$(".panel-body").eq(a).addClass("active");
		
	  })
</script>
</body>

</html>