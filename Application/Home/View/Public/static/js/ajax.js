$(function(){
				var error=new Array();
				$('input[name="username"]').blur(function(){
					//��ñ�ǩ�������
					var username=$(this).val();
					$.get('__URL__/checkName',{'username':username},function(data){
						if(data=='������'){
							error['username']=1;
							$('input[name="username"]').after('<p id="umessage" style="color:red">���û����Ѿ�ע��</p>');
						}else{
							error['username']=0;
							$('#umessage').remove();
						}
					});
				});

				//�ύ��
				$('img.register').click(function(){
					if(error['username']==1){
						return false;
					}else{
						$('form[name="myForm"]').submit();
					}
				});
			});