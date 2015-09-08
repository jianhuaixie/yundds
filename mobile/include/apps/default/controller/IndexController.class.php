<?php







/**



 * ECTouch Open Source Project



 * ============================================================================



 * Copyright (c) 2012-2014 http://ectouch.cn All rights reserved.



 * ----------------------------------------------------------------------------



 * 文件名称：IndexController.class.php



 * ----------------------------------------------------------------------------



 * 功能描述：ECTouch首页控制器



 * ----------------------------------------------------------------------------



 * Licensed ( http://www.ectouch.cn/docs/license.txt )



 * ----------------------------------------------------------------------------



 */



/* 访问控制 */



defined('IN_ECTOUCH') or die('Deny Access');







class IndexController extends CommonController {







    /**



     * 首页信息



     */



    public function index() {

    	

    	

   



        // 自定义导航栏



        $navigator = model('Common')->get_navigator();



        $this->assign('navigator', $navigator['middle']);



        $this->assign('best_goods', model('Index')->goods_list('best', C('page_size')));



        $this->assign('new_goods', model('Index')->goods_list('new', C('page_size')));



        $this->assign('hot_goods', model('Index')->goods_list('hot', C('page_size')));



        //首页推荐分类



        $cat_rec = model('Index')->get_recommend_res();



        $this->assign('cat_best', $cat_rec[1]);



        $this->assign('cat_new', $cat_rec[2]);



        $this->assign('cat_hot', $cat_rec[3]);



        // 促销活动



        $this->assign('promotion_info', model('GoodsBase')->get_promotion_info());

		$this->assign('promotion_goods', model('Index')->get_promote_goods());//hzh

		

		//index 1f-4f

		$this->assign('floor_goods_1', model('Index')->get_floor_goods_cat(337));//hzh

		$this->assign('floor_goods_2', model('Index')->get_floor_goods_rand(14));//hzh

		$this->assign('floor_goods_3', model('Index')->get_floor_goods_rand(6));//hzh 

		$this->assign('floor_goods_4', model('Index')->get_floor_goods_rand(3));//hzh
		
		
		//hzh s
		$u_id = $_SESSION['user_id'];
		/*
		$u_info_name = model('Base')->model->table('wechat_user')
            ->field('nickname')
            ->where('ect_uid = ' . $u_id)
            ->find();
		$u_info_img = model('Base')->model->table('wechat_user')
            ->field('headimgurl')
            ->where('ect_uid = ' . $u_id)
            ->find();
		*/
		$u_info_name = $this->model->table('wechat_user')->field('nickname')->where("ect_uid = '$u_id'")->getOne();
		$u_info_img = $this->model->table('wechat_user')->field('headimgurl')->where("ect_uid = '$u_id'")->getOne();
		if(empty($u_info_name) && empty($u_info_img) && is_wechat_browser()){
			$guanzhu = 0;
		}else{
			$guanzhu = 1;
		}
		$p_id = model('Base')->model->table('users')->field('parent_id')->where("user_id = '$u_id'")->getOne();//get parent_id
		$p_nickname = $this->model->table('wechat_user')->field('nickname')->where("ect_uid = '$p_id'")->getOne();
		$p_headimgurl = $this->model->table('wechat_user')->field('headimgurl')->where("ect_uid = '$p_id'")->getOne();

		$this->assign('guanzhu', $guanzhu);//hzh
		$this->assign('p_nickname', $p_nickname);//hzh
		$this->assign('p_headimgurl', $p_headimgurl);//hzh
		//hzh e



        // 团购商品



        $this->assign('group_buy_goods', model('Groupbuy')->group_buy_list(C('page_size'),1,'goods_id','ASC'));



        // 获取分类



        $this->assign('categories', model('CategoryBase')->get_categories_tree());

        

        

        //shanmao.me 新增扫描推荐二维码

        if($_SESSION['user_id'] >0 ){

        	$data['scene_id']= $scene_id =$_SESSION['user_id'];

        	$data['expire_seconds']=0;

        	$data['type']= $type =1;

        	$data['function']=1;       	

        	$data['username']=$_SESSION['user_name'];       	

        	$data['status']=1;

        	$data['wechat_id']=1;

        	$data['endtime']=time(); 

        	

        	$rs = $this->model->table('wechat_qrcode')->where('scene_id = '.$data['scene_id'])->find();

       

            if(!$rs){//没有生成过

             

             $token = get_token1();

        	

        	$url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$token;

        	 

			$data2 = '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": '.$scene_id.'}}}';

			$result = http_post1($url,$data2);

			

			if($result){

				$json = json_decode($result,true);

			}

             

            $data['ticket']=$json['ticket'];

            $data['url']=$json['url'];  //ALTER TABLE  `ydcom_wechat_qrcode` ADD  `url` VARCHAR( 255 ) NOT NULL AFTER  `qrcode_url`

        	$data['qrcode_url']='https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$json['ticket'];

             if( $data['ticket']){		 	

				 $this->model->table('wechat_qrcode')

				->data($data)

				->insert();

             }

              

              $this->assign('ewmtj', $data['qrcode_url']); 

               

            }else{            	

				 $this->assign('ewmtj', $rs['qrcode_url']); 

			}

	

        }

        

        

        

        

        

        

        

        

        



        // 获取品牌



        $this->assign('brand_list', model('Brand')->get_brands($app = 'brand', C('page_size'), 1));



        $this->display('index.dwt');



    }



