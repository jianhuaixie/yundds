<div class="con1">
<header id="header" class="header">
  <div class="user-header">
    <h1 ><?php echo $this->_var['title']; ?></h1>
    <div class="header_l header_return"> <a class="ico_10_3" href="javascript:history.go(-1);"> 返回 </a> </div>
    <div class="header_r header_search"> <a class="ico_18_3" href="./<?php if ($_SESSION['user_id'] > 0): ?>?u=<?php echo $_SESSION['user_id']; ?><?php endif; ?>"> 会员中心菜单</a> </div>
  </div>
</header>

 <div class="line-top"></div>

  <section class="flow-order-box">
  <div class="flow-checkout">

    <form action="<?php echo url('flow/done');?>" method="post" name="theForm" id="theForm" onSubmit="return checkOrderForm(this)">
      <script type="text/javascript">
        var flow_no_payment = "<?php echo $this->_var['lang']['flow_no_payment']; ?>";
        var flow_no_shipping = "<?php echo $this->_var['lang']['flow_no_shipping']; ?>";
      </script><a href="<?php echo url('flow/consignee_list');?>">
      <section class="ect-margin-tb ect-padding-lr ect-padding-tb man-detail-wrap">
      <div class="man-detail">
          <label for="addressId<?php echo $this->_var['con_list']['address_id']; ?>">
          <p class="title"><em class="name"></em><?php echo htmlspecialchars($this->_var['consignee']['consignee']); ?> <span><em class="phone"></em><?php echo $this->_var['consignee']['mobile']; ?></span></p>
          <p><em class="address"></em><?php echo $this->_var['consignee']['region']; ?><?php echo $this->_var['consignee']['address']; ?></p>
          <i class="ico"></i>
          </label>
         </div>
        </section>
      </a>
      
   <section class="goods-change">
     <div class="goods-box">
       <a href="<?php echo url('flow/index');?>" class="title">
       <div class="goods-box-left swiper-container swiper-car">
          <div class="pagination-car">
         </div>
          <ul class="swiper-wrapper">
            <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
            <li  class="swiper-slide"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" /></li>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          </ul>
          </div>
          <i class="ico"></i>
          <span class="sp2">共<?php 
