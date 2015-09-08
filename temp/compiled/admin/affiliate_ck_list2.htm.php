<!-- <?php if ($this->_var['full_page']): ?> -->
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>
<div class="form-div">
<?php if ($_GET['auid']): ?>
<?php echo $this->_var['lang']['show_affiliate_orders']; ?>
<?php else: ?>
<form action="affiliate_ck2.php?act=list">
<?php echo $this->_var['lang']['sch_stats']['info']; ?>
  <a href="affiliate_ck2.php?act=list"><?php echo $this->_var['lang']['sch_stats']['all']; ?></a>
  <a href="affiliate_ck2.php?act=list&status=1">待处理</a>
  <a href="affiliate_ck2.php?act=list&status=2">已分成</a>
  <a href="affiliate_ck2.php?act=list&status=3">换货</a>
  <a href="affiliate_ck2.php?act=list&status=4">退货</a>
  <a href="affiliate_ck2.php?act=list&status=5">等级不符</a>
<?php echo $this->_var['lang']['sch_order']; ?>
<input type="hidden" name="act" value="list" />
<input name="order_sn" type="text" id="order_sn" size="15">
<!--<select name="separate_type">
    <option value="0">操作状态</option>
    <option value="1">待处理</option>
    <option value="2">已分成</option>
    <option value="3">换货</option>
    <option value="4">退货</option>
    <option value="5">等级不符</option>
</select>-->
<input type="submit" value="<?php echo $this->_var['lang']['button_search']; ?>" class="button" />
</form>
<?php endif; ?>
</div>
<form method="POST" action="affiliate_ck2.php?act=batch_export" name="listForm"  onsubmit="return confirm_bath()">
<div class="list-div" id="listDiv">
<!-- <?php endif; ?> -->
<table cellspacing='1' cellpadding='3'>
<tr>
  <th><input onclick='listTable.selectAll(this, "checkboxes")' type="checkbox" /><a href="javascript:listTable.sort('log_id', 'DESC'); ">ID</a><?php echo $this->_var['sort_log_id']; ?></th>
  <th width="15%">订单号</th>
  <th width="10%">买家ID</th>
  <th width="10%">收益人ID</th>
  <th width="5%">分成资金（未扣手续费）</th>
  <th width="15%">分成资金（<font style="color:#F00;">已扣除5%手续费</font>）</th>
  <th width="15%">付款时间</th>
  <th width="15%">确认收货时间</th>
  <th width="8%">操作状态</th>
  <th width="7%">分成模式</th>
</tr>
<!-- <?php $_from = $this->_var['logdb']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'val');if (count($_from)):
    foreach ($_from AS $this->_var['val']):
?> -->
<tr>
  <td valign="top" nowrap="nowrap"><input type="checkbox" name="checkboxes[]" value="<?php echo $this->_var['val']['log_id']; ?>" /><?php echo $this->_var['val']['log_id']; ?></td>
  <td align="center"><a href="order.php?act=info&order_id=<?php echo $this->_var['val']['order_id']; ?>"><?php echo $this->_var['val']['order_sn']; ?></a></td>
  <td align="center"><?php echo $this->_var['val']['user_id_buyer']; ?></td>
  <td align="center"><?php echo $this->_var['val']['user_id']; ?></td>
  <td align="center" ><?php echo $this->_var['val']['money']; ?></td>
  <td align="center" ><?php echo $this->_var['val']['money_get']; ?></td>
  <td align="center"><?php echo $this->_var['val']['fukuan_time']; ?></td>
  <td align="center"><?php echo $this->_var['val']['confirm_time']; ?></td>
  <td align="center"><?php if ($this->_var['val']['separate_type'] == 1): ?>待处理<?php elseif ($this->_var['val']['separate_type'] == 2): ?>已分成<?php elseif ($this->_var['val']['separate_type'] == 3): ?>换货<?php elseif ($this->_var['val']['separate_type'] == 4): ?>退货<?php elseif ($this->_var['val']['separate_type'] == 5): ?>等级不符<?php endif; ?></td>
  <td align="center"><?php echo $this->_var['val']['model_type']; ?></td>
</tr>
    <!-- <?php endforeach; else: ?> -->
    <tr><td class="no-records" colspan="10"><?php echo $this->_var['lang']['no_records']; ?></td></tr>
<!-- <?php endif; unset($_from); ?><?php $this->pop_vars();; ?> -->
</table>
  
<table id="page-table" cellspacing="0">
<tr>
  <td><div>
      <select name="sel_action">
	    <option value=""><?php echo $this->_var['lang']['select_please']; ?></option>
        <option value="export">导出到EXCEL</option>
      </select>
      <input type="hidden" name="act" value="batch" />
      <input type="submit" name="export" id="btnSubmit" value="<?php echo $this->_var['lang']['button_submit']; ?>" class="button" disabled="true" /></div></td>
  <td align="right" nowrap="true">
  <?php echo $this->fetch('page.htm'); ?>
  </td>
</tr>
</table>
<!-- <?php if ($this->_var['full_page']): ?> -->
</div>
</form>
<script type="Text/Javascript" language="JavaScript">
listTable.recordCount = <?php echo $this->_var['record_count']; ?>;
listTable.pageCount = <?php echo $this->_var['page_count']; ?>;

<?php $_from = $this->_var['filter']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
listTable.filter.<?php echo $this->_var['key']; ?> = '<?php echo $this->_var['item']; ?>';
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

<!--  -->
onload = function()
{
  // 开始检查订单
  startCheckOrder();
}
<!--  -->
</script>
<?php echo $this->fetch('pagefooter.htm'); ?>
<!-- <?php endif; ?> -->