<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta name="Keywords" content="<?php echo $this->_var['meta_keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['meta_description']; ?>" />
<?php if ($this->_var['auto_redirect']): ?>
<meta http-equiv="refresh" content="3;URL=<?php echo $this->_var['message']['back_url']; ?>" />
<?php endif; ?>
<title><?php echo $this->_var['page_title']; ?></title>
<link rel="stylesheet" href="__PUBLIC__/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="__PUBLIC__/bootstrap/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo $this->_var['ectouch_css_path']; ?>">
<link rel="stylesheet" href="__TPL__/css/style.css">
<link rel="stylesheet" href="__TPL__/css/user.css">
<link rel="stylesheet" href="__TPL__/css/photoswipe.css">
<script type="text/javascript" src="__TPL__/js/TouchSlide.1.1.js"></script>
</head><body>
<div id='wx_logo' style='margin:0 auto;display:none;'><img src="<?php echo $this->_var['goods']['original_img']; ?>" /></div>