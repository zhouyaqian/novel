window.onload=function(){
	var containerone=document.getElementById('container');
	var listone=document.getElementById('list');
	var buttonsone=document.getElementById('buttons').getElementsByTagName('span');
	var nextone=document.getElementById('next');
	var prevone=document.getElementById('prev');
	var index = 1;
    var animated = false;
    var interval = 3480;
    var timer;

	function animate(offset){
	animated=true;
	var newleft=parseInt(listone.style.left)+offset;
	var time=500;//位移总时间
	var interval=10;//位移间隔时间
	var speed=offset/(time/interval);//求出每次的位移量 变化值
	function go(){
		if ( (speed < 0 && parseInt(listone.style.left) >newleft) || (speed > 0 && parseInt(listone.style.left) < newleft)) {
                        listone.style.left = parseInt(listone.style.left) + speed + 'px';
                        setTimeout(go, interval);
                    }
                    else {
                    	animated=false;
                        listone.style.left = newleft + 'px';
                        if(newleft> -1160){
                            listone.style.left = -3480  + 'px';
                        }
                        if(newleft< -3480) {
                            listone.style.left = -1160+'px';
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
		if(index==3){
			index=1;
		}else{
			index+=1;
		}
		showbuttons();
		if(animated==false){
		animate(-1160);
		}
	}
	prevone.onclick=function(){
		if(index==1){
			index=3;
		}
		else{
			index -=1;
		}
		showbuttons();
		if(animated==false){
		animate(1160);
		}
	}

for(var i=0;i<buttonsone.length;i++){
	buttonsone[i].onclick=function(){
		if(this.className=='on'){
			return;
		}
		var myindex=parseInt(this.getAttribute('index'));
		var offset=-1160*(myindex-index);
		index=myindex;
		showbuttons();
		if(animated==false){
			animate(offset);
		}
	}
}
	containerone.onmouseover=stop;
	containerone.onmouseout=play;
	play();


//点击圆圈亮起来
function showbuttons(){
	 for (var i = 0; i < buttonsone.length; i++) {
                    if( buttonsone[i].className == 'on'){
                        buttonsone[i].className = '';
                        break;
                    }
                }
                buttonsone[index - 1].className = 'on';
     }







};
