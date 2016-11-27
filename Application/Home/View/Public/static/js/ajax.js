$(function(){
				var error=new Array();
				$('input[name="username"]').blur(function(){
					//获得标签里的内容
					var username=$(this).val();
					$.get('__URL__/checkName',{'username':username},function(data){
						if(data=='不允许'){
							error['username']=1;
							$('input[name="username"]').after('<p id="umessage" style="color:red">该用户名已经注册</p>');
						}else{
							error['username']=0;
							$('#umessage').remove();
						}
					});
				});

				//提交表单
				$('img.register').click(function(){
					if(error['username']==1){
						return false;
					}else{
						$('form[name="myForm"]').submit();
					}
				});
			});