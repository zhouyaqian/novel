
//兼容浏览器
function addEvent(ele, type, hander) {
	if (ele.addEventListener) {
		ele.addEventListener(type, hander, false);
	} else if (ele.attachEvent) {
		ele.attachEvent('on' + type, hander);
	} else {
		ele['on' + type] = hander;
	}
}


window.onload = function() {
	var Ocom = document.getElementById('comment');
	var Oli = Ocom.getElementsByTagName('li');
	var Oviews = document.getElementById('views');
	var oDl = document.getElementById('Dl');

	var Odl_list = document.getElementsByClassName('dl-list');
	var sub = document.getElementsByClassName('submit'); //collection类数组
	var index = 0;
	
	//array.sort(),contact(),push,pop,shift,unshift
	var input_html = '<ol><div id="te"><textarea class= "content_text" name="content"></textarea></div><div id="bu"><input class="sub" type="button" value="发表"/></div></ol>';
	var wrap_list = document.getElementsByClassName('wrap-list');
	
	
	oDl.onclick = function(ev) {
		var ev = ev || window.event;
		var target = ev.target || ev.srcElement;
		//alert(target.innerHTML);
		//console.log(target);
		for (var i = 0; i < sub.length; i++) {
			sub[i].index = i;
		}
		if (target.className == 'submit') {
			if (wrap_list[target.index].innerHTML == '') {
				wrap_list[target.index].innerHTML = input_html;
				index = target.index;
				//console.log('只有第一次为空的时候执行');
			}
		}
			//console.log('fisrt');
			//var count = $('.sub').data('count');
			//$('.sub').data('count',++count);
		//回复
		if (target.className == 'sub') {
			postReply();
		}
	
		//事件会触发两次？？？？
		/*$('.sub').click(function(){
			//this.data('count')++;
			//if(this.data('count')>1) return;
			var url=$('.wrap-list').attr('url');
			var id=$(this).parent().prev().parent().parent().attr('_id');
			var _this = this;
			var content=$('#te').children().val();
			//console.log(id);
			//console.log(content);
			//console.log(url);
			$.post(url,{'id':id,'content':content},function(data){
				//console.log(data);
				//var com_re=eval("("+data+")");
			//alert(1)
				console.log('ajax');
				var com_re = JSON.parse(data);
				console.log(com_re);
				if(com_re){
					var date=new Date(com_re.time * 1000);
					Y = date.getFullYear() + '-';
					m = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
					d = date.getDate() + ' ';
					H = (date.getHours() <10 ? '0'+date.getHours()+':' : date.getHours()+':');
					i = (date.getMinutes() <10 ? '0'+date.getMinutes()+':' : date.getMinutes()+':');
					s = (date.getSeconds() <10 ? '0'+date.getSeconds() : date.getSeconds()); 
					var str="<dd class='time_re'>"+Y+m+d+H+i+s+"</dd><dd class='content_re'>"+com_re.content+"</dd>";
					var obj=$('.conten_re');
					console.log(str); return;
					$('.conten_re').append(str);
					//_this.data('count',0);
				}
				
			});
			return false;
		});*/
	}
	//回复功能
	function postReply(){
		var url=$('.wrap-list').attr('url');
		var id=$('.sub').parent().prev().parent().parent().attr('_id');
		var content=$('#te').children().val();
		if(!content){
			alert('内容不能为空!');
			return;
		}
		$.post(url,{'id':id,'content':content},function(data){
			var com_re = JSON.parse(data);
			if(com_re){
				var date=new Date(com_re.time * 1000);
				Y = date.getFullYear() + '-';
				m = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
				d = date.getDate() + ' ';
				H = (date.getHours() <10 ? '0'+date.getHours()+':' : date.getHours()+':');
				i = (date.getMinutes() <10 ? '0'+date.getMinutes()+':' : date.getMinutes()+':');
				s = (date.getSeconds() <10 ? '0'+date.getSeconds() : date.getSeconds()); 
				var str="<dd class='time_re'>"+Y+m+d+H+i+s+"</dd><dd class='content_re'>"+com_re.content+"</dd>";
				$('.commentre').eq(index).append(str);
				$('.content_text').val('');
				wrap_list[index].innerHTML = '';
			}
		
		});
	}
}
//发表评论功能
$(function(){
	$(".views").click(function(){
		var id = $(this).attr('_id');
		var url = $(this).attr('url');
		var viewsobj = $(this).prev("#comment_text");
		var text = $.trim( viewsobj.val() );
		if(!text){
			alert('内容不能为空!');
			return;
		}
		$.post(url,{'id':id,'content':text},function(data){
			//var add=eval("("+data+")");
			var add = JSON.parse(data);
			console.log(add);
			if(add){
				var date=new Date(add.time * 1000);
				var Y = date.getFullYear() + '-';
				var m = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
				var d = date.getDate() + ' ';
				var H = (date.getHours() <10 ? '0'+date.getHours()+':' : date.getHours()+':');
				var i = (date.getMinutes() <10 ? '0'+date.getMinutes()+':' : date.getMinutes()+':');
				var s = (date.getSeconds() <10 ? '0'+date.getSeconds() : date.getSeconds()); 
				var str = "<dl class='dl-list'><dt><img src='/Public/Images/wo3.png'/></dt><dd class='words-color'>"+Y+m+d+H+i+s+"</dd><p>"+add.content+"</p><ul class='respond'><li class='submit'>回复</li><img src='/Public/Images/wo5.png'/><li _id="+add.id+" link='__URL__/getLove' class='a-love'>赞同(<span>"+add.love+"</span>)</li></ul></dl><div class='wrap-list'></div><input type='hidden' name='id' value="+add.id+"/>";
				$('#com').after(str);
				$('#comment_text').val('');
			}
		});
	});
}) ;