	    /**



     * 首页信息



     */



    public function weixin() {



        // 自定义导航栏



        $navigator = model('Common')->get_navigator();



        $this->assign('navigator', $navigator['middle']);



        $this->assign('best_goods', model('Index')->goods_list('best', C('page_size')));



        $this->assign('new_goods', model('Index')->goods_list('new', C('page_size')));



        $this->assign('hot_goods', model('Index')->goods_list('hot', C('page_size')));



        //首页推荐分类



        $cat_rec = model('Index')->get_recommend_res();



        $this->assign('cat_best', $cat_rec[1]);



        $this->assign('cat_new', $cat_rec[2]);



        $this->assign('cat_hot', $cat_rec[3]);



        // 促销活动



        $this->assign('promotion_info', model('GoodsBase')->get_promotion_info());

		$this->assign('promotion_goods', model('Index')->get_promote_goods());//hzh

		

		//index 1f-4f

		$this->assign('floor_goods_1', model('Index')->get_floor_goods_cat(337));//hzh

		$this->assign('floor_goods_2', model('Index')->get_floor_goods_rand(5));//hzh

		$this->assign('floor_goods_3', model('Index')->get_floor_goods_rand(6));//hzh 

		$this->assign('floor_goods_4', model('Index')->get_floor_goods_rand(3));//hzh



        // 团购商品



        $this->assign('group_buy_goods', model('Groupbuy')->group_buy_list(C('page_size'),1,'goods_id','ASC'));



        // 获取分类



        $this->assign('categories', model('CategoryBase')->get_categories_tree());

        

       

        





        // 获取品牌



        $this->assign('brand_list', model('Brand')->get_brands($app = 'brand', C('page_size'), 1));



        $this->display('index.dwt');



    }



    /**



     * 跳转页 ADD BY HZH



     */



    public function home() {



        if($_SESSION['user_id'] >0 ){



			header('Location: ./index.php?a=index&u='.$_SESSION['user_id']);



		}else{



			header('Location: ./index.php?a=index&u=0');



		}



    }





    /**



     * ajax获取商品



     */



    public function ajax_goods() {



        if (IS_AJAX) {



            $type = I('get.type');



            $start = $_POST['last'];



            $limit = $_POST['amount'];



            $hot_goods = model('Index')->goods_list($type, $limit, $start);



            $list = array();



            // 热卖商品



            if ($hot_goods) {



                foreach ($hot_goods as $key => $value) {



                    $this->assign('hot_goods', $value);



                    $list [] = array(



                        'single_item' => ECTouch::view()->fetch('library/asynclist_index.lbi')



                    );



                }



            }



            echo json_encode($list);



            exit();



        } else {



            $this->redirect(url('index'));



        }



    }



	

//hzh

