@echo off&&title ��������ͼƬˮӡ-�������
pushd "%~dp0"
call setvars.cmd
echo  ����������������ʹ���.....
echo php -f run.php
php -f run.php
echo ִ������ˮӡ����....�����ĵȴ��������ͼƬ�ڡ�������ļ����¡�
if exist run_batch_water.bat call run_batch_water.bat else echo  run_batch_water.bat �����ڣ��޷�ִ��ˮӡ���ɣ�

echo �ű����н�������������˳�....
pause>nul