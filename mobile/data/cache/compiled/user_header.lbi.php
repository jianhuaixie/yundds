<!DOCTYPE html>



<html lang="zh-CN">



<head>



<meta charset="utf-8">



<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">



<meta name="Keywords" content="<?php echo $this->_var['meta_keywords']; ?>" />



<meta name="Description" content="<?php echo $this->_var['meta_description']; ?>" />



<title><?php echo $this->_var['page_title']; ?></title>



<link rel="stylesheet" href="__PUBLIC__/bootstrap/css/bootstrap.min.css">



<link rel="stylesheet" href="__PUBLIC__/bootstrap/css/font-awesome.min.css">



<link rel="stylesheet" href="<?php echo $this->_var['ectouch_css_path']; ?>">



<link rel="stylesheet" href="__TPL__/css/style.css">



<link rel="stylesheet" href="__TPL__/css/user.css?v=0001">



<link rel="stylesheet" href="__TPL__/css/photoswipe.css">



</head>







<body>



<div class="con">







<!--



 <div class="ect-bg">



  <header class="ect-header ect-margin-tb ect-margin-lr text-center ect-bg icon-write">



     <a href="javascript:history.go(-1)" class="pull-left ico_10"></a> 



     <span><?php echo $this->_var['title']; ?></span> 



     <a href="javascript:;" onClick="openMune()" class="pull-right ect-icon ect-icon1 ect-icon-mune"></a>



 </header>



  <nav class="ect-nav ect-nav-list" style="display:none;">



    <ul class="ect-diaplay-box text-center">



      <li class="ect-box-flex"><a href="index.php?a=index"><i class="ect-icon ect-icon-home"></i><?php echo $this->_var['lang']['home']; ?></a></li>



      <li class="ect-box-flex"><a href="<?php echo url('category/top_all');?>"><i class="ect-icon ect-icon-cate"></i><?php echo $this->_var['lang']['category']; ?></a></li>



      <li class="ect-box-flex"><a href="javascript:openSearch();"><i class="ect-icon ect-icon-search"></i><?php echo $this->_var['lang']['search']; ?></a></li>



      <li class="ect-box-flex"><a href="<?php echo url('flow/cart');?>"><i class="ect-icon ect-icon-flow"></i><?php echo $this->_var['lang']['shopping_cart']; ?></a></li>



      <li class="ect-box-flex"><a href="<?php echo url('user/index');?>"><i class="ect-icon ect-icon-user"></i><?php echo $this->_var['lang']['user_center']; ?></a></li>



    </ul>



  </nav>



-->







<header id="header" class="header">
  <div class="user-header">
    <h1 ><?php echo $this->_var['title']; ?></h1>
    <div class="header_l header_return"> <a class="ico_10_3" href="javascript:history.go(-1);"> 返回 </a> </div>
    <div class="header_r header_search"> <a class="ico_18_3" href="./<?php if ($_SESSION['user_id'] > 0): ?>?u=<?php echo $_SESSION['user_id']; ?><?php endif; ?>"> 会员中心菜单</a> </div>
  </div>

</header>

<!--<dl class="member-list-menu2">
  <dt class="first">
    <a href="./<?php if ($_SESSION['user_id'] > 0): ?>?u=<?php echo $_SESSION['user_id']; ?><?php endif; ?>">
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







