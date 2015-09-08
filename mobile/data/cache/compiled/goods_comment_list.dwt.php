<?php echo $this->fetch('library/page_header.lbi'); ?>

<div class="con">
  <div class="ect-bg user-header">
    <header class="ect-header ect-margin-tb ect-margin-lr text-center icon-write "> 
      <a href="javascript:history.go(-1)" class="pull-left ico_10_3"></a> 
      <span><?php echo $this->_var['title']; ?></span> 
      <a href="./<?php if ($_SESSION['user_id'] > 0): ?>?u=<?php echo $_SESSION['user_id']; ?><?php endif; ?>" class="pull-right ico_18_3"></a>

      <?php echo $this->fetch('library/page_menu_member.lbi'); ?> 
    </header>
  

  </div>



  <?php echo $this->fetch('library/comments.lbi'); ?>



  



</div>



<?php echo $this->fetch('library/search.lbi'); ?> <?php echo $this->fetch('library/page_footer3.lbi'); ?>



</body></html>