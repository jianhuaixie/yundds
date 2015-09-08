<!-- $Id: brand_list.htm 15898 2009-05-04 07:25:41Z liuhui $ -->

<?php if ($this->_var['full_page']): ?>
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>

<form method="post" action="" name="listForm">

<div class="list-div" id="listDiv">
<?php endif; ?>

  <table cellpadding="3" cellspacing="1">
    <tr>
      <th>橱窗名称</th>
      <th>橱窗类型</th>
      <th>橱窗色调</th>
      <th><?php echo $this->_var['lang']['sort_order']; ?></th>
      <th>显示</th>
      <th><?php echo $this->_var['lang']['handler']; ?></th>
    </tr>
    <?php $_from = $this->_var['win_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'window');if (count($_from)):
    foreach ($_from AS $this->_var['window']):
?>
    <tr>
      <td align="center"><span onclick="javascript:listTable.edit(this, 'edit_win_name', <?php echo $this->_var['window']['id']; ?>)"><?php echo htmlspecialchars($this->_var['window']['win_name']); ?></span>
      </td>
      <td align="center"><?php echo $this->_var['window']['win_type_name']; ?></td>
      <td align="center"><div style="width:50px; height:30px; background-color:<?php echo $this->_var['window']['win_color']; ?>;"></div></td>
      <td align="center"><span onclick="javascript:listTable.edit(this, 'edit_sort_order', <?php echo $this->_var['window']['id']; ?>)"><?php echo $this->_var['window']['win_order']; ?></span></td>
      <td align="center"><img src="images/<?php if ($this->_var['window']['is_show']): ?>yes<?php else: ?>no<?php endif; ?>.gif" onclick="listTable.toggle(this, 'toggle_show', <?php echo $this->_var['window']['id']; ?>)" /></td>
      <td align="center">
        <a href="seller_window.php?act=edit&id=<?php echo $this->_var['window']['id']; ?>" title="<?php echo $this->_var['lang']['edit']; ?>"><?php echo $this->_var['lang']['edit']; ?></a> |
        <?php if ($this->_var['window']['win_type']): ?>
        <a href="seller_window.php?act=add_win_goods&id=<?php echo $this->_var['window']['id']; ?>" title="<?php echo $this->_var['lang']['edit']; ?>">添加商品</a> |
        <?php endif; ?>
        <a href="javascript:;" onclick="listTable.remove(<?php echo $this->_var['window']['id']; ?>, '<?php echo $this->_var['lang']['drop_confirm']; ?>')" ><?php echo $this->_var['lang']['remove']; ?></a> 
      </td>
    </tr>
    <?php endforeach; else: ?>
    <tr><td class="no-records" colspan="10"><?php echo $this->_var['lang']['no_records']; ?></td></tr>
    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>

  </table>

<?php if ($this->_var['full_page']): ?>

</div>
</form>

<script type="text/javascript" language="javascript">
  <!--

  
  onload = function()
  {
      // 开始检查订单
      startCheckOrder();
  }
  
  //-->
</script>
<?php echo $this->fetch('pagefooter.htm'); ?>
<?php endif; ?>