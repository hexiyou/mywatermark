<?php 
ini_set('DISPLAY_ERRORS','ON');
error_reporting(E_ALL);


echo "\n";


//var_dump(GetPicseries("dingban"));


//��������洢����
$batch_code="";

/**********************************
���¿�ʼ��ȡ����������������Ҫ�Ĳ�����
**********************************/
//2019.12.21
$date="2019/12/21";
$imgroup1=GetPicseries("gande");
$timegroup1=getTimeseries("09:11");
$imgroup2=GetPicseries("shide");
$timegroup2=getTimeseries("16:23");
appendBatchCode(date("Y-m-d",strtotime($date)),$date,$imgroup1,$timegroup1,"�ɵ�");
appendBatchCode(date("Y-m-d",strtotime($date)),$date,$imgroup2,$timegroup2,"ʪ��");



//2020.1.15
$date="2020/01/15";
$imgroup1=GetPicseries("gande");
$timegroup1=getTimeseries("10:23");
$imgroup2=GetPicseries("shide");
$timegroup2=getTimeseries("17:01");
$imgroup3=GetPicseries("dingban");
$timegroup3=getTimeseries("11:21");
appendBatchCode(date("Y-m-d",strtotime($date)),$date,$imgroup1,$timegroup1,"�ɵ�");
appendBatchCode(date("Y-m-d",strtotime($date)),$date,$imgroup2,$timegroup2,"ʪ��");
appendBatchCode(date("Y-m-d",strtotime($date)),date("Y-m-d",strtotime("$date +3day")),$imgroup3,$timegroup3,"����");



//2020.3.4
$date="2020/03/04";
$imgroup1=GetPicseries("gande");
$timegroup1=getTimeseries("9:23");
$imgroup2=GetPicseries("shide");
$timegroup2=getTimeseries("15:01");
$imgroup3=GetPicseries("dingban");
$timegroup3=getTimeseries("12:21");
appendBatchCode(date("Y-m-d",strtotime($date)),$date,$imgroup1,$timegroup1,"�ɵ�");
appendBatchCode(date("Y-m-d",strtotime($date)),$date,$imgroup2,$timegroup2,"ʪ��");
appendBatchCode(date("Y-m-d",strtotime($date)),date("Y/m/d",strtotime("$date +3day")),$imgroup3,$timegroup3,"����");


//2020.3.18
$date="2020/03/18";
$imgroup1=GetPicseries("gande");
$timegroup1=getTimeseries("9:12");
$imgroup2=GetPicseries("shide");
$timegroup2=getTimeseries("15:15");
$imgroup3=GetPicseries("dingban");
$timegroup3=getTimeseries("11:21");
appendBatchCode(date("Y-m-d",strtotime($date)),$date,$imgroup1,$timegroup1,"�ɵ�");
appendBatchCode(date("Y-m-d",strtotime($date)),$date,$imgroup2,$timegroup2,"ʪ��");
appendBatchCode(date("Y-m-d",strtotime($date)),date("Y/m/d",strtotime("$date +3day")),$imgroup3,$timegroup3,"����");




//2020.4.2
$date="2020/04/02";
$imgroup1=GetPicseries("gande");
$timegroup1=getTimeseries("9:48");
$imgroup2=GetPicseries("shide");
$timegroup2=getTimeseries("17:06");
$imgroup3=GetPicseries("dingban");
$timegroup3=getTimeseries("10:21");
appendBatchCode(date("Y-m-d",strtotime($date)),$date,$imgroup1,$timegroup1,"�ɵ�");
appendBatchCode(date("Y-m-d",strtotime($date)),$date,$imgroup2,$timegroup2,"ʪ��");
appendBatchCode(date("Y-m-d",strtotime($date)),date("Y/m/d",strtotime("$date +3day")),$imgroup3,$timegroup3,"����");







/**********************************
�����������ɴ������
**********************************/
//echo $batch_code;


//����������д��Bat�ļ�
$batfile="run_batch_water.bat";

$batPrecode="@echo off&title ��������ˮӡ��...\r\n";
$batPrecode.='pushd "%~dp0"'."\r\n";
$batPrecode.='call setvars.cmd'."\r\n";
$batCode=$batPrecode.$batch_code;
$batCode.="echo.&title ˮӡ���ɽ���...\r\n";
$batCode.="echo.&echo ���н���&&pause\r\n";


echo $batfile;
file_put_contents($batfile,$batCode);

echo "�����б�Ŀ¼�µ� run_batch_water.bat �������ˮӡ��\n";


function appendBatchCode($folder_date,$date,$imgarr,$timearr,$class="�ɵ�"){
	global $batch_code;
	for($i=0;$i<count($imgarr);$i++){
		$batch_code.="cls&&echo   ���� php -f water.php \"".$imgarr[$i]."\"  $folder_date \"".$date." ".$timearr[$i]."\" $class\r\necho  ��ȴ�....\r\n";
		$batch_code.="php -f water.php \"".$imgarr[$i]."\" $folder_date \"".$date." ".$timearr[$i]."\" $class\r\n";
	}
	return $batch_code;
}



//��ȡͼƬ���У�Ĭ��5��
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



//��ȡʱ������
function getTimeseries($startTime,$count=5){
	//��һ���������贫��ʱ�ͷ֣������ղ���Ҫ
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
		//������ֻ��һλ��Ĭ��ǰ�߲���
		$timearr[]="$now_hour:".sprintf("%02d",$now_Minutes);
	}
	
	return $timearr;
}

//��ȡ����¼�����
function getMinutesStep(){	
	return mt_rand(4,21);
}

//�ɵ��زĿ�
function getGande(){
	return getOnePic('�ز�/�ɵ�/*');
}

//ʪ���زĿ�
function getShide(){
	return getOnePic('�ز�/��ˮ��/*');
}

//�����زĿ�
function getDindban(){
	return getOnePic('�ز�/����/*');
}

function getOnePic($path){
	
	$arr=glob($path);
	
	//print_r($arr);
	
	$index=rand(0,count($arr)-1);
	
	return $arr[$index];
}

?>