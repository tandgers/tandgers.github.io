<?php
header('Content-Type:text/html;charset=utf-8');
$dir = "."; //目录
file_put_contents('dir.html',"");
filelist($dir);


function filelist($dir){
$list = scandir($dir);
foreach($list as $file){//遍历
$path=$dir."/".$file;
if(is_dir($path) && $file!="." &&$file!=".."){ //判断是否是路径
filelist($path);
}else if(extend($file) == "html") {
echo $file."\t ---Address:--- \t".$path."\t<a href=$path>Modify | Delete </a><br>";
file_put_contents('dir.html', $file."\t ---Address:---- \t".$path."\t<a href=$path>Modify | Delete </a><br>" ,FILE_APPEND | LOCK_EX);
}
}
}
//返回文件类型
function extend($file_name)
{
$extend =explode("." , $file_name);
$va=count($extend)-1;
return $extend[$va];
}
?>