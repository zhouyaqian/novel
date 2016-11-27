
window.onload=function(){

var nameinfo = document.getElementById('name_info'),
    passwordinfo = document.getElementById('password_info');
    nameTr();
    passwordTr();
    //botton函数
    document.getElementsByTagName('button')[0].onclick=function(){
      var spanlist=document.getElementsByClassName('message');
	  
      for(var i=0; i<spanlist.length;i++){
		
        if(spanlist[i].style.color !='green'){
			//alert(spanlist[1].style.color);																											
          
         return false;
        }
      }
    }


  //验证帐号
  function nameTr(){
    var userinput=nameinfo.getElementsByTagName('input')[0],
        userspan=nameinfo.getElementsByTagName('span')[0];
        //console.log(userinput);
        userinput.onfocus=function(){
          //alert(1)
          userspan.innerHTML = '请输入长度为4~16位字符';
        }
        userinput.onblur = function () {
          if(userinput.value.length>=4 && userinput.value.length <=16){
            userspan.innerHTML='帐号格式正确';
            inputinfo(userspan,userinput,true)
          }else{
            userspan.innerHTML='请输入长度为4~16位字符';
            inputinfo(userspan,userinput,false)
          }
        }
      }
//验证密码
function passwordTr() {
  var userinput = passwordinfo.getElementsByTagName('input')[0],
      userspan= passwordinfo.getElementsByTagName('span')[0];
  userinput.onfocus = function () {
    userspan.innerHTML = '请输入6~16位密码';
  }
  userinput.onblur = function () {
    if (userinput.value.length >=6 && userinput.value.length <= 16) {
      userspan.innerHTML = '格式正确';
      inputinfo(userspan,userinput,true) 
    }else {
      userspan.innerHTML = '请输入长度为6~16位密码';
      inputinfo(userspan,userinput,false)
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

