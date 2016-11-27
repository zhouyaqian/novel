<?PHP
/*
**该函数用来获取作品制作时间
*/
function getTime($y,$m,$d){
	$year=2004+$y;
	if($m<10){
		$month='0'.$m;
	}else{
		$month=$m;
	}
	if($d<10){
		$day='0'.$d;
	}else{
		$day=$d;
	}
	return $year.'-'.$month.'-'.$day;
}
/*
**该函数用来进行验证格式
*/
function flag($name,$time,$intro){
	if($name==""||strlen($name)>30){ //名字不能为空
		return false;
	}
	if($intro==""){ //作品介绍不能为空
		return false;
	}
	if(!preg_match('/^\d{4}-\d{2}-\d{2}/',$time)){ //时间格式验证
		return false;
	}
	return true;
}
function getImageName($pic_name){
	$image = new \Think\Image(); 
	$arr=explode ('/',$pic_name);
	for($i=1;$i<5;$i++){
		$array.=$arr[$i].'/';   //获取路径名
	}
	$pic=substr($arr[5],0,20);//图片名
	$image->open("$array"."$pic");
	$sl_name="$array".time().rand().'.png';//缩略图的路径
	//生成一个固定大小为150*150的缩略图
	$image->thumb(278, 195,\Think\Image::IMAGE_THUMB_FIXED)->save($sl_name);
	return $sl_name;
}
/*
  该函数用来调用calculate函数，将数据库查询出来的时间戳
  格式化成00:00的格式。参数为数据库查询出来的一条记录（
  一个数组格式）
*/
function assemble($count){
	$arr['username'] = $count['username'];
	$arr['id'] = $count['id'];
	$arr['week'] = $count['week'];
	$arr['monday'] = calculate($count['monday']);
	$arr['tuesday'] = calculate($count['tuesday']);
	$arr['wednesday'] = calculate($count['wednesday']);
	$arr['thursday'] = calculate($count['thursday']);
	$arr['friday'] = calculate($count['friday']);
	$arr['saturday'] = calculate($count['saturday']);
	$arr['sunday'] = calculate($count['sunday']);
	
	
	$total = $count['monday'] + $count['tuesday']+$count['wednesday']+$count['thursday']+$count['friday']+$count['saturday']+$count['sunday'];
	$arr['total'] = calculate($total);
	return $arr;
}

/*
	改函数用来将传过来的时间戳格式化成00:00格式
	参数为一个时间戳
*/
function calculate($cal){
	$hour = floor(($cal/60)/60);
	$min = round($cal/60,0)%60;
	if($hour <= 9){
		if($min <=9){
			return "0{$hour}:0{$min}";
		}else{
			return "0{$hour}:{$min}";
		}
	}else{
		if($min <=9){
			return "{$hour}:0{$min}";
		}else{
			return "{$hour}:{$hour}";
		}
	}
}

function deal_images($value){
	preg_match_all("/\/Public\/Uploads\/images\/[0-9]+\/[0-9]+\.(jpg|jpeg|png|gif|bmp)/",$value,$img,PREG_PATTERN_ORDER );
	
	for($i=0; $i < count($img[0]); $i++){
		$str=".";      
		$str.=$img[0][$i];
		$imgs[$i]=$str;
	}
	$images = new \Think\Image();  //实例化Image对象
	/*生成一个固定大小为740*380的缩略图并保存为原来名字*/
	for($j=0; $j < count($imgs); $j++){
		$images->open("$imgs[$j]");
		$images->thumb(740,380,\Think\Image::IMAGE_THUMB_FIXED)->save("$imgs[$j]");
	}	
	
	}
?>