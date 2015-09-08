<?php



/**

 * ECTouch Open Source Project

 * ============================================================================

 * Copyright (c) 2012-2014 http://ectouch.cn All rights reserved.

 * ----------------------------------------------------------------------------

 * 文件名称：PaymentModel.class.php

 * ----------------------------------------------------------------------------

 * 功能描述：ECTOUCH 支付模型

 * ----------------------------------------------------------------------------

 * Licensed ( http://www.ectouch.cn/docs/license.txt )

 * ----------------------------------------------------------------------------

 */



/* 访问控制 */

defined('IN_ECTOUCH') or die('Deny Access');



class PaymentModel extends BaseModel {



    /**

     *  取得某支付方式信息

     *  @param  string  $code   支付方式代码

     */

    function get_payment($code) {

        $sql = 'SELECT * FROM ' . $this->pre .

                "touch_payment WHERE pay_code = '$code' AND enabled = '1'";

        $payment = $this->row($sql);



        if ($payment) {

            $config_list = unserialize($payment['pay_config']);



            foreach ($config_list AS $config) {

                $payment[$config['name']] = $config['value'];

            }

        }

        return $payment;

    }



    /**

     *  通过订单sn取得订单ID

     *  @param  string  $order_sn   订单sn

     *  @param  blob    $voucher    是否为会员充值

     */

    function get_order_id_by_sn($order_sn, $voucher = 'false') {

        if ($voucher == 'true') {

            if (is_numeric($order_sn)) {

                $sql = "SELECT log_id FROM " . $this->pre . "pay_log WHERE order_id=" . $order_sn . ' AND order_type=1';

                $res = $this->row($sql);

                return $res['log_id'];

            } else {

                return "";

            }

        } else {

            if (is_numeric($order_sn)) {

                $sql = 'SELECT order_id FROM ' . $this->pre . "order_info WHERE order_sn = '$order_sn'";

                $res = $this->row($sql);

                $order_id = $res['order_id'];

            }

            if (!empty($order_id)) {

                $sql = "SELECT log_id FROM " . $this->pre . "pay_log WHERE order_id='" . $order_id . "'";

                $res = $this->row($sql);

                return $res['log_id'];

            } else {

                return "";

            }

        }

    }



    /**

     *  通过订单ID取得订单商品名称

     *  @param  string  $order_id   订单ID

     */

    function get_goods_name_by_id($order_id) {

        $sql = 'SELECT goods_name FROM ' . $this->pre . "order_goods WHERE order_id = '$order_id'";

        $res = $this->query($sql);

        if ($res !== false) {

            foreach ($res as $key => $value) {

                $goods_name[] = $value['goods_name'];

            }

        }

        return implode(',', $goods_name);

    }



    /**

     * 检查支付的金额是否与订单相符

     *

     * @access  public

     * @param   string   $log_id      支付编号

     * @param   float    $money       支付接口返回的金额

     * @return  true

     */

    function check_money($log_id, $money) {

        if (is_numeric($log_id)) {

            $sql = 'SELECT order_amount FROM ' . $this->pre .

                    "pay_log WHERE log_id = '$log_id'";

            $res = $this->row($sql);

            $amount = $res['order_amount'];

        } else {

            return false;

        }

        if ($money == $amount) {

            return true;

        } else {

            return false;

        }

    }



    /**

     * 修改订单的支付状态

     *

     * @access  public

     * @param   string  $log_id     支付编号

     * @param   integer $pay_status 状态

     * @param   string  $note       备注

     * @return  void

     */

