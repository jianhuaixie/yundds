<?php
$getcom = trim($_GET["com"]);
$getNu = trim($_GET["nu"]);

//echo $typeCom.'<br/>' ;
//echo $getNu ;
include_once("kuaidi100_config.php");



	//$url = 'http://www.kuaidi100.com/applyurl?key='.$kuaidi100key.'&com='.$postcom.'&nu='.$getNu;
	
	$url ="http://m.kuaidi100.com/query?type=".$postcom."&id=1&postid=".$getNu;
	//请勿删除变量$powered 的信息，否者本站将不再为你提供快递接口服务。
	$powered = '查询服务由：<a href="http://www.kuaidi100.com" target="_blank" style="color:blue">快递100</a> 网站提供';
	

	//优先使用curl模式发送数据
	if (function_exists('curl_init') == 1){
	  $curl = curl_init();
	  curl_setopt ($curl, CURLOPT_URL, $url);
	  curl_setopt ($curl, CURLOPT_HEADER,0);
	  curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
	  curl_setopt ($curl, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
	  curl_setopt ($curl, CURLOPT_TIMEOUT,5);
	  $get_content = curl_exec($curl);
	  curl_close ($curl);
	}else{
	  include("snoopy.php");
	  $snoopy = new snoopy();
	  $snoopy->fetch($url);
	  $get_content = $snoopy->results;
	}
	$str = "";
	$shipping = json_decode($get_content,ture);

		if($shipping['message'] == 'ok'){
			$shipping = $shipping["data"];
			foreach($shipping as $val){;
				$str .="<li style='list-style-type:none'><i class='fa fa-check-circle ect-color'></i><p>".$val['time'] ."&nbsp;:&nbsp;".$val['context']."</p></li>";
			}
			
		}else{
			$str ="<li><i class='fa fa-check-circle ect-color'style='list-style-type:none'></i><p>查询失败</p></li>";
		}
	echo $str;

   // echo '<iframe src="'.$get_content.'" width="534" height="340" frameborder="no" border="0" marginwidth="0" marginheight="0" scrolling="no" allowtransparency="yes"><br/>' . $powered;


?>
