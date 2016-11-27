$(function(){
	//点爱心
	$('#button-love').click(function(){
		var id = $(this).attr('_id');
		var flove="love"+id;
		if(getCookie(flove)!=id){
			//键，值，过期时间以年为单位
			setCookie(flove,id,100);
			//保存最新推荐指数
			$.get($(this).attr('link'),{"id":id,"al":1},function(result){
				//自增
				if(result>0){
					var loveobj=document.getElementById("love");
					var lovetext=loveobj.innerHTML;
					lovetext++;
					loveobj.innerHTML=lovetext;
				}
			});
		}else{
			console.log('exist')
		}
	});
	//点赞同
	$('.a-love').click(function(){
		var id = $(this).attr('_id');
		var flove="flag"+id;
		if(getCookie(flove)!=id){
			//键，值，过期时间以年为单位
			setCookie(flove,id,100);
			//保存最新推荐指数
			var _this =this;
			$.get($(this).attr('link'),{"id":id,"al":1},function(result){
				//自增
				if(result>0){
					var loveobj = $(_this).find('span');
					var lovetext=parseInt(loveobj.html());
					lovetext++;
					loveobj.html(lovetext);
				}
			});
		}else{
			console.log('exist');
		}
	});
});


