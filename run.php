<?php 
ini_set('DISPLAY_ERRORS','ON');
error_reporting(E_ALL);


echo "\n";


//var_dump(GetPicseries("dingban"));


//批量代码存储变量
$batch_code="";

/**********************************
以下开始获取并生成批量操作需要的参数。
**********************************/
//2019.12.21
$date="2019/12/21";
$imgroup1=GetPicseries("gande");
$timegroup1=getTimeseries("09:11");
$imgroup2=GetPicseries("shide");
$timegroup2=getTimeseries("16:23");
appendBatchCode(date("Y-m-d",strtotime($date)),$date,$imgroup1,$timegroup1,"干的");
appendBatchCode(date("Y-m-d",strtotime($date)),$date,$imgroup2,$timegroup2,"湿的");



//2020.1.15
$date="2020/01/15";
$imgroup1=GetPicseries("gande");
$timegroup1=getTimeseries("10:23");
$imgroup2=GetPicseries("shide");
$timegroup2=getTimeseries("17:01");
$imgroup3=GetPicseries("dingban");
$timegroup3=getTimeseries("11:21");
appendBatchCode(date("Y-m-d",strtotime($date)),$date,$imgroup1,$timegroup1,"干的");
appendBatchCode(date("Y-m-d",strtotime($date)),$date,$imgroup2,$timegroup2,"湿的");
appendBatchCode(date("Y-m-d",strtotime($date)),date("Y-m-d",strtotime("$date +3day")),$imgroup3,$timegroup3,"顶板");



//2020.3.4
$date="2020/03/04";
$imgroup1=GetPicseries("gande");
$timegroup1=getTimeseries("9:23");
$imgroup2=GetPicseries("shide");
$timegroup2=getTimeseries("15:01");
$imgroup3=GetPicseries("dingban");
$timegroup3=getTimeseries("12:21");
appendBatchCode(date("Y-m-d",strtotime($date)),$date,$imgroup1,$timegroup1,"干的");
appendBatchCode(date("Y-m-d",strtotime($date)),$date,$imgroup2,$timegroup2,"湿的");
appendBatchCode(date("Y-m-d",strtotime($date)),date("Y/m/d",strtotime("$date +3day")),$imgroup3,$timegroup3,"顶板");


//2020.3.18
$date="2020/03/18";
$imgroup1=GetPicseries("gande");
$timegroup1=getTimeseries("9:12");
$imgroup2=GetPicseries("shide");
$timegroup2=getTimeseries("15:15");
$imgroup3=GetPicseries("dingban");
$timegroup3=getTimeseries("11:21");
appendBatchCode(date("Y-m-d",strtotime($date)),$date,$imgroup1,$timegroup1,"干的");
appendBatchCode(date("Y-m-d",strtotime($date)),$date,$imgroup2,$timegroup2,"湿的");
appendBatchCode(date("Y-m-d",strtotime($date)),date("Y/m/d",strtotime("$date +3day")),$imgroup3,$timegroup3,"顶板");




//2020.4.2
$date="2020/04/02";
$imgroup1=GetPicseries("gande");
$timegroup1=getTimeseries("9:48");
$imgroup2=GetPicseries("shide");
$timegroup2=getTimeseries("17:06");
$imgroup3=GetPicseries("dingban");
$timegroup3=getTimeseries("10:21");
appendBatchCode(date("Y-m-d",strtotime($date)),$date,$imgroup1,$timegroup1,"干的");
appendBatchCode(date("Y-m-d",strtotime($date)),$date,$imgroup2,$timegroup2,"湿的");
appendBatchCode(date("Y-m-d",strtotime($date)),date("Y/m/d",strtotime("$date +3day")),$imgroup3,$timegroup3,"顶板");







/**********************************
批量参数生成代码结束
**********************************/
//echo $batch_code;


//把批量代码写入Bat文件
$batfile="run_batch_water.bat";

$batPrecode="@echo off&title 批量生成水印中...\r\n";
$batPrecode.='pushd "%~dp0"'."\r\n";
$batPrecode.='call setvars.cmd'."\r\n";
$batCode=$batPrecode.$batch_code;
$batCode.="echo.&title 水印生成结束...\r\n";
$batCode.="echo.&echo 运行结束&&pause\r\n";


echo $batfile;
file_put_contents($batfile,$batCode);

echo "请运行本目录下的 run_batch_water.bat 批量添加水印！\n";


function appendBatchCode($folder_date,$date,$imgarr,$timearr,$class="干的"){
	global $batch_code;
	for($i=0;$i<count($imgarr);$i++){
		$batch_code.="cls&&echo   运行 php -f water.php \"".$imgarr[$i]."\"  $folder_date \"".$date." ".$timearr[$i]."\" $class\r\necho  请等待....\r\n";
		$batch_code.="php -f water.php \"".$imgarr[$i]."\" $folder_date \"".$date." ".$timearr[$i]."\" $class\r\n";
	}
	return $batch_code;
}



//获取图片序列，默认5张
function GetPicseries($type,$count=5){
	$imgarr=[];
	for($i=0;$i<$count;$i++){
		switch($type){
			case "gande":
			  $imgarr[]=getGande();
			break;
			case "shide":
				$imgarr[]=getShide();
			break;
			case "dingban":
				$imgarr[]=getDindban();
				break;
		}	
	}
	return $imgarr;
	
}



//获取时间序列
function getTimeseries($startTime,$count=5){
	//第一个参数仅需传入时和分，年月日不需要
	$timearr=array();
	$timearr[]=$startTime;
	$start_hour=intval(date('H',strtotime($startTime)));
	$start_Minutes=intval(date('i',strtotime($startTime)));
	
	$now_hour=$start_hour;
	$now_Minutes=$start_Minutes;
	
	for($i=1;$i<$count;$i++){
		$now_Minutes=$now_Minutes+getMinutesStep();
		if($now_Minutes>=60){
			$now_hour+=1;
			$now_Minutes=$now_Minutes-60;
		}
		//分钟数只有一位则默认前边补零
		$timearr[]="$now_hour:".sprintf("%02d",$now_Minutes);
	}
	
	return $timearr;
}

//获取随机事件步长
function getMinutesStep(){	
	return mt_rand(4,21);
}

//干的素材库
function getGande(){
	return getOnePic('素材/干的/*');
}

//湿的素材库
function getShide(){
	return getOnePic('素材/泡水的/*');
}

//顶板素材库
function getDindban(){
	return getOnePic('素材/顶板/*');
}

function getOnePic($path){
	
	$arr=glob($path);
	
	//print_r($arr);
	
	$index=rand(0,count($arr)-1);
	
	return $arr[$index];
}

?>