window.onload=function(){
	var namefo=document.getElementById('name_info'),
		phonefo=document.getElementById('phone_box');
		nameTr();
    	phoneTr();
    	//button函数
    	document.getElementsByClassName('land')[0].onclick=function(){
    		 var plist=document.getElementsByClassName('message');
    	for(var i=0; i<plist.length;i++){
			if(plist[i].style.color !='green'){
			  alert('输入有误,请重新输入');
			  return false;
			}
		}
		alert("感谢您的评价！！！");
    }


function nameTr(){
	 var userinput=namefo.getElementsByTagName('input')[0],
         userp=namefo.getElementsByTagName('p')[0];
         userinput.onfocus=function(){
         	userp.innerHTML='请输入姓名';
         }
         userinput.onblur=function(){
         	if(userinput.value.length>=2 && userinput.value.length <=8){
         		userp.innerHTML='';
            inputinfo(userp,userinput,true)
         	}
         	else{
            userp.innerHTML='';
            inputinfo(userp,userinput,false)
         }
      }
}


function phoneTr() {
	var userinput = phonefo.getElementsByTagName('input')[0],
		userp = phonefo.getElementsByTagName('p')[0];
		filter  = /^(13[0-9]|14[0-9]|15[0-9]|18[0-9])\d{8}$/;
	userinput.onfocus = function () {
		userp.innerHTML = '请输入手机号码';
	}
	userinput.onblur = function () {
		if (filter.test(userinput.value)) {
			userp.innerHTML = '';
			inputinfo(userp,userinput,true) 
		} else {
			userp.innerHTML = '您的手机号码格式不正确';
			inputinfo(userp,userinput,false) 
		}
	}	
}




//input框样式函数
function inputinfo(text,input,bool) {
  if (bool) {
    text.style.color = 'green';
    input.style.border = '1px solid green';
  } else {
    text.style.color = 'red';
    input.style.border = '1px solid red';
  } 
}





};