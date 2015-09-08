

<script type="text/javascript" src="__PUBLIC__/js/region.js"></script>

<script type="text/javascript">

          region.isAdmin = false;

          <?php $_from = $this->_var['lang']['flow_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>

          var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";

          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>



          

          onload = function() {

            if (!document.all)

            {

              document.forms['theForm'].reset();

            }

          }

          

        </script>

<div class="con">

  <div class="ect-bg">

   <header id="header" class="header">

    <div class="user-header">

      <h1 ><?php echo $this->_var['title']; ?></h1>

      <div class="header_l header_return"> <a class="ico_10_2" href="javascript:history.go(-1);"> 返回 </a> </div>

      <div class="header_r header_search"> <a class="ico_18_2" href="javascript:void(0);"> 会员中心菜单</a> </div>
      <?php echo $this->fetch('library/page_menu_member.lbi'); ?>
   </div>
   </header>
   <div class="line-top"></div>
  </div>

<section class="ect-text-style">

   

  <?php $_from = $this->_var['consignee_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('sn', 'consignee');if (count($_from)):
    foreach ($_from AS $this->_var['sn'] => $this->_var['consignee']):
?>    

     <form action="<?php echo url('flow/consignee');?>" method="post" name="theForm" id="theForm" onSubmit="return checkConsignee(this)">

        <?php echo $this->fetch('library/consignee.lbi'); ?>

     </form>

  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 

</section>

</div>

