<div class="con">

  <header id="header" class="header">

  <div class="user-header">

    <h1 ><?php echo $this->_var['title']; ?></h1>

    <div class="header_l header_return"> <a class="ico_10_3" href="javascript:history.go(-1);"> 返回 </a> </div>


  </div>

</header>

  <div class="line-top"></div>

  <?php if ($this->_var['goods_list']): ?>

  <section class="ect-pro-list flow-pic ect-border-bottom0 car-list-box">

    <ul>

      <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['goods']):
?>

      <li>

        <div class="ect-clear-over"> <a href="<?php echo url('goods/index',array('id'=>$this->_var['goods']['goods_id']));?>"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" title="<?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?>"></a>

          <dl>

            <dt>

              <h4 class="title"><a href="<?php echo url('goods/index',array('id'=>$this->_var['goods']['goods_id']));?>"><?php echo $this->_var['goods']['goods_name']; ?> 

                <?php if ($this->_var['goods']['parent_id'] > 0): ?> 

                <span style="color:#FF0000">（<?php echo $this->_var['lang']['accessories']; ?>）</span> 

                <?php endif; ?> 

                <?php if ($this->_var['goods']['is_gift'] > 0): ?> 

                <span style="color:#FF0000">（<?php echo $this->_var['lang']['largess']; ?>）</span> 

                <?php endif; ?> 

                </a></h4>

            </dt>

            <dd class="ect-color999"> 

              <?php if ($this->_var['show_goods_attribute'] == 1): ?>

              <p class="gd-size"><?php echo nl2br($this->_var['goods']['goods_attr']); ?></p>

              <?php endif; ?>
              <p class="pd-price"><strong class="ect-colory"><?php echo $this->_var['goods']['goods_price']; ?></strong></p>
              

            </dd>

          </dl>

        </div>

        <div class="ect-margin-tb ect-margin-bottom0 ect-clear-over flow-num-del"> 

        <?php if ($this->_var['goods']['goods_id'] > 0 && $this->_var['goods']['is_gift'] == 0 && $this->_var['goods']['parent_id'] == 0): ?>

          <div class="input-group pull-left wrap"> <span class="input-group-addon" onClick="change_goods_number('1',<?php echo $this->_var['goods']['rec_id']; ?>)" >-</span>

            <input type="hidden" id="back_number<?php echo $this->_var['goods']['rec_id']; ?>" value="<?php echo $this->_var['goods']['goods_number']; ?>" />

            <input type="text" class="form-num form-contro"  name="<?php echo $this->_var['goods']['rec_id']; ?>" id="goods_number<?php echo $this->_var['goods']['rec_id']; ?>" autocomplete="off" value="<?php echo $this->_var['goods']['goods_number']; ?>" onFocus="back_goods_number(<?php echo $this->_var['goods']['rec_id']; ?>)"  onblur="change_goods_number('2',<?php echo $this->_var['goods']['rec_id']; ?>)" />

            <span class="input-group-addon" onClick="change_goods_number('3',<?php echo $this->_var['goods']['rec_id']; ?>)">+</span> </div>

         

         <?php else: ?>

          	<input type="text" class="txtnum" readonly value="<?php echo $this->_var['goods']['goods_number']; ?>"/>

          <?php endif; ?> 

           <div class="pull-right flow-del text-center"> <a href="javascript:if (confirm('<?php echo $this->_var['lang']['drop_goods_confirm']; ?>')) location.href='<?php echo url('flow/drop_goods',array('id'=>$this->_var['goods']['rec_id']));?>';"><?php echo $this->_var['lang']['drop']; ?></a> </div>

        </div>

      </li>

      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

    </ul>

    <?php if ($this->_var['favourable_list']): ?>

    <p class="bg-warning text-center ect-padding-tb " onClick="location.href='<?php echo url('flow/label_favourable');?>'"><?php echo $this->_var['lang']['show_favourable']; ?></p>

    <?php endif; ?>

  </section>
  <p class="flow-price ect-padding-lr ect-padding-tb car-list-total"> <?php echo $this->_var['lang']['total']; ?><b id="total_number"><?php echo $this->_var['total']['total_number']; ?></b>件商品，合计&nbsp;：<b class="ect-colory" id="goods_subtotal"><?php echo $this->_var['total']['goods_price']; ?></b> </p>

  <?php if ($this->_var['fittings_list']): ?>

     <div class="two-btn flow-jiesuan ect-padding-tb ect-padding-lr text-center">

   		<a class="btn btn-info" type="button" href="<?php echo url('flow/goods_fittings');?>"><?php echo $this->_var['lang']['goods_fittings']; ?></a>

        <a class="btn btn-info ect-bg-colory" type="button"  href="<?php echo url('flow/checkout');?>"><?php echo $this->_var['lang']['check_out']; ?></a>

	</div>

  <?php else: ?>

  	<div class="flow-jiesuan ect-padding-lr ect-padding-tb">

  	  <a href="<?php echo url('category/top_all');?><?php if ($_SESSION['user_id'] > 0): ?>&u=<?php echo $_SESSION['user_id']; ?><?php endif; ?>" type="button" class="btn btn-info1 ect-btn-info ect-bg">再逛逛</a>
      <a href="<?php echo url('flow/checkout');?>" type="button" class="btn btn-info2 ect-btn-info ect-bg">结算</a>

  </div>

  <?php endif; ?>

  <?php if ($this->_var['linked_goods']): ?>

  <section class="ect-pro-list flow-rel-pro flow-pic car-box-about">

    <h4 class="ect-margin-lr ect-margin-tb"><strong><?php echo $this->_var['lang']['releate_goods']; ?>：</strong></h4>

    <ul>

      <?php $_from = $this->_var['linked_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'releated_goods_data');if (count($_from)):
    foreach ($_from AS $this->_var['releated_goods_data']):
?>

      <li>

        <div class="ect-clear-over"> <a href="<?php echo $this->_var['releated_goods_data']['url']; ?>"><img src="<?php echo $this->_var['releated_goods_data']['goods_thumb']; ?>" alt="<?php echo $this->_var['releated_goods_data']['goods_name']; ?>" /></a>

          <dl>

            <dt>

              <h4 class="title"><a href="<?php echo $this->_var['releated_goods_data']['url']; ?>"><?php echo $this->_var['releated_goods_data']['short_name']; ?></a></h4>

            </dt>

            <dd class="ect-color999">

              <p> 

                <?php if ($this->_var['releated_goods_data']['promote_price'] != 0): ?> 

                <?php echo $this->_var['lang']['promote_price']; ?><strong class="ect-colory"><?php echo $this->_var['releated_goods_data']['formated_promote_price']; ?></strong> 

                <?php else: ?> 

                <?php echo $this->_var['lang']['shop_price']; ?><strong class="ect-colory"><?php echo $this->_var['releated_goods_data']['shop_price']; ?></strong> 

                <?php endif; ?> 

              </p>

            </dd>

          </dl>

        </div>

      </li>

      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

    </ul>

  </section>

  <?php endif; ?> 

  <?php else: ?>

  <div class="flow-no-pro"> <img src="__TPL__/images/gwc.png">

    <p class="text-center"><?php echo $this->_var['lang']['empty_shopping']; ?></p>

    <a type="button" href="<?php echo url('category/top_all');?>" class="btn btn-info ect-btn-info "><?php echo $this->_var['lang']['go_shopping']; ?></a> </div>

  <?php endif; ?> 

</div>

 <div style="height:20px;"></div>
