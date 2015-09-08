

<a href="<?php echo $this->_var['hot_goods']['url']; ?>"><img src="<?php echo $this->_var['hot_goods']['goods_img']; ?>" alt="<?php echo $this->_var['hot_goods']['name']; ?>"></a>

<dl>

  <dt><h4><a href="<?php echo $this->_var['hot_goods']['url']; ?>"><?php echo $this->_var['hot_goods']['name']; ?></a></h4></dt>

  <dd>

    <span class="price"><?php if ($this->_var['hot_goods']['promote_price']): ?><?php echo $this->_var['hot_goods']['promote_price']; ?><?php else: ?><?php echo $this->_var['hot_goods']['shop_price']; ?><?php endif; ?></span>

    <span class="same"><a href="index.php?m=default&c=category&a=index&id=<?php echo $this->_var['hot_goods']['cat_id']; ?><?php if ($_SESSION['user_id'] > 0): ?>&u=<?php echo $_SESSION['user_id']; ?><?php endif; ?>">看相似</a></span>

  </dd>

</dl>

 