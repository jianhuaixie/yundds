<?php 

/*连接数据库*/


$DB_Server = "rdsed8t8e7bzxpvu78nx.mysql.rds.aliyuncs.com:3306";
$DB_Username = "yundds"; 
$DB_Password = "9e47deb4b058d4829b214caac3b7f3e5"; 
$DB_DBName = "b628382c97124173dd283bf7b83f1eec";  //目标数据库名


$DB_TBLName = "ydcom_fenxiao_log";  //目标表名



$Connect = @mysql_connect($DB_Server, $DB_Username, $DB_Password) or die("Couldn't connect."); 

mysql_query("set names utf8"); 



$savename = date("YmjHis"); //导出excel文件名

$file_type = "vnd.ms-excel"; 

$file_ending = "xls"; 

header("Content-Type: application/$file_type;charset=utf-8"); 

header("Content-Disposition: attachment; filename=".$savename.".$file_ending"); 

header("Pragma: no-cache"); 



/*写入备注信息*/

//$now_date = date("Y-m-j H:i:s"); 

//$title = "报名表,备份日期:$now_date"; 

//echo iconv("utf-8","gbk",$title)."\n"; 



/*查询数据库*/

$sql = "Select log_id, order_sn, user_id_buyer, user_id, money, money_get, fencheng_time, confirm_time, separate_type, model_type from $DB_TBLName WHERE " . db_create_in($_POST['checkboxes'], 'log_id')." ORDER BY log_id DESC"; 

$ALT_Db = @mysql_select_db($DB_DBName, $Connect) or die("Couldn't select database"); 

$result = @mysql_query($sql,$Connect) or die(mysql_error()); 



//转换编码函数，防止乱码

function codeutf8($str){

	return iconv("utf-8", "gb2312",$str);

}

/*写入表字段名*/

echo codeutf8("ID")."\t";

echo codeutf8("订单号")."\t";

echo codeutf8("买家ID")."\t";

echo codeutf8("受益人ID")."\t";

echo codeutf8("分成资金（未扣手续费）")."\t";

echo codeutf8("分成资金（已扣除5%手续费）")."\t";

echo codeutf8("付款时间")."\t";

echo codeutf8("确认收货时间")."\t";

echo codeutf8("操作状态（1=待处理、2=已分成、3=换货、4=退货、5=等级不符）")."\t";

echo codeutf8("分成模式")."\n";

echo "\n";



/*写入表数据*/

$sep = "\t"; 

while($row = mysql_fetch_row($result)) { 

	$data = ""; 

	for($i=0; $i<mysql_num_fields($result);$i++) { 

		if(!isset($row[$i]))

			$data .= "NULL".$sep; //处理NULL字段

		elseif ($row[$i] != ""){

			$datmp=iconv("utf-8", "gbk", $row[$i]);
			if($i == 1){
				$data .= "'".$datmp.$sep;
			}
			elseif($i == 6){
				$data .= date("Y-m-d H:i:s", $datmp).$sep;
			}
			elseif($i == 7){
				$data .= date("Y-m-d H:i:s", $datmp).$sep;
			}
			else{
				$data .= $datmp.$sep;
			}

		}

	else 

		$data .= "".$sep; //处理空字段

	} 

	echo $data."\n"; 

}

 ?>