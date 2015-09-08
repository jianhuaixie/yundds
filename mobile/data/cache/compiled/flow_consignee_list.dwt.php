<?php echo $this->fetch('library/page_header.lbi'); ?>

<div class="con">

<header id="header" class="header">

    <div class="user-header">

      <h1 ><?php echo $this->_var['title']; ?></h1>

      <div class="header_l header_return"> <a class="ico_10_2" href="javascript:history.go(-1);"> 返回 </a> </div>

      <div class="header_r header_search"> <a class="ico_18_2" href="javascript:void(0);"> 会员中心菜单</a> </div>
      <?php echo $this->fetch('library/page_menu_member.lbi'); ?>
   </div>
   </header>

<div class="menu-bg"></div>
 <div class="line-top"></div>

<div class="flow-consignee-list ect-bg-colorf">

  <section>

    <ul id="J_ItemList">

      <li class="ect-padding-tb checkout-add single_item "> </li>

      <a href="javascript:;" style="text-align:center" class="get_more"></a>

    </ul>

  </section>

</div>

<div class="ect-padding-lr ect-padding-tb ect-margin-tb"> <a href="<?php echo url('flow/consignee');?>" type="botton" class="btn btn-info ect-btn-info ect-colorf "><?php echo $this->_var['lang']['add_address']; ?></a> </div>

</div>

<?php echo $this->fetch('library/search.lbi'); ?> <?php echo $this->fetch('library/page_footer2.lbi'); ?> 

<script type="text/javascript" src="__PUBLIC__/js/jquery.more.js"></script> 

<script type="text/javascript">

get_asynclist('<?php echo url("flow/consignee_list");?>' , '__TPL__/images/loader.gif');</script>

</body></html>