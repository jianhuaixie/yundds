<?php echo $this->fetch('library/page_header.lbi'); ?>

<?php if ($this->_var['step'] == "cart"): ?>

<?php echo $this->fetch('flow_cart.dwt'); ?>

<?php endif; ?>



<?php if ($this->_var['step'] == "label_favourable"): ?>

<?php echo $this->fetch('flow_label_favourable.dwt'); ?>

<?php endif; ?>



<?php if ($this->_var['step'] == "checkout"): ?>

<?php echo $this->fetch('flow_checkout.dwt'); ?>

<?php endif; ?>



<?php if ($this->_var['step'] == "done"): ?>

<?php echo $this->fetch('flow_done.dwt'); ?>

<?php endif; ?>



<?php if ($this->_var['step'] == "consignee"): ?>

<?php echo $this->fetch('flow_consignee.dwt'); ?>

<?php endif; ?> 

<?php echo $this->fetch('library/page_footer2.lbi'); ?> 

<script type="text/javascript" src="__PUBLIC__/js/shopping_flow.js"></script>



<script>

function back_goods_number(id){

 var goods_number = document.getElementById('goods_number'+id).value;

  document.getElementById('back_number'+id).value = goods_number;

}

function change_goods_number(type, id)

{

  var goods_number = document.getElementById('goods_number'+id).value;

  if(type != 2){back_goods_number(id)}

  if(type == 1){goods_number--;}

  if(type == 3){goods_number++;}

  if(goods_number <=0 ){goods_number=1;}

  if(!/^[0-9]*$/.test(goods_number)){goods_number = document.getElementById('back_number'+id).value;}

  document.getElementById('goods_number'+id).value = goods_number;

	$.post('<?php echo url("flow/ajax_update_cart");?>', {

		rec_id : id,goods_number : goods_number

	}, function(data) {

		change_goods_number_response(data,id);

	}, 'json');  

} 

// 处理返回信息并显示

function change_goods_number_response(result,id)

{

	if (result.error == 0){

		var rec_id = result.rec_id;

		$("#goods_number_"+rec_id).val(result.goods_number);

		document.getElementById('total_number').innerHTML = result.total_number;//更新数量

		document.getElementById('goods_subtotal').innerHTML = result.total_desc;//更新小计

		if (document.getElementById('ECS_CARTINFO')){

			//更新购物车数量

			document.getElementById('ECS_CARTINFO').innerHTML = result.cart_info;

		}

	}else if (result.message != ''){

		alert(result.message);

		var goods_number = document.getElementById('back_number'+id).value;

 		document.getElementById('goods_number'+id).value = goods_number;

	}                

}



	/*点击下拉手风琴效果*/

	$('.collapse').collapse()

	$(".checkout-select a").click(function(){

		if(!$(this).hasClass("select")){

			$(this).addClass("select");

		}else{	

			$(this).removeClass("select");

		}

	});

	

</script>



<script type="text/javascript" src="__TPL__/js/idangerous.swiper-1.9.1.min.js"></script>
  <script>
$(function(){
	/* Carousel mode: */
	swiperCar = $('.swiper-car').swiper({
		pagination : '.pagination-car',
		slidesPerSlide : 4
	});
		
})
</script>

<script type="text/javascript">
/*支付方式 start*/
  var a=$('.good-payway .pay-way-select input[name="payment"]:checked ').attr("title");
		  $(".flow-order-box .goods-send div.pay span.sp2").html(a);
	$(".pay-way-select dl").click(function(){
		    var a=$('.pay-way-select input[name="payment"]:checked ').val();
			if(a==1){
				$(".remain-pay").attr("disabled","disabled");
				$(".remain-pay").removeClass("remain-pay2");
				}
		    else{
				$(".remain-pay").removeAttr("disabled");
				$(".remain-pay").addClass("remain-pay2");
				}
           // $(".checkout-select .select-bank").html(a);
			//$(".checkout-select2").slideUp();  
		})
	
	$(".flow-order-box .goods-change div.pay").click(function(){
		  $(".menu-bg6").css("display","block");
		  $(".good-payway").css("display","block");
		})
	$(".flow-order-box .good-payway p a.a1").click(function(){
		 $(".menu-bg6").css("display","none");
		 $(".good-payway").css("display","none");
		})
    $(".flow-order-box .good-payway p a.a2").click(function(){
		  var a=$('.good-payway .pay-way-select input[name="payment"]:checked ').attr("title");
		  $(".flow-order-box .goods-send div.pay span.sp2").html(a);
		  $(".menu-bg6").css("display","none");
		  $(".good-payway").css("display","none");
		})
/*支付方式 end*/

/*选择物流 start*/
$(".flow-order-box .goods-change div.send").click(function(){
		  $(".menu-bg5").css("display","block");
		  $(".good-logistics").css("display","block");
		})

var a=$('.good-logistics .pay-way-select input[name="shipping"]:checked ').attr("title");
		  $(".flow-order-box .goods-send div.send span.sp2").html(a);
		  
$(".flow-order-box .good-logistics  dl").click(function(){
		  var a=$('.good-logistics .pay-way-select input[name="shipping"]:checked ').attr("title");
		  $(".flow-order-box .goods-send div.send span.sp2").html(a);
		  $(".menu-bg5").css("display","none");
		  $(".good-logistics").css("display","none");
		})
/*选择物流 end*/

/*优惠券 start*/
$(".flow-order-box .goods-coupon div").click(function(){
		  $(".menu-bg5").css("display","block");
		  $(".good-Coupons-box").css("display","block");
		})

var a=$('.good-Coupons-box .pay-way-select input[name="bonus"]:checked ').attr("title");
$(".flow-order-box .goods-coupon div a.title span.sp2").html(a);
		  
$(".flow-order-box .good-Coupons-box  dl").click(function(){
		  var a=$('.good-Coupons-box .pay-way-select input[name="bonus"]:checked ').attr("title");
		  $(".flow-order-box .goods-coupon div a.title span.sp2").html(a);
		  $(".menu-bg5").css("display","none");
		  $(".good-Coupons-box").css("display","none");
		})
/*优惠券 end*/

/*积分 start*/
 var value = document.getElementById("ECS_INTEGRAL").value;
 changeIntegral(value);

$(".flow-order-box .goods-point div a.title").click(function(){
      var chk = document.getElementById("ECS_INTEGRAL");
	  var value = document.getElementById("ECS_INTEGRAL").value;
	  if(chk.checked){
      	changeIntegral(value);
     }else{
     	changeIntegral(0);
     }
	 
}) 
/*积分 end*/

$(".menu-bg5").click(function(){
	  $(".menu-bg5").css("display","none");
	  $(".good-logistics").css("display","none");
	  $(".good-Coupons-box").css("display","none");
	})
</script>


</body>

</html>

