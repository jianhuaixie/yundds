<section class="h-brand">
  <div class=" h-floor">
    <div class="h-floor-title"><span>热门市场</span><a href="<?php echo url('category/top_all');?><?php if ($_SESSION['user_id'] > 0): ?>&u=<?php echo $_SESSION['user_id']; ?><?php endif; ?>">查看更多>></a></div>
  </div>
   <div class="brand-box">
      <?php 
$k = array (
  'name' => 'ads',
  'id' => '15',
  'num' => '10',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?>
   </div>
</section>
<div class="clear"></div>
<div class="blank2"></div>