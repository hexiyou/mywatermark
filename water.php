<?php

if(empty($argv[1])||empty($argv[2])){
	echo "ȱ�ٲ���;\n������ʽ��ͼƬ����/·�� ����ļ������� ˮӡ���� ����(�ɵĻ�ʪ��)";
	exit();
}

$dst_path = trim($argv[1]);
$dst_folder = trim($argv[2]);
$dst_text = trim($argv[3]);
$dst_path = str_replace('\\','\\\\',$dst_path);
$dst_step = $argv[4]?trim($argv[4]):"�ɵ�";
//echo $dst_path;
//exit();

$datesuffix=date("Y-m-d",strtotime($dst_text));
$imgname=basename($dst_path,'.jpg');

//$dst_path = 'dst.jpg';
//����ͼƬ��ʵ��
$dst = imagecreatefromstring(file_get_contents($dst_path));

//��������
$font = './verdana.ttf';//����·��

list($dst_w, $dst_h, $dst_type) = getimagesize($dst_path);
$black = imagecolorallocate($dst, 0xFF, 0x00, 0x00);//������ɫ
imagefttext($dst, 120, 0, $dst_w-1600, $dst_h-150, $black, $font, $dst_text);

$imgout="���/$dst_folder/$dst_step/$imgname-$datesuffix.jpg";

if(!file_exists("���/$dst_folder/$dst_step")){
	mkdir("���/$dst_folder/$dst_step",0777,true);
}

switch ($dst_type) {
    case 1://GIF
        //header('Content-Type: image/gif');
        imagegif($dst,$imgout);
        break;
    case 2://JPG
        //header('Content-Type: image/jpeg');
        imagejpeg($dst,$imgout);
        break;
    case 3://PNG
        //header('Content-Type: image/png');
        imagepng($dst,$imgout);
        break;
    default:
        break;
}
imagedestroy($dst);

?>