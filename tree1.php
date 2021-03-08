<?php
	echo"当前页面生成时间：";
	echo date("Y-m-d H:i:s",time()).'<br />';
?>

<?php
	echo"<br /> 以下为目录索引：";

?>



<?php
/*作者：梦行Monxin*/
header('Content-Type:text/html;charset=utf-8');
$path='./';
$v=get_dir_to_html($path);
file_put_contents('dir.html',$v);
echo $v;

function get_dir_to_html($path){
	$r=scandir($path);
	$html='';
	$dirs='';
	$files='';
	$t='';
	foreach($r as $v){
		if($v=='.' || $v=='..'){continue;}
		
		$v=iconv('',"".'//IGNORE',$v);
		if(is_dir($path.$v)){
			$t.="\t";
			$dirs.=$t.'<li class=dir id="'.trim($path.$v,'./').'"><div class=line><div>'.$v."</div><div></div></div>\r\n".$t.get_dir_to_html($path.$v.'/')."</li>\r\n";	
		}else{
			$temp=explode('.',$v);
			$files.=$t.'<li class='.$temp[count($temp)-1].' id="'.trim($path.$v,'./').'"><div class=line><div>'.$v."</div><div></div></div></li>\r\n";;	
		}
	}
	if($dirs!='' || $files!=''){$html="<ul>".$dirs.$files."</ul>\r\n";}
	return $html;
}

//最后再后百度"html 格式化",让它有TAB符，看起来更清晰
?>




© 东哥制作 2020- <?php echo date("Y")?>