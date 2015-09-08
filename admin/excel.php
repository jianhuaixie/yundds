<?php 

/*连接数据库*/

$DB_Server = "localhost:3306";

$DB_Username = "K73fB4417cB394e4"; 

$DB_Password = "abc123"; 

$DB_DBName = "abc123";  //目标数据库名

$DB_TBLName = "ydcom_user_account";  //目标表名



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

$sql = "Select '', id, payee, bank_name, bank_account, abs(amount), 0 from $DB_TBLName WHERE " . db_create_in($_POST['checkboxes'], 'id')." ORDER BY id DESC"; 

$ALT_Db = @mysql_select_db($DB_DBName, $Connect) or die("Couldn't select database"); 

$result = @mysql_query($sql,$Connect) or die(mysql_error()); 



//转换编码函数，防止乱码

function codeutf8($str){

	return iconv("utf-8", "gb2312",$str);

}

/*写入表字段名*/

echo codeutf8("序号")."\t";

echo codeutf8("ID")."\t";

echo codeutf8("收款人姓名")."\t";

echo codeutf8("银行名称")."\t";

echo codeutf8("银行卡号")."\t";

echo codeutf8("付款金额")."\t";

echo codeutf8("0(第二天到账)/1(2小时到账)")."\t";

echo codeutf8("备注")."\n";

echo "\n";



/*写入表数据*/

$sep = "\t"; 

while($row = mysql_fetch_row($result)) { 

	$data = ""; 

	for($i=0; $i<mysql_num_fields($result);$i++) { 

		if(!isset($row[$i])) 

			$data .= "NULL".$sep; //处理NULL字段

		elseif ($row[$i] != ""){

			$datmp=iconv("utf-8", "gbk",$row[$i]);

			$data .= $datmp.$sep; 

		}

	else 

		$data .= "".$sep; //处理空字段

	} 

	echo $data."\n"; 

}

 ?>