    function order_paid($log_id, $pay_status = PS_PAYED, $note = '') {

        /* 取得支付编号 */

        $log_id = intval($log_id);

        if ($log_id > 0) {

            /* 取得要修改的支付记录信息 */

            $sql = "SELECT * FROM " . $this->pre .

                    "pay_log WHERE log_id = '$log_id'";

            $pay_log = $this->row($sql);

            if ($pay_log && $pay_log['is_paid'] == 0) {

                /* 修改此次支付操作的状态为已付款 */

                $sql = 'UPDATE ' . $this->pre .

                        "pay_log SET is_paid = '1' WHERE log_id = '$log_id'";

                $this->query($sql);



                /* 根据记录类型做相应处理 */

                if ($pay_log['order_type'] == PAY_ORDER) {

                    /* 取得订单信息 */

                    $sql = 'SELECT order_id, user_id, order_sn, consignee, address, mobile, shipping_id, extension_code, extension_id, goods_amount ' .

                            'FROM ' . $this->pre .

                            "order_info WHERE order_id = '$pay_log[order_id]'";

                    $order = $this->row($sql);

                    $order_id = $order['order_id'];

                    $order_sn = $order['order_sn'];



                    /* 修改订单状态为已付款 */

                    $sql = 'UPDATE ' . $this->pre .

                            "order_info SET order_status = '" . OS_CONFIRMED . "', " .

                            " confirm_time = '" . gmtime() . "', " .

                            " pay_status = '$pay_status', " .

                            " pay_time = '" . gmtime() . "', " .

                            " money_paid = order_amount," .

                            " order_amount = 0 " .

                            "WHERE order_id = '$order_id'";

                    $this->query($sql);



                    /* 记录订单操作记录 */

                    model('OrderBase')->order_action($order_sn, OS_CONFIRMED, SS_UNSHIPPED, $pay_status, $note, L('buyer'));

						//微信通知 by shanmao.me
					 $order_url = __HOST__ . url('user/order_detail', array(

                            'order_id' => $order_id

                        ));
                       $openid = model('Base')->model->table('wechat_user')->field('openid')->where('ect_uid = "'.$order['user_id'].'"')->getOne(); 
                       	
					// send_tx_msg("订单支付提醒","您的订单：".$order_sn."已经支付成功，我们会尽快安排发货！",$order_url,$openid);
						//微信通知 by shanmao.me
						
					 
					 

					 //修改，触发给分销人发送信息
					 //修改，触发给分销人发送信息
					 //修改，触发给分销人发送信息
					 //修改，触发给分销人发送信息
					 
					 require_once 'Helper_virtual.php';
					 $sqlhelper=new Helper_virtual();
					 $order_id=$order_id;
					 //$getorder_sn=$order ['order_sn'];
					 // $order_id=$sqlhelper->execute_dql1("select order_id from ydcom_order_info where order_sn=$getorder_sn");
					 
					 
			 //修改，触发给分销人发送信息
             //修改，触发给分销人发送信息
             //修改，触发给分销人发送信息
             //修改，触发给分销人发送信息
             
             // $getorder_sn=$order ['order_sn'];
             // $order_id=$order ['order_id'] ;
             //$sqlhelper->execute_dql1("select order_id from ydcom_order_info where order_sn=$getorder_sn");
             //加入等级积分，计算等级，跟新等级
            // sendmb_user($title,$desc,$uname,$url,$openid=null);
              
            // $sqlhelper->updateuser_fenxiaorankand_rank_points($order_id);
             //分成，打印日志
             //分成，打印日志
             //根据订单Id求买家id
             $user_id=$sqlhelper->execute_dql1("select user_id from ydcom_order_info where order_id=$order_id");
             $user_id_buyer=$user_id;
             
             $rank_buyer_old=$sqlhelper->execute_dql1("select fenxiao_rank from ydcom_users where user_id=$user_id_buyer");
             $sqlhelper->updateuser_fenxiaorankand_rank_points($order_id);
             //升级通知
             $rank_buyer_now=$sqlhelper->execute_dql1("select fenxiao_rank from ydcom_users where user_id=$user_id_buyer");   
             if ($rank_buyer_now>$rank_buyer_old){
             	$uname_buyer=$sqlhelper->getuser_name($user_id_buyer);
             	$url_buyer =  __HOST__ . url('User/my_tuiguang');
              	$openid_buyer=$sqlhelper->execute_dql1("select openid from ydcom_wechat_user where ect_uid=$user_id_buyer");
              	$user_rank_buyer_name=$sqlhelper->execute_dql1("select rank_name from ydcom_user_yongjin where fenxiao_rank=$rank_buyer_now");
             	//$user_rank_buyer_name=$sqlhelper->getuser_rank_name($user_id_buyer);
              	//sendmb_user('升级通知','恭喜您升级为'.$user_rank_buyer_name,$uname_buyer,$url_buyer,$openid_buyer);
              	$rank_buyer_old_name=$sqlhelper->execute_dql1("select rank_name from ydcom_user_yongjin where fenxiao_rank=$rank_buyer_old");
              	sendmb_level_change("恭喜您推广等级提升",$rank_buyer_old_name,$user_rank_buyer_name,$uname_buyer,$url_buyer,$openid_buyer);
             }
             //订单金额
             $order_amount=$sqlhelper->execute_dql1("select goods_amount from ydcom_order_info where order_id=$order_id");
             
             //$user_name=$sqlhelper->execute_dql1("select user_name from ydcom_users where user_id=$user_id");
             //第1步查询出该笔订单的能产生的佣金
             $fencheng1=0;
             $fencheng2=0;
             //根据order_id查表ydcom_order_goods中的goods_id
             $res0=$sqlhelper->execute_dql("select goods_id,goods_price,goods_number from ydcom_order_goods where order_id=$order_id ");
             while($row0=mysql_fetch_array($res0)){
             	$goods_id=$row0[0];
             	$goods_price=$row0[1]*$row0[2];
             	//根据goods_id查ydcom_goods中的fengcheng1,和fengcheng2;
             	$res02=$sqlhelper->execute_dql("select fencheng1,fencheng2,goods_name from ydcom_goods where goods_id=$goods_id ");
             	while($row02=mysql_fetch_array($res02)){
             		$fencheng1+=$row02[0]*$goods_price;
             		$fencheng2+=$row02[1]*$goods_price;
             		
                	//通知
             		$goods_name=$row02[2];
             		$url =  __HOST__ . url('user/order_detail', array('order_id' => $order ['order_id']));
					$newurl = str_replace('notify_wap_wxpay', 'mobile/index', $url);
             		$openid0=$sqlhelper->execute_dql1("select openid from ydcom_wechat_user where ect_uid=$user_id_buyer");
             		sendmb_pay_done("",$order_amount."元",$order_sn,"我们会尽快安排为您发货。",$newurl,$openid0);
             		
             		
             	}
             }
             
             
             //模式一分成
             $i=0;
             $b1=$sqlhelper->execute_dql1("select parent_id from ydcom_users where user_id=$user_id");
             //b1就是上家id
             for(;$b1>0;){
             	$i++;
             	$c1=$sqlhelper->execute_dql1("select rank_points from ydcom_users where user_id=$b1");
             	//c1为等级积分
             	$d1=$sqlhelper->execute_dql1("select cengshu from ydcom_user_yongjin where $c1>=min_points and $c1<=max_points");
             	//d1为层数
             	if ($d1==-1){
             		//如果层数为-1，那么可享受模式一的最高层数，最高层数赋给d1
             		$d1=$sqlhelper->execute_dql1("select max(cengshu)  from ydcom_user_yongjin where cengshu");
             	}
             	if ($d1>=$i){
             		$res6=$sqlhelper->execute_dql1("select discount  from ydcom_user_ceng where cengshu=$i");
             		//e1佣金比
             		$e1=$res6/100;
             		//f1为模式1佣金
             		$f1=$fencheng1*$e1;
             		$user_name1=$sqlhelper->getuser_name($b1);
             		
             		//$fenxiao_rank1=$sqlhelper->getuser_fenxiaorank_true($b1);	
             		$fenxiao_rank1=$sqlhelper->getuser_rank_simple($b1);
             		$fencheng_time=time();
             		$order_amount=$sqlhelper->execute_dql1("select goods_amount from ydcom_order_info where order_id=$order_id");
             		//写日志
             		//$order_sn
             		//mysql_query("insert into ydcom_fenxiao_log(order_id,user_id,user_name,fenxiao_rank,order_sn,money,time,separate_type) values($order_id,$b1,'$user_name1',$fenxiao_rank1,$order_sn,$f1,,) ")or die("失败");
             		//mysql_query("insert into ydcom_aa(uid,aid) values(1,1)");
             		mysql_query("insert into ydcom_fenxiao_log(order_id,user_id,user_id_buyer,user_name,fenxiao_rank,order_sn,money,fencheng_time,order_amount,model_type) values($order_id,$b1,$user_id_buyer,'$user_name1',$fenxiao_rank1,$order_sn,$f1,$fencheng_time,$order_amount,1) ") or die("失败");
             		
             		$f1=number_format($f1,2);
             		$openid1=$sqlhelper->execute_dql1("select openid from ydcom_wechat_user where ect_uid=$b1");	
             		$url =  __HOST__ . url('User/tuiguang_order');
					$newurl = str_replace('notify_wap_wxpay', 'mobile/index', $url);
             		//sendmb_order("推广通知","恭喜您获得一笔新的推广收益".$f1."元",$order_sn,$url,$openid);
             		sendmb_commission("您获得了一笔新的推广收益",$f1."元","订单编号：".$order_sn,$newurl,$openid1);
             		//$sqlhelper->execute_dql("insert into ydcom_account_log(user_id,user_money,frozen_money,rank_points,pay_points,change_time,change_desc,change_type) values($b1,$f1,0,0,0,$time,'分佣金',2)");
             		//f1为上家的佣金
             		//$time=date("Y-m-d H:i:s",time());
             		//查上家的微信id
             		//$openid=$sqlhelper->execute_dql1("select openid from ydcom_wechat_user where ect_uid=$b1");
             		//send_tx_msg('推广通知',$time.$user_name.'预计将给你带来'.$f1.'元推广金'."订单编号：".$getorder_sn,'http://www.yundds.com/mobile',$openid);
             	}
             	//查询模式一最高享受的层数
             	$highlayer=$sqlhelper->getmodel1_highlayer();
             	if ($highlayer<$i){
             		break;
             	}
             	$b1=$sqlhelper->execute_dql1("select parent_id from ydcom_users where user_id=$b1");
             	//b1为上家
             }
             
             
             //模式二分成
             $b2=$sqlhelper->execute_dql1("select parent_id from ydcom_users where user_id=$user_id");
             //b2就是上家id
             //$a2为买家id
             $a2=$user_id;
             
             $mbb_z=2;
             for(;$b2>0;){
             	//$d1=$sqlhelper->getuser_rank_simple($a2);
             	$d2=$sqlhelper->getuser_rank_simple($b2)  ;
             	//a2为当前，b2为上家，d1为当前分销等级，d2为上家等级
             	//$gomodel2_minrank=$sqlhelper->gomodel2();
             	if ($d2>$mbb_z){	
             		//$up_commission为上家分销等级佣金比
             		$res11=$sqlhelper->execute_dql1("select discount from ydcom_user_yongjin where fenxiao_rank=$d2");
             		$up_commission=$res11/100;
             		//当前用户模式二分销等级佣金比
             		$res112=$sqlhelper->execute_dql1("select discount from ydcom_user_yongjin where fenxiao_rank=$mbb_z");
             		$present_commission=$res112/100;
             		//canget_commission可获得的比例
             		$canget_commission=$up_commission-$present_commission;
             		//f2分销2的最终佣金
             		$f2=$fencheng2*$canget_commission;
             		
             		$user_name2=$sqlhelper->getuser_name($b2);
             		$fencheng_time=time();
             		$fenxiao_rank2=$d2;
             		//写日志
             		//mysql_query("insert into ydcom_fenxiao_log(order_id,user_id,user_name,fenxiao_rank,order_sn,money) values($order_id,$b2,$user_name2,$fenxiao_rank2,$order_sn,$f2) ");
             		mysql_query("insert into ydcom_fenxiao_log(order_id,user_id,user_id_buyer,user_name,fenxiao_rank,order_sn,money,fencheng_time,order_amount,model_type) values($order_id,$b2,$user_id_buyer,'$user_name2',$fenxiao_rank2,$order_sn,$f2,$fencheng_time,$order_amount,2) ") or die("失败");         		
             		
             		$openid2=$sqlhelper->execute_dql1("select openid from ydcom_wechat_user where ect_uid=$b2");
             		$url =  __HOST__ . url('User/tuiguang_order');
             		$f2=number_format($f2,2);
             		//sendmb_order("推广通知","恭喜您获得一笔新的渠道收益".$f2."元",$order_sn,$url,$openid);
             		sendmb_commission("您获得了一笔新的渠道收益",$f2."元","订单编号：".$order_sn,$url,$openid2);
	
             		//查上家的微信id
             		//$openid=$sqlhelper->execute_dql1("select openid from ydcom_wechat_user where ect_uid=$b2");	
             	    //send_tx_msg('推广通知','您的粉丝'.$user_name.'预计将给你带来'.$f2.'元推广金','',$openid);
             	    $mbb_z=$d2;
             	    if ($mbb_z==6){
             	    	break;
             	    }
             		
             	}
             	$a2=$b2;
             	//b2就是上家id
             	$b2=$sqlhelper->execute_dql1("select parent_id from ydcom_users where user_id=$a2");
             }
             
             // $sqlhelper->close_connect();
					 
					 
					 
					 
					 
					 
					 
					 
					 
					 
					 
					 
					 
					 
					 
					 
					 
					 
					 


                    /* 如果需要，发短信 */

                    if (C('sms_order_payed') == '1' && C('sms_shop_mobile') != '') {

                        $sms = new EcsSms();

                        $sms->send(C('sms_shop_mobile'), sprintf(L('order_payed_sms'), $order_sn, $order['consignee'], $order['mobile']), '', 13, 1);

                    }



                    /* 对虚拟商品的支持 */

                    $virtual_goods = model('OrderBase')->get_virtual_goods($order_id);

                    if (!empty($virtual_goods)) {

                        $msg = '';

                        if (!model('OrderBase')->virtual_goods_ship($virtual_goods, $msg, $order_sn, true)) {

                            $pay_success = L('pay_success') . '<div style="color:red;">' . $msg . '</div>' . L('virtual_goods_ship_fail');

                            L('pay_success', $pay_success);

                        }



                        /* 如果订单没有配送方式，自动完成发货操作 */

                        if ($order['shipping_id'] == -1) {

                            /* 将订单标识为已发货状态，并记录发货记录 */

                            $sql = 'UPDATE ' . $this->pre .

                                    "order_info SET shipping_status = '" . SS_SHIPPED . "', shipping_time = '" . gmtime() . "'" .

                                    " WHERE order_id = '$order_id'";

                            $this->query($sql);



                            /* 记录订单操作记录 */

                            model('OrderBase')->order_action($order_sn, OS_CONFIRMED, SS_SHIPPED, $pay_status, $note, L('buyer'));

                            $integral = model('Order')->integral_to_give($order);

                            model('ClipsBase')->log_account_change($order['user_id'], 0, 0, intval($integral['rank_points']), intval($integral['custom_points']), sprintf(L('order_gift_integral'), $order['order_sn']));

                        }

                    }

                } elseif ($pay_log['order_type'] == PAY_SURPLUS) {

                    $sql = 'SELECT `id` FROM ' . $this->pre . "user_account WHERE `id` = '$pay_log[order_id]' AND `is_paid` = 1  LIMIT 1";

                    $res = $this->row($sql);

                    $res_id = $res['id'];

                    if (empty($res_id)) {

                        /* 更新会员预付款的到款状态 */

                        $sql = 'UPDATE ' . $this->pre .

                                "user_account SET paid_time = '" . gmtime() . "', is_paid = 1" .

                                " WHERE id = '$pay_log[order_id]' LIMIT 1";

                        $this->query($sql);



                        /* 取得添加预付款的用户以及金额 */

                        $sql = "SELECT user_id, amount FROM " . $this->pre .

                                "user_account WHERE id = '$pay_log[order_id]'";

                        $arr = $this->row($sql);



                        /* 修改会员帐户金额 */

                        $_LANG = array();

                        include_once(ROOT_PATH . 'languages/' . C('lang') . '/user.php');

                        model('ClipsBase')->log_account_change($arr['user_id'], $arr['amount'], 0, 0, 0, $_LANG['surplus_type_0'], ACT_SAVING);

                    }

                }

            } else {

                /* 取得已发货的虚拟商品信息 */

                $post_virtual_goods = model('OrderBase')->get_virtual_goods($pay_log['order_id'], true);



                /* 有已发货的虚拟商品 */

                if (!empty($post_virtual_goods)) {

                    $msg = '';

                    /* 检查两次刷新时间有无超过12小时 */

                    $sql = 'SELECT pay_time, order_sn FROM ' . $this->pre . "order_info WHERE order_id = '$pay_log[order_id]'";

                    $row = $this->row($sql);

                    $intval_time = gmtime() - $row['pay_time'];

                    if ($intval_time >= 0 && $intval_time < 3600 * 12) {

                        $virtual_card = array();

                        foreach ($post_virtual_goods as $code => $goods_list) {

                            /* 只处理虚拟卡 */

                            if ($code == 'virtual_card') {

                                foreach ($goods_list as $goods) {

                                    if ($info = model('OrderBase')->virtual_card_result($row['order_sn'], $goods)) {

                                        $virtual_card[] = array('goods_id' => $goods['goods_id'], 'goods_name' => $goods['goods_name'], 'info' => $info);

                                    }

                                }



                                ECTouch::view()->assign('virtual_card', $virtual_card);

                            }

                        }

                    } else {

                        $msg = '<div>' . L('please_view_order_detail') . '</div>';

                    }

                    $pay_success = L('pay_success') . $msg;

                    L('pay_success', $pay_success);

                }



                /* 取得未发货虚拟商品 */

                $virtual_goods = model('OrderBase')->get_virtual_goods($pay_log['order_id'], false);

                if (!empty($virtual_goods)) {

                    $pay_success = L('pay_success') . '<br />' . L('virtual_goods_ship_fail');

                    L('pay_success', $pay_success);

                }

            }

        }

    }



}

