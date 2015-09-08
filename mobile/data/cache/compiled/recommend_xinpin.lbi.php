<section class="h-recommend">
   <div class="h-recommend-box h-recommend-box2">
   <div class="blank2"></div>
  <ul>
     <?php $_from = $this->_var['new_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['new_goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['new_goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['new_goods']['iteration']++;
?>
     <?php if ($this->_foreach['new_goods']['iteration'] < 5): ?>
     <li class="single_item" id="more_element_1">
          <a href="<?php echo $this->_var['goods']['url']; ?>"><img src="<?php echo $this->_var['goods']['thumb']; ?>" alt="<?php echo htmlspecialchars($this->_var['goods']['name']); ?>" /></a>
          <dl>
            <dt><h4><a href="<?php echo $this->_var['goods']['url']; ?>"><?php echo htmlspecialchars($this->_var['goods']['name']); ?></a></h4></dt>
            <dd>
              <span class="price"><?php if ($this->_var['goods']['promote_price'] != ""): ?><?php echo $this->_var['goods']['promote_price']; ?><?php else: ?><?php echo $this->_var['goods']['shop_price']; ?><?php endif; ?></span>
              <span class="same"><a href="<?php echo $this->_var['goods']['url']; ?>">新品推荐</a></span>
            </dd>
          </dl>
      </li>
      <?php endif; ?>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </ul>
   </div>
</section>