  public function login2() {

        $this->assign('title', L('login'));



        $this->assign('back_act', $this->back_act);



        $this->display('user_login2.dwt');



    }
    
    
    //打款测试
    public function dakuanceshi(){
    	echo "开始处理";
    	$lastmonth_final=mktime(23,59,59,date("m"),0,date("Y"));
    	$res=mysql_query("select   log_id,user_id,money,fenxiao_rank  from  ydcom_fenxiao_log  where  confirm_time<=$lastmonth_final  and  confirm_time>0  and  separate_type=1") or die("没进去");
    	//取得所有的日志id
    	//$log_id='';

    	while ($row=mysql_fetch_array($res)){
    		//$log_id.=$log_id ? ",'$row[0]'":"'$row[0]'";
    		$log_id=$row[0];
    		$uid=$row[1];
    		$money=$row[2];
    		$money_get=$money*0.95;
    		$fee=$money-$money_get;
    		$money_rate=0.95;
    		$log_fenxiao_rank=$row[3];
    		//现在的分销等级
    		$res1=mysql_query("select fenxiao_rank from ydcom_users where user_id=$uid");
    		$row1=mysql_fetch_array($res1);
    		$now_fenxiao_rank=$row1[0];
    
    		if ($now_fenxiao_rank>=$log_fenxiao_rank){
    			$log_time=time();
    			//打钱
    			mysql_query("update  ydcom_users   set  user_money=user_money+$money_get  where user_id=$uid ");
    			//打日志
    			mysql_query("insert into  ydcom_account_log(user_id,user_money,change_time,change_desc,change_type) values ( $uid,$money_get,$log_time,'推广收益',2) ");
    			//更新分成日志  分成状态
    			mysql_query("update ydcom_fenxiao_log set separate_type=2,fee=$fee,money_get=$money_get,money_rate=$money_rate,dakuan_time=$log_time  where log_id=$log_id ");
    			
    		}elseif ($now_fenxiao_rank<$log_fenxiao_rank){
    			//打备注降级
    			mysql_query("update ydcom_fenxiao_log set separate_type=5 where log_id=$log_id");
    		}
    		
    	echo "执行一条成功";	  
    	}
    	echo "操作完毕";

    }   
    
    
    
    
    
     //推荐关注奖励奖金
     function atten_test(){
     	$day_mark=date("ymd");
     	//echo $day_mark;//关注手机，关注微信
     	$res=mysql_query("select user_id from ydcom_users where length(mobile_phone)>0  and  (length(wx_nickname)>0 or length(wx_headimgurl)>0) ");
     	while ($row=mysql_fetch_array($res)){
     		$count=0;
     		$p_uid=$row[0];
     		$res1=mysql_query("select user_id from ydcom_users where parent_id=$p_uid and  (length(wx_nickname)>0 or length(wx_headimgurl)>0)  and give_par_mark=0");
            while($row1=mysql_fetch_array($res1)){
            	$uid=$row1[0];
            	mysql_query("update ydcom_users set give_par_mark=$day_mark where user_id=$uid");
            	$count++;
            }
            
            $money=0.2*$count;
            if ($money){ 
            $time=time(); 
            //打钱
            mysql_query("update ydcom_users set user_money=(user_money+$money) where user_id=$p_uid");
            //打钱日志
            mysql_query("insert into ydcom_account_log(user_id,user_money,change_time,change_desc,change_type) values($p_uid,$money,$time,'推荐关注奖励',2)");
            
            //openid
            $res2=mysql_query("select openid from ydcom_wechat_user where ect_uid=$p_uid");
            while($row2=mysql_fetch_array($res2)){
            	$openid=$row2[0];
            }
            $url =  __HOST__ . url('User/my_tuiguang');
            $time=date("Y-m-d H:i:s",time());
            //sendmb_jiesuan($title,$time,$amount,$url,$openid)
            sendmb_jiesuan("推荐关注奖励",$time,$money,$url,$openid); 
            echo "uid:"."$p_uid"."推荐关注收益:"."$money"."</br>";   
     	}
     	}

     }
     
     
     
     //推荐关注奖励奖金
     function atten_test_ninetwo(){

     	mysql_query("update ydcom_users set give_par_mark='150902' where (length(wx_nickname)>0 or length(wx_headimgurl)>0) ");
 
     }
     
     //触发测试
     function trigger_test() {
     	mysql_query("update ydcom_account_log set user_money=999  where log_id=1");
     }
     
     
     
    
     
     
     //信息测试
     function msg_test(){
     	   
     	$order_amount=10;
     	$order_sn=543254235;
     	$openid0="oIS5fwi244oE-iecbfspiQmKAcw0";
     	//sendmb_neworder("544","543","6543", "65","546","56","65","6542","oIS5fwi244oE-iecbfspiQmKAcw0");
     	sendmb_pay_done("",$order_amount."元",$order_sn,'我们会尽快安排为您发货','',$openid0);
     	echo "453";
     }
    
    
    







}



