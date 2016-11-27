window.onload=function(){

var namefo=document.getElementById('name_info'),
	passwordfo=document.getElementById('password_info'),
	cofirmfo=document.getElementById('password_aff'),
	emailinfo = document.getElementById('mail_box');
	nameTr();
    passwordTr();
    cofirmpasswordTr();
    emailTr();
    //button函数
    document.getElementsByTagName('button')[0].onclick=function(){
      var plist=document.getElementsByClassName('message');
      for(var i=0; i<plist.length;i++){
        if(plist[i].style.color !='green'){
         alert('输入有误,请重新输入');
          return false;
        }
      }
    }
 

 //验证姓名
function nameTr(){
	 var userinput=namefo.getElementsByTagName('input')[0],
         userp=namefo.getElementsByTagName('p')[0];
         userinput.onfocus=function(){
         	userp.innerHTML='请输入长度为4~16位字符';
         }
         userinput.onblur=function(){
         if(userinput.value.length>=4 && userinput.value.length <=16){
            userp.innerHTML='帐号格式正确';
            inputinfo(userp,userinput,true)
          }else{
            userp.innerHTML='请输入长度为4~16位字符';
            inputinfo(userp,userinput,false)
          }
        }
      }
//输入密码
function passwordTr(){
	var userinput =passwordfo.getElementsByTagName('input')[0],
		userp=passwordfo.getElementsByTagName('p')[0];
		userinput.onfocus=function(){
			userp.innerHTML='请输入6~10位的字符';
		}
		userinput.onblur=function(){
			if(userinput.value.length>=6 && userinput.value.length <=16){
				userp.innerHTML='格式正确';
				inputinfo(userp,userinput,true)
			}else{
				userp.innerHTML='请输入长度为6~16位字符';
				inputinfo(userp,userinput,false)
			}
		}
}
//验证密码
function cofirmpasswordTr(){
	var userinput=cofirmfo.getElementsByTagName('input')[0],
		userp=cofirmfo.getElementsByTagName('p')[0];
		userinput.onfocus=function(){
			userp.innerHTML='请再次输入密码';
		}
		userinput.onblur=function(){
			if(userinput.value==passwordfo.getElementsByTagName('input')[0].value){
				userp.innerHTML='密码一致';
				inputinfo(userp,userinput,true)
			}else{
				userp.innerHTML='您两次输入的密码不一致';
				inputinfo(userp,userinput,false)
			}
		}
}
//邮箱
function emailTr(){
	var userinput=emailinfo.getElementsByTagName('input')[0],
	userp=emailinfo.getElementsByTagName('p')[0];
	filter  =  /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
	userinput.onfocus=function(){
		userp.innerHTML='请输入邮箱';
	}
	userinput.onblur=function(){
		if(filter.test(userinput.value)){
			userp.innerHTML='邮箱格式正确';
			inputinfo(userp,userinput,true)
		}else{
			userp.innerHTML='你的电子邮件格式不正确';
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