$k = array (
  'name' => 'cart_info_number',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?>件</span>
       </a>
     </div>
   </section>

   
   <section class="goods-change goods-send">
     <div class="send">
       <a class="title">
          <span class="sp1">选择物流</span>
          <i class="ico"></i>
          <span class="sp2">默认快递 免邮</span>
       </a>
     </div>
     
     <div class="pay last">
       <a class="title">
          <span class="sp1">支付方式</span>
          <i class="ico"></i>
          <span class="sp2">余额支付</span>
       </a>
     </div>
   </section>
   
   

   <div class="menu-bg5"></div>
   <div class="goods-change good-show-box good-logistics">
      <h4>选择物流</h4>
      
        <?php $_from = $this->_var['shipping_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'shipping');if (count($_from)):
    foreach ($_from AS $this->_var['shipping']):
?>
        <div class="pay-way-select">
          <a class="title">
          <span class="sp1"><?php echo $this->_var['shipping']['shipping_name']; ?><em><?php if ($this->_var['shipping']['shipping_fee'] == 0): ?>免邮<?php else: ?><?php echo $this->_var['shipping']['format_shipping_fee']; ?><?php endif; ?></em></span>
          <dl>
            <input name="shipping" type="radio" id="shipping_<?php echo $this->_var['shipping']['shipping_id']; ?>" value="<?php echo $this->_var['shipping']['shipping_id']; ?>" title="<?php echo $this->_var['shipping']['shipping_name']; ?> <?php if ($this->_var['shipping']['shipping_fee'] == 0): ?>免邮<?php else: ?><?php echo $this->_var['shipping']['format_shipping_fee']; ?><?php endif; ?>" <?php if ($this->_var['order']['shipping_id'] == $this->_var['shipping']['shipping_id'] || $this->_var['shipping']['shipping_id'] == 1): ?>checked="true"<?php endif; ?> supportCod="<?php echo $this->_var['shipping']['support_cod']; ?>" insure="<?php echo $this->_var['shipping']['insure']; ?>" onclick="selectShipping(this)">
            <label for="shipping_<?php echo $this->_var['shipping']['shipping_id']; ?>" class="label"><i></i></label>
           </dl>       
           </a>
        </div>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      
   </div>
   
   
   
   <div class="menu-bg6"></div>
   <div class="goods-change good-show-box good-payway">
      <h4>支付方式</h4>
      
        <?php $_from = $this->_var['payment_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'payment');if (count($_from)):
    foreach ($_from AS $this->_var['payment']):
?>
        <div class="pay-way-select">
          <a class="title">
          <span class="sp1"><?php echo $this->_var['payment']['pay_name']; ?></span>
          <dl>
            <input name="payment" type="radio" id="payment_<?php echo $this->_var['payment']['pay_id']; ?>" value="<?php echo $this->_var['payment']['pay_id']; ?>" title="<?php echo $this->_var['payment']['pay_name']; ?>" <?php if ($this->_var['order']['pay_id'] == $this->_var['payment']['pay_id'] || $this->_var['payment']['pay_id'] == 1): ?>checked<?php endif; ?> isCod="<?php echo $this->_var['payment']['is_cod']; ?>" onclick="selectPayment(this)" <?php if ($this->_var['cod_disabled'] && $this->_var['payment']['is_cod'] == "1"): ?>disabled="true"<?php endif; ?> style="vertical-align:middle">
            <label for="payment_<?php echo $this->_var['payment']['pay_id']; ?>" class="label"><i></i></label> 
           </dl>       
           </a>
        </div>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      
      
      <?php if ($this->_var['allow_use_surplus']): ?>
      <div class="remain-way">
         余额支付：
         <span id="ECS_SURPLUS_NOTICE"></span>
      	 <input name="surplus" type="text" id="ECS_SURPLUS" value="<?php echo empty($this->_var['order']['surplus']) ? '0' : $this->_var['order']['surplus']; ?>" class="remain-pay" onblur="changeSurplus(this.value)" <?php if ($this->_var['disable_surplus']): ?>disabled="disabled"<?php endif; ?> />
         <span>可用余额：<?php echo empty($this->_var['your_surplus']) ? '0' : $this->_var['your_surplus']; ?></span>
      </div>
      <?php endif; ?>
      <p>
         <a class="a1">取消</a>
         <a class="a2">确定</a>
      </p>
      
   </div>
   
   
   
   <?php if ($this->_var['allow_use_integral']): ?>
   <section class="goods-change goods-point">
     <div>
       <a class="title">
          <span class="sp1 emfixed">您有<?php echo empty($this->_var['your_integral']) ? '0' : $this->_var['your_integral']; ?><?php echo $this->_var['points_name']; ?>，可用<?php echo $this->_var['can_use_point']; ?><?php echo $this->_var['points_name']; ?>抵<?php echo $this->_var['your_integral_price']; ?></span>

           <dl>
              <input name="integral" type="checkbox" id="ECS_INTEGRAL" checked value="<?php echo $this->_var['can_use_point']; ?>" style="vertical-align:middle">
              <label for="ECS_INTEGRAL" class="label"><i></i></label>
           </dl>
       </a>
     </div>
   </section>
   <?php endif; ?>
   

   <?php if ($this->_var['allow_use_bonus'] && $this->_var['bonus_list']): ?>
   
   <section class="goods-change goods-coupon">
     <div>
       <a class="title">
          <span class="sp1">有可用优惠券</span>  
          <i class="ico"></i>
          <span class="sp2">不使用优惠券</span>
       </a> 
     </div>
   </section>
   
   
   
   <div class="menu-bg5"></div>
   <div class="goods-change good-show-box good-Coupons-box">
      <h4>选择优惠券</h4>
      
      
      <div class="pay-way-select">
          <a class="title">
          <span class="sp1">不使用优惠券</span>
          <dl>
            <input  type="radio" id="bonus_<?php echo $this->_var['bonus']['bonus_id']; ?>" name="bonus" value="0" title="不使用优惠券" <?php if ($this->_var['order']['bonus_id'] == 0): ?>checked="true"<?php endif; ?> onclick="changeBonus(this)" style="vertical-align:middle">
            <label for="bonus_<?php echo $this->_var['bonus']['bonus_id']; ?>" class="label"><i></i></label>
           </dl>
           </a>
        </div>
        
		<?php $_from = $this->_var['bonus_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'bonus');if (count($_from)):
    foreach ($_from AS $this->_var['bonus']):
?>
        <div class="pay-way-select">
          <a class="title">
          <span class="sp1 emfixed"><?php echo $this->_var['bonus']['type_name']; ?>[<?php echo $this->_var['bonus']['bonus_money_formated']; ?>]</span>
          <dl>
            <input type="radio" name="bonus" id="bonus_<?php echo $this->_var['bonus']['bonus_id']; ?>" value="<?php echo $this->_var['bonus']['bonus_id']; ?>" title="<?php echo $this->_var['bonus']['type_name']; ?>[<?php echo $this->_var['bonus']['bonus_money_formated']; ?>]" <?php if ($this->_var['order']['bonus_id'] == $this->_var['bonus']['bonus_id']): ?>checked="true"<?php endif; ?> onclick="changeBonus(this)" style="vertical-align:middle" />
            <label for="bonus_<?php echo $this->_var['bonus']['bonus_id']; ?>" class="label"><i></i></label>
           </dl>
           </a>
        </div>    
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
      
   </div>
   
   <?php endif; ?>
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   

      <?php if ($this->_var['pack_list'] || $this->_var['card_list']): ?>

      <section class="ect-margin-tb ect-padding-lr checkout-select"> 

        <?php if ($this->_var['pack_list']): ?> 

        <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">

        <p><b><?php echo $this->_var['lang']['goods_package']; ?></b></p>

        <i class="fa fa-angle-down"></i></a>

        <div id="collapseThree" class="panel-collapse collapse in">

          <ul class="ect-radio">

            <li>

              <input  type="radio" id="pack_<?php echo $this->_var['pack']['pack_id']; ?>"  name="pack" value="0" <?php if ($this->_var['order']['pack_id'] == 0): ?>checked="true"<?php endif; ?> onclick="selectPack(this)" >

              <label for="pack_<?php echo $this->_var['pack']['pack_id']; ?>"><?php echo $this->_var['lang']['no_pack']; ?><i></i></label>

            </li>

            <?php $_from = $this->_var['pack_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'pack');if (count($_from)):
    foreach ($_from AS $this->_var['pack']):
?>

            <li>

              <input type="radio" class="radio" name="pack" id="pack_<?php echo $this->_var['pack']['pack_id']; ?>" value="<?php echo $this->_var['pack']['pack_id']; ?>" <?php if ($this->_var['order']['pack_id'] == $this->_var['pack']['pack_id']): ?>checked="true"<?php endif; ?> onclick="selectPack(this)" />

              <label for="pack_<?php echo $this->_var['pack']['pack_id']; ?>"><?php echo $this->_var['pack']['pack_name']; ?>[<?php echo $this->_var['pack']['format_pack_fee']; ?>][<?php echo $this->_var['lang']['free_money']; ?>:<?php echo $this->_var['pack']['format_free_money']; ?>]<i></i></label>

            </li>

            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

          </ul>

        </div>

        <?php endif; ?> 

        <?php if ($this->_var['card_list']): ?> 

        <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">

        <p><b><?php echo $this->_var['lang']['goods_card']; ?></b></p>

        <i class="fa fa-angle-down"></i></a>

        <div id="collapseFour" class="panel-collapse collapse in">

          <ul class="ect-radio">

            <li>

              <input name="card" type="radio"  value="0" <?php if ($this->_var['order']['card_id'] == 0): ?>checked="true"<?php endif; ?> onclick="selectCard(this)" id="card_0" />

              <label for="card_0"><?php echo $this->_var['lang']['no_card']; ?><i></i></label>

            </li>

            <?php $_from = $this->_var['card_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'card');if (count($_from)):
    foreach ($_from AS $this->_var['card']):
?>

            <li>

              <input name="card" type="radio" id="card_<?php echo $this->_var['card']['card_id']; ?>" value="<?php echo $this->_var['card']['card_id']; ?>" <?php if ($this->_var['order']['card_id'] == $this->_var['card']['card_id']): ?>checked="true"<?php endif; ?> onclick="selectCard(this)">

              <label for="card_<?php echo $this->_var['card']['card_id']; ?>"><?php echo $this->_var['card']['card_name']; ?>[<?php echo $this->_var['card']['format_card_fee']; ?>][<?php echo $this->_var['lang']['free_money']; ?>:<?php echo $this->_var['card']['format_free_money']; ?>]<i></i></label>

            </li>

            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

          </ul>

          <input name="" type="text" placeholder="<?php echo $this->_var['lang']['bless_note']; ?>">

        </div>

      </section>

      <?php endif; ?> 

      <?php endif; ?>

      

      <section class="ect-margin-tb ect-padding-lr checkout-select"> 

	  <?php if ($this->_var['allow_use_bonus'] && $this->_var['bonus_list']): ?>

      <?php endif; ?>


        

        <?php if ($this->_var['allow_use_integral']): ?> 

        <?php endif; ?> 

      </section>
      
   <section class="goods-feedback">
     <div>
       <input name="postscript" type="textarea" class="feedback" placeholder="给商家留言">
     </div>
   </section>

  <section class="order-price">
  <?php echo $this->fetch('library/order_total.lbi'); ?>
  <div style="height:3em;></div>
  </section>

    </form>

  </div>
  </section>
</div>
