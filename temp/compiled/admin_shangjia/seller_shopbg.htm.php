<!-- $Id: setting_first.htm 16339 2009-06-24 08:01:25Z liuhui $ -->
<?php echo $this->fetch('seller_pageheader.htm'); ?>
<div class="main-div">
<script src="js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery.bigcolorpicker.js"></script>
<link type="text/css" rel="stylesheet" href="styles/jquery.bigcolorpicker.css">
<form action="seller_shop_bg.php?act=second" name="theForm" method="post" enctype="multipart/form-data" >
  <table cellspacing="1" cellpadding="3" width="100%">
    <tr>
        <td class="micro-label">背景图片: </td>
        <td>
             <input type="file" name="bgimg"/>
             <?php if ($this->_var['shop_bg']['bgimg']): ?>
             <img src="<?php echo $this->_var['shop_bg']['bgimg']; ?>" width="150" /> 
             <?php endif; ?>   
                     
        </td>
    </tr>
    <tr>
      <td class="micro-label" >背景重复:</td>
      <td>
      <select name="bgrepeat">
      <option value="no-repeat" <?php if ($this->_var['shop_bg']['bgrepeat'] == 'no-repeat'): ?>selected<?php endif; ?>>不重复</option>
      <option value="repeat" <?php if ($this->_var['shop_bg']['bgrepeat'] == 'repeat'): ?>selected<?php endif; ?>>平铺</option>
      <option value="repeat-x" <?php if ($this->_var['shop_bg']['bgrepeat'] == 'repeat-x'): ?>selected<?php endif; ?>>左右平铺</option>
      <option value="repeat-y" <?php if ($this->_var['shop_bg']['bgrepeat'] == 'repeat-y'): ?>selected<?php endif; ?>>垂直平铺</option>
      </select>
      </td>
    </tr>
    <tr>
      <td class="micro-label">店铺背景颜色:</td>
      <td>
      <input type="text" name="bgcolor" size="10" value="<?php echo $this->_var['shop_bg']['bgcolor']; ?>" id="bgcolor" /><input type="button" value="选色" id="selectcolor">
      </td>
    </tr>
    <tr>
      <td class="micro-label">店铺背景:</td>
      <td>
      <input type="radio" value="0" name="show_img" <?php if ($this->_var['shop_bg']['show_img'] == 0): ?> checked<?php endif; ?>/>显示颜色<input type="radio" value="1"  name="show_img" <?php if ($this->_var['shop_bg']['show_img']): ?> checked<?php endif; ?>/>显示图片
      </td>
    </tr>
    <tr>
      <td class="micro-label">启用自定义背景:</td>
      <td>
      <input type="radio" value="0" name="is_custom" <?php if ($this->_var['shop_bg']['is_custom'] == 0): ?> checked<?php endif; ?>/>否<input type="radio" value="1"  name="is_custom" <?php if ($this->_var['shop_bg']['is_custom']): ?> checked<?php endif; ?>/>是
      </td>
    </tr>
    <tr>
      <td>
      <input type="hidden" name="data_op" value="<?php echo $this->_var['data_op']; ?>"/>
      </td>
      <td>
        <input type="submit" value="确认背景" class="button" />
      </td>
    </tr>
  </table>
</form>
</div>
<script type="text/javascript">
		$(function(){
			//2、用法
			$("#selectcolor").bigColorpicker("bgcolor");

		});
	</script>
<?php echo $this->fetch('pagefooter.htm'); ?>
