var date = new Date();//<!--获得日期数据-->
var y = date.getFullYear();//<!--年-->
var m = date.getMonth()+1;//<!--月，这里的月份必须要+1才是当前月份-->
var d = date.getDate(); //<!--日，getDay是获得当前星期几（0-6），getDate是获得当前日期-->
var h = date.getHours();
var i = date.getMinutes();
var s = date.getSeconds();
function getdate() 
{   

    if(i<10)
    {
        i="0"+i;
    } 

    if(s<10)
    {
        s="0"+s;
    }

    document.getElementById("ymd").innerHTML = "页面打开时间："+y+"-"+m+"-"+d+" "+h+":"+i+":"+s;
}



getdate();
document.getElementById("year").innerHTML = y;


