<?php echo $this->fetch('library/page_header.lbi'); ?>

<div class="con">

  <div style="height:6em;"></div>

<header id="header" class="header" >
  <div class="header_l header_return"> <a class="ico_10_3" href="javascript:history.go(-1)"> 返回 </a> </div>
    <h1> 所有分类页 </h1>
  <div class="header_r header_search"> <a class="ico_03_02" href="javascript:openSearch();"> 搜索 </a> </div>
</header>

  <?php echo $this->fetch('library/goods_list.lbi'); ?> </div>

<?php echo $this->fetch('library/search.lbi'); ?> <?php echo $this->fetch('library/page_footer_category.lbi'); ?> 

<script type="text/javascript">

if( <?php echo $this->_var['show_asynclist']; ?> == 1){

 	get_asynclist('<?php echo url('category/asynclist', array('id'=>$this->_var['id'], 'brand'=>$this->_var['brand_id'], 'price_min'=>$this->_var['price_min'], 'price_max'=>$this->_var['price_max'], 'filter_attr'=>$this->_var['filter_attr'], 'page'=>$this->_var['page'], 'sort'=>$this->_var['sort'], 'order'=>$this->_var['order'], 'keywords'=>$this->_var['keywords']));?>' , '__TPL__/images/loader.gif');

 }

</script>

</body></html>