<?php
/*
本源码来源于网络
http://user.qzone.qq.com/292672703
*/
header("content-Type: text/html; charset=utf-8");  //定义编码
set_time_limit (0);//不限时   24 * 60 * 60
//语言包数组
$lang_cn = array (
  '0' => '文件地址',
  '1' => '输入密码',
  '2' => '下载耗时',
  '3' => '微秒,文件大小',
  '4' => '字节',
  '5' => '下载成功',
  '6' => '无效密码',
  '7' => '请重新输入',
  '8' => '远程文件下载',
  '9' => '不能打开文件',
  '10'=> '不能写入文件',
  '11'=> '文件地址',
  '12'=> '下载时间',
  '13'=> '文件不可写入',
  '14'=> '成功地将',
  '15'=> '操作记录成功写入!',
  '16'=> '系统已将此次操作写入日志记录!',
  '17'=> '写入失败',
  '18'=> '文件不存在,试图创建,',
  '19'=> '创建失败！',
  '20'=>'文件大小',
  '21'=>'未知',
  '22'=>'已经下载',
  '23'=>'完成进度',
  '24'=>'必须为绝对地址，且前面要加http://'
);
//China,中文
$lang_en = array (
  '0' => 'File',
  '1' => 'Pass',
  '2' => 'DownTime',
  '3' => 'Ms, file size',
  '4' => 'Byte',
  '5' => 'Download complete',
  '6' => 'Invalid password',
  '7' => 'Please try again',
  '8' => 'Happy flying blog - Remote File Download',
  '9' => 'Can not open file',
  '10'=> 'Can not write file',
  '11'=> 'Query File',
  '12'=> 'Query Time',
  '13'=> 'file not writeable',
  '14'=> 'I have success save',
  '15'=> 'Write successful!',
  '16'=> 'The operating system has written to the log records!',
  '17'=> 'Success or failure',
  '18'=> 'File does not exist, attempting to create,',
  '19'=> 'Create Failed',
  '20'=>'File Size',
  '21'=>'Unknown length',
  '22'=>'Have downloaded',
  '23'=>'Download progress',
  '24'=>'Must be an absolute address'
);
//English,英文
$Language = $lang_cn;         //切换语言
$Archives = 'log.txt';         //Log文件
$Folder   = 'download/';     //下载目录
$password = 'tandgers';         //管理密码
?>
<!--简单控制地址长度-->
<SCRIPT language=javascript>
function CheckPost()
{
    if (myform.url.value.length<10)
    {
        alert("文件地址不能小于10个字符，请认真填写！");
        myform.url.focus();
        return false;
    }
}
</SCRIPT>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $Language[8]; ?></title>
</head>

<body>
<form method="post"  name="myform" onsubmit="return CheckPost();">
<?php echo $Language[0]; ?>: <input name="url" type="text" value="http://" size="50%"/> <font color="red"><?php echo $Language[24]; ?></font><br>
<?php echo $Language[1]; ?>: <input name="password" type="password"size="30%" /><br>
<input name="submit" type="submit" value="确认下载" />
</form><br />

<table border="1" width="100%">
    <tr>
        <td width="20%"><?php echo $Language[20]; ?></td>
        <td width="80%"><font color="red"><div id="filesize"><?php echo $Language[21]; ?></font> <?php echo $Language[4]; ?></div></td>
    </tr>
    <tr>
        <td> <?php echo $Language[22]; ?></td><td><font color="red"><div id="downloaded">0</font> <?php echo $Language[4]; ?></div></td>
    </tr>
    <tr>
        <td> <?php echo $Language[23]; ?></td><td><font color="red"><div id="progressbar" style="float:left;width:1px; text-align:center; color:#FFFFFF; background-color:#0066CC"></div><div id="progressText" style=" float:left">0%</div></font></td>
    </tr>
</table>
<!--文件计算、进度显示-->
<script type="text/javascript">
   //文件长度
    var filesize=0;
    function $(obj)
    {
        return document.getElementById(obj);
    }
    //设置文件长度
   function setFileSize(fsize)
   {
     filesize=fsize;
     $("filesize").innerHTML=fsize;
   }
    //设置已经下载的,并计算百分比
   function setDownloaded(fsize)
   {
        $("downloaded").innerHTML=fsize;
        if(filesize>0)
        {
            var percent=Math.round(fsize*100/filesize);
            $("progressbar").style.width=(percent+"%");
            if(percent>0)
            {
                $("progressbar").innerHTML=percent+"%";
                $("progressText").innerHTML="";
            }
            else
            {
                $("progressText").innerHTML=percent+"%";
            }
    
        }
   }

</script>

<?php
//密码验证
if ($_POST['password'] == $password) 
{
    class runtime 
    {
        var $StartTime = 0;
        var $StopTime = 0;
        function get_microtime()
        {
            list($usec, $sec) = explode(' ', microtime());
            return ((float)$usec + (float)$sec);
        }
        function start() 
        {
            $this->StartTime = $this->get_microtime();
        }
        function stop()  
        {
            $this->StopTime = $this->get_microtime();
        }
        function spent() 
        { 
            return round(($this->StopTime - $this->StartTime) * 1000, 1);
        }
    }

//消耗时间
$runtime= new runtime;
$runtime->start();

// 下载
if (!isset($_POST['submit'])) die();
    $destination_folder = $Folder;
    if(!is_dir($destination_folder))
        mkdir($destination_folder,0777);
$url = $_POST['url'];
$file = fopen ($url, "rb");
if ($file)
{
    // 获取文件大小
    $filesize=-1;
    $headers = get_headers($url, 1);
    if ((!array_key_exists("Content-Length", $headers)))
    {
         $filesize=0; 
    }
    $filesize= $headers["Content-Length"];
    $newfname = $destination_folder . basename($url);

  //不是所有的文件都会先返回大小的，
  //有些动态页面不先返回总大小，这样就无法计算进度了

    if($filesize != -1)
    {
        echo "<script>setFileSize($filesize);</script>";    //在前台显示文件大小
    }
    $newf = fopen ($newfname, "wb");
    $downlen=0;
    if ($newf)
        while(!feof($file)) {
        $data=fread($file, 1024 * 8 );    //默认获取8K
        $downlen+=strlen($data);    // 累计已经下载的字节数
        fwrite($newf, $data, 1024 * 8 );
        echo "<script>setDownloaded($downlen);</script>";    //在前台显示已经下载文件大小
        ob_flush();
        flush();
    }
}
if ($file) 
{
  fclose($file);
}

if ($newf) 
{
  fclose($newf);
}
    
$runtime->stop();//停止计算

//乱七八糟的东西 -0-；
    $downtime =  '<p>'.$Language[2].':<font color="blue"> '.$runtime->spent().' </font>'.$Language[3].'<font color="blue"> '.$headers["Content-Length"].' </font>'.$Language[4].'.</p><br>';
    $downok  =   '<p><font color="red">'.$Language[5].'！'.date("Y-m-d H:i:s").'</font></p><br>';
}
elseif(isset($_POST['password']))
{
    $passerror = '<p><font color="red">'.$Language[6].'！'.$Language[7].'!</font></p><br>';
}

$Export = $downtime.$downok.$passerror;
if(isset($_POST['url']) && ($_POST['password'] == $password)) 
{
    $filename = $Archives;
    $somecontent = $Language[11].': '.$url."\r\n".$Language[2].": ".$runtime->spent().$Language[3].": ".$headers["Content-Length"].$Language[4]."\r\n".$Language[12].': '.date("Y-m-d H:i:s")."\r\n"."\r\n";  
    if (!file_exists($filename))
    {
        $echo_1 = $Language[18];
        if (!fopen($filename, 'w'))
        {
            $echo_2 = $Language[19];
        }
    }
// 文件操作

if (is_writable($filename)) //判断是否可写
{
    if (!$handle = fopen($filename, 'a+')) //打开文件
    {
        $echo_3 = $Language[9].$filename; //当打不开时
    } 
    else
    {
        if (fwrite($handle, $somecontent) === false)//写入
        {
            $echo_4 = $Language[10].$filename;
        } else
        {
            $echo_5 = $Language[15];
        }
        fclose($handle);//关闭连接
    }
} 
else
{
    $echo_6 = $Language[17];
}
}
$echo = $echo_1.$echo_2.$echo_3.$echo_4.$echo_5.$echo_6;
?>

<?php echo $Export; ?>
<p><font color="blue"><?php echo $echo; ?></font></p>
</body>
</html>