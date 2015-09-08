<?php echo $this->fetch('library/user_header.lbi'); ?>

<section class="balance2_list">

   <ul>

<!--

     <li>

       <a class="title" href="<?php echo url('user/edit_avatar');?>">

          <span class="sp1">修改头像</span>

          <i></i>

       </a>

     </li>

-->

     <li>

       <a class="title" href="<?php echo url('user/edit_password');?>">

          <span class="sp1"><?php echo $this->_var['lang']['edit_password']; ?></span> 

          <i></i>

         <!--<span class="sp2">497.50元</span>-->

       </a>

     </li>



     <li>

       <a class="title" href="<?php echo url('user/address_list');?>">

          <span class="sp1"><?php echo $this->_var['lang']['label_address']; ?></span> 

          <i></i>

       </a>

     </li>



     <li>

       <a class="title" href="<?php echo url('user/profile');?>">

          <span class="sp1"><?php echo $this->_var['lang']['profile']; ?></span>

          <i></i>

       </a>

     </li>



     <li>

       <a class="title" href="<?php echo url('user/tag_list');?>">

          <span class="sp1"><?php echo $this->_var['lang']['label_tag']; ?></span>

          <i></i>

       </a>

     </li>



	</ul>

</section>


</div>
<?php echo $this->fetch('library/search.lbi'); ?> <?php echo $this->fetch('library/user_footer.lbi'); ?>

</body>

</html>