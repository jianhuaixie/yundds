
<section>

  <?php $_from = $this->_var['new_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods_0_12736800_1441595394');$this->_foreach['new_goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['new_goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods_0_12736800_1441595394']):
        $this->_foreach['new_goods']['iteration']++;
?>
  <?php if ($this->_foreach['new_goods']['iteration'] < 5): ?>

  <div class="h-floor-box">

     <div class="h-floor-content">

        <li><a href="<?php echo $this->_var['goods_0_12736800_1441595394']['url']; ?>"><img src="<?php echo $this->_var['goods_0_12736800_1441595394']['thumb']; ?>" alt="<?php echo htmlspecialchars($this->_var['goods_0_12736800_1441595394']['name']); ?>" /></a></li>

        <div class="cont-right">

           <h4><a href="<?php echo $this->_var['goods_0_12736800_1441595394']['url']; ?>"><?php echo htmlspecialchars($this->_var['goods_0_12736800_1441595394']['name']); ?></a></h4>

           <span class="cut cut2">新品推荐</span>

           <span class="price"><?php if ($this->_var['goods_0_12736800_1441595394']['promote_price'] != ""): ?><?php echo $this->_var['goods_0_12736800_1441595394']['promote_price']; ?><?php else: ?><?php echo $this->_var['goods_0_12736800_1441595394']['shop_price']; ?><?php endif; ?><del><?php echo $this->_var['goods_0_12736800_1441595394']['shop_price']; ?></del></span>

           <a class="buy-cart" href="<?php echo $this->_var['goods_0_12736800_1441595394']['url']; ?>"></a>

        </div>

     </div>

     <!--<span class="sum">库存<?php echo $this->_var['goods_0_12736800_1441595394']['goods_number']; ?></span>-->

  </div>
  <?php endif; ?>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

</section>