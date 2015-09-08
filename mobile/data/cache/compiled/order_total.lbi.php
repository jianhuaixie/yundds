<div id="ECS_ORDERTOTAL">
<div class="ect-padding-tb text-right good-getback">
  <?php if ($_SESSION['user_id'] > 0 && ( C ( 'use_integral' ) || C ( 'use_bonus' ) )): ?> 

  <?php if (C ( 'use_integral' )): ?>
  赠送<?php echo $this->_var['points_name']; ?>：<b class="ect-colory"><?php echo $this->_var['total']['will_get_integral']; ?></b><br/>
  <?php endif; ?> 

  <?php if (( 'use_integral' ) && C ( 'use_bonus' )): ?>
  <?php endif; ?> 

  <?php if (C ( 'use_bonus' )): ?>
  赠送优惠券：<b class="ect-colory"><?php echo $this->_var['total']['will_get_bonus']; ?></b>
  <?php endif; ?>

  <?php endif; ?> 


  <?php if ($this->_var['total']['discount'] > 0): ?> 
  <?php endif; ?> 

  <?php if ($this->_var['total']['tax'] > 0): ?> 
  <?php endif; ?> 

  <?php if ($this->_var['total']['shipping_fee'] > 0): ?> 
  <?php endif; ?> 

  <?php if ($this->_var['total']['shipping_insure'] > 0): ?> 
  <?php endif; ?> 

  <?php if ($this->_var['total']['pay_fee'] > 0): ?> 
  <?php endif; ?> 

  <?php if ($this->_var['total']['pack_fee'] > 0): ?> 
  <?php endif; ?> 

  <?php if ($this->_var['total']['card_fee'] > 0): ?> 
  <?php endif; ?> 

  <?php if ($this->_var['total']['surplus'] > 0 || $this->_var['total']['integral'] > 0 || $this->_var['total']['bonus'] > 0): ?> 

  <?php if ($this->_var['total']['surplus'] > 0): ?> 
  <?php endif; ?> 

  <?php if ($this->_var['total']['integral'] > 0): ?> 
  <?php endif; ?> 

  <?php if ($this->_var['total']['bonus'] > 0): ?> 
  <?php endif; ?> 

  <?php endif; ?> 

  <?php if ($this->_var['total']['exchange_integral']): ?>
  <?php endif; ?> 

</div>

<section class="good-button">
 <ul>
  <li class="pay">实付款：<span><?php echo $this->_var['total']['amount_formated']; ?></span></li>
  <li class="submit">
   <input type="submit" name="submit" value="<?php echo $this->_var['lang']['order_submit']; ?>" class="button">
   <input type="hidden" name="step" value="done" />
  </li>
 </ul>
</section>
</div>