$(function(){ 
    var i = -1;  
    // 添加年份，从2005年开始  
    for (i = 2005; i <= new Date().getFullYear(); i++) {  
		addOption(years,i,i - 2004);   
    }  
    // 添加月份  
    for (i = 1; i <= 12; i++) {  
         addOption(months, i, i);  
    }      
});  
     
// 设置每个月份的天数  
function setDays(year, month,day) {  
    var monthDays = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];  
    var yea = year.options[year.selectedIndex].text;  
    var mon = month.options[month.selectedIndex].text;  
    var num = monthDays[mon - 1];  
    if (mon == 2 && isLeapYear(yea)) {  
        num++;  
    }  
	document.getElementById("days").innerHTML="<option value=''>日</option>";
	for (i = 1; i <= num; i++) {  
        addOption(days, i, i);  
    }
}  
       
// 判断是否闰年  
function isLeapYear(year)  
{  
    return (year % 4 == 0 || (year % 100 == 0 && year % 400 == 0));  
}  
       
// 向select尾部添加option  
 function addOption(selectbox, text, value) {  
    var option = document.createElement("option");  
     option.text = text;  
     option.value = value;  
     selectbox.options.add(option);  
 }
