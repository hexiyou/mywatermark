@echo off&&title 批量生成图片水印-调用入口
pushd "%~dp0"
call setvars.cmd
echo  生成批量所需参数和代码.....
echo php -f run.php
php -f run.php
echo 执行生成水印过程....请耐心等待，输出的图片在“输出”文件夹下。
if exist run_batch_water.bat call run_batch_water.bat else echo  run_batch_water.bat 不存在，无法执行水印生成！

echo 脚本运行结束，按任意键退出....
pause>nul