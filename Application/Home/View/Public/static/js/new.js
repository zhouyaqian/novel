window.onload=function(){
	var detail=document.getElementById('detail');
	var listone=document.getElementById('list');
	var nextone=document.getElementById('next');
	var prevone=document.getElementById('prev');
	var timer;
	var interval = 3700;
	var animated=false;
	function animate(offset){
		animated=true;
		var time=300;//位移总时间
		var interval=10;//位移间隔时间
		var speed=(offset/(time/interval))//每次变化位移量
		var newleft=parseInt(listone.style.left)+offset;
		function go(){
		if((speed>0 && parseInt(listone.style.left)<newleft) || 
			(speed<0 && parseInt(listone.style.left)>newleft)){
			listone.style.left=parseInt(listone.style.left)+speed+'px';
		setTimeout(go, interval);
		}
	else{
		animated=false;
			listone.style.left=newleft +'px';
			if(newleft> -740){
			leftistone.style.left= -3700+'px';
			}
			if(newleft< -3700){
			listone.style.left= -740+'px';
			}
		}
	}
	go();
}	

function play(){
		timer=setInterval(function(){
			nextone.onclick();
		},3000);
	}
	function stop(){
		clearInterval(timer);
	}

	nextone.onclick=function(){
		if(animated==false){
		animate(-740);
	}
}
	prevone.onclick=function(){
		if(animated==false){
		animate( 740);
	}
}


detail.onmouseover=stop;
detail.onmouseout=play;
play();













};