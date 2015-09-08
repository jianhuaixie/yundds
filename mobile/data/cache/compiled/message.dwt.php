<?php echo $this->fetch('library/page_header.lbi'); ?>

<div class="con">

<div class="ect-bg">



    <header id="header" class="header">

    <div class="user-header">

      <h1 ><?php echo $this->_var['title']; ?></h1>

      <div class="header_l header_return"> <a class="ico_10_3" href="javascript:history.go(-1);"> 返回 </a> </div>

      <div class="header_r header_search"> <a class="ico_18_3" href="javascript:void(0);"> 会员中心菜单</a> </div>

      <?php echo $this->fetch('library/page_menu_member.lbi'); ?>  

    </div>

  </header>

  <div class="line-top"></div>

   

    <nav class="ect-nav ect-nav-list" style="display:none;"> <?php echo $this->fetch('library/page_menu.lbi'); ?> </nav>

  </div>

  <div  style="text-align:center; margin-top:2em;">

<p style=" font-size:1em;"><?php echo $this->_var['message']['content']; ?></p>

<?php if ($this->_var['message']['url_info']): ?>

<div> 

  <?php $_from = $this->_var['message']['url_info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('info', 'url');if (count($_from)):
    foreach ($_from AS $this->_var['info'] => $this->_var['url']):
?>

  <span class="p-link" style="margin-right:0.2em;"><a href="<?php echo $this->_var['url']; ?>" style="font-size:1.3em;"><?php echo $this->_var['info']; ?></a></span>

  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 

</div>

<?php endif; ?>

<div style="width:1px; height:1px; overflow:hidden"><?php $_from = $this->_var['lang']['p_y']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'pv');if (count($_from)):
    foreach ($_from AS $this->_var['pv']):
?><?php echo $this->_var['pv']; ?><?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?></div>

</div>

</div>

<?php echo $this->fetch('library/search.lbi'); ?>

<?php echo $this->fetch('library/page_footer2.lbi'); ?>

</body>

</html>