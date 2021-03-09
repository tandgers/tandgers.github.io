




function getdate() 
{
    

var date = new Date();//<!--获得日期数据-->
var y = date.getFullYear();//<!--年-->
var m = date.getMonth()+1;//<!--月，这里的月份必须要+1才是当前月份-->
var d = date.getDate(); //<!--日，getDay是获得当前星期几（0-6），getDate是获得当前日期-->

document.getElementById("ymd").innerHTML = "更新时间："+y+"-"+m+"-"+d;
}
getdate();



