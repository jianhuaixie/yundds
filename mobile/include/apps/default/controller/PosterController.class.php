<?php

/**
 * ECTouch Open Source Project
 * ============================================================================
 * Copyright (c) 2012-2014 http://ectouch.cn All rights reserved.
 * ----------------------------------------------------------------------------
 * 文件名称：PosterControoller.class.php
 * ----------------------------------------------------------------------------
 * 功能描述：海报合成控制器
 * ----------------------------------------------------------------------------
 * Licensed ( http://www.ectouch.cn/docs/license.txt )
 * ----------------------------------------------------------------------------
 */
/* 访问控制 */
defined('IN_ECTOUCH') or die('Deny Access');

class PosterController extends CommonController {
	
	//生成二维码
    public function poster() {
		$user_id = $_GET['user_id'];
		
		$uploadfile	 = './images/poster/'.$user_id."_uploadfile.jpg";			//生成后二维码
		$uploadfile1 = './images/poster/'.$user_id."_uploadfile1.jpg";			//生成的头像
		$blank		 = './images/poster/'.$user_id.'_blank.gif';				//生成后了空白图

		$sql = "select a.qrcode_url, b.headimgurl from ". $this->model->pre."wechat_qrcode a left join " .$this->model->pre. "wechat_user b on a.scene_id = b.ect_uid where b.ect_uid = " .$user_id;
	
		$Poster_list = $this->model->getRow($sql);
		
		$qrcode_url = $Poster_list['qrcode_url']; 		//获取用户二维码
		$headimgur = $Poster_list['headimgurl']; 		//获取用户头像
		
		if(!$qrcode_url){//没有用户二维码
		  
			$qrcode_url = $this -> pic();
			$sql = "select headimgurl from ".$this->model->pre. "wechat_user where ect_uid = " .$user_id;
			$Poster_list = $this->model->getRow($sql);
			$headimgur = $Poster_list['headimgurl']; 		//获取用户头像
		}
		
		$this -> download_remote_file($qrcode_url,$uploadfile);
		$bg_blank  = copy('./images/poster/blank.gif',$blank); 			//获取空白图片

		
		//判断是否有头像
		
		if($headimgur){
			$this -> download_remote_file($Poster_list['headimgurl'],$uploadfile1);

			$sf_por = mysf($uploadfile1,"./",100,100);		//缩放头像
			list($sf_w,$sf_h) = getimagesize($uploadfile1);
		
			if($sf_w>100 || $sf_h >100){					//图片裁剪
				$sf_por = mysf($sf_por,"./",100,100,"2"); 
			}
			imageWaterMark($sf_por,10,$blank);   			//合成头像
			
			imageWaterMark($uploadfile,5,$sf_por);   		//合成二维码
	
		}

		unlink($uploadfile1);
		unlink($blank);
		$this->assign('title', "我的二维码");
		$this -> assign("Poster",$uploadfile);
		$this -> display("user_my_poster.dwt");

	}
	
	
	//生成海报
    public function playbill() {
		$user_id = $_GET['user_id'];
		
		$uploadfile	 = './images/poster/'.$user_id."_uploadfile.jpg";			//获取二维码
		$uploadfile1 = './images/poster/'.$user_id."_uploadfile1.jpg";			//生成的头像
		$Poster		 = './images/poster/'.$user_id.'_Poster.jpg';				//生成后海报
		$blank		 = './images/poster/'.$user_id.'_blank.gif';				//生成后空白图
		
		if(!file_exists($uploadfile)){
			
			//二维码不存在，生成二维码
			$sql = "select a.qrcode_url, b.headimgurl from ". $this->model->pre."wechat_qrcode a left join " .$this->model->pre. "wechat_user b on a.scene_id = b.ect_uid where b.uid = " .$user_id;
			$Poster_list = $this->model->getRow($sql);
			
			$qrcode_url = $Poster_list['qrcode_url']; 		//获取用户二维码
			$headimgur = $Poster_list['headimgurl']; 		//获取用户头像
			
			if(!$qrcode_url){//没有用户二维码

				$qrcode_url = $this -> pic();
				$sql = "select headimgurl from ".$this->model->pre. "wechat_user where ect_uid = " .$user_id;
				$Poster_list = $this->model->getRow($sql);
				$headimgur = $Poster_list['headimgurl']; 		//获取用户头像
			}

			$this -> download_remote_file($qrcode_url,$uploadfile);

			$bg_Poster  = copy('./images/poster/Poster.jpg',$Poster); 		//获取用户海报
			$bg_blank  = copy('./images/poster/blank.gif',$blank); 			//获取空白图片

			
			//判断是否有头像
			
			if($headimgur){
				$this -> download_remote_file($Poster_list['headimgurl'],$uploadfile1);

				$sf_por = mysf($uploadfile1,"./",100,100);		//缩放头像
				list($sf_w,$sf_h) = getimagesize($uploadfile1);
			
				if($sf_w>100 || $sf_h >100){					//图片裁剪
					$sf_por = mysf($sf_por,"./",100,100,"2"); 
				}
				imageWaterMark($sf_por,10,$blank);   			//合成头像
				imageWaterMark($uploadfile,5,$sf_por);   		//合成二维码
		
			}
			
			unlink($uploadfile1);
			unlink($blank);
		}
		
		$Poster		 = './images/poster/'.$user_id.'_Poster.jpg';		//生成后海报
		
		
		$res = $this -> download_remote_file($qrcode_url,$uploadfile);

		$bg_Poster  = copy('./images/poster/Poster.jpg',$Poster); 		//获取用户海报


		
		list($por_width,$por_height) = getimagesize($uploadfile);		//获取头像的宽高
		list($Poster_width,$Poster_height) = getimagesize($Poster);		//获取海报的宽高

		if($por_width>138 || $por_height>138){
			
			$sf_Poster = mysf($uploadfile,"./",138,138); 				//缩放二维码
		}

		imageWaterMark($Poster,10,$sf_Poster,252,770);					//海报合成
		//imageWaterMark($Poster,10,"",184,726,"你个龟儿子");			//海报文字合成
		
		
		
		unlink($uploadfile);
		unlink($uploadfile1);
		unlink($blank);
		$this->assign('title', "我的推广海报");
		$this -> assign("Poster",$uploadfile);
		$this -> display("user_my_poster.dwt");

	}
	
	
	
	
	
	
	//图片下载
	public function download_remote_file($file_url, $save_to){
		$content = file_get_contents($file_url);
		file_put_contents($save_to, $content);
	}
	
	
	public function pic(){

		$data['scene_id']= $scene_id =$_SESSION['user_id'];
		$data['expire_seconds']=0;
		$data['type']= $type =1;
		$data['function']=1;       	
		$data['username']=$_SESSION['user_name'];       	
		$data['status']=1;
		$data['wechat_id']=1;
		$data['endtime']=time(); 

		$token = get_token1();

		$url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$token;
		
		$data2 = '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": '.$scene_id.'}}}';

		$result = http_post1($url,$data2);

		if($result){
			$json = json_decode($result,true);
		}

		$data['ticket']=$json['ticket'];
		$data['url']=$json['url']; 

		$data['qrcode_url']='https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$json['ticket'];

		if($data['ticket']){		 	

			$this->model->table('wechat_qrcode')->data($data)->insert();
		}

		return $data['qrcode_url'];
	}

}
