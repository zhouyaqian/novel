<?PHP
/*
**�ú���������ȡ��Ʒ����ʱ��
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
**�ú�������������֤��ʽ
*/
function flag($name,$time,$intro){
	if($name==""||strlen($name)>30){ //���ֲ���Ϊ��
		return false;
	}
	if($intro==""){ //��Ʒ���ܲ���Ϊ��
		return false;
	}
	if(!preg_match('/^\d{4}-\d{2}-\d{2}/',$time)){ //ʱ���ʽ��֤
		return false;
	}
	return true;
}
function getImageName($pic_name){
	$image = new \Think\Image(); 
	$arr=explode ('/',$pic_name);
	for($i=1;$i<5;$i++){
		$array.=$arr[$i].'/';   //��ȡ·����
	}
	$pic=substr($arr[5],0,20);//ͼƬ��
	$image->open("$array"."$pic");
	$sl_name="$array".time().rand().'.png';//����ͼ��·��
	//����һ���̶���СΪ150*150������ͼ
	$image->thumb(278, 195,\Think\Image::IMAGE_THUMB_FIXED)->save($sl_name);
	return $sl_name;
}
/*
  �ú�����������calculate�����������ݿ��ѯ������ʱ���
  ��ʽ����00:00�ĸ�ʽ������Ϊ���ݿ��ѯ������һ����¼��
  һ�������ʽ��
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
	�ĺ�����������������ʱ�����ʽ����00:00��ʽ
	����Ϊһ��ʱ���
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
	$images = new \Think\Image();  //ʵ����Image����
	/*����һ���̶���СΪ740*380������ͼ������Ϊԭ������*/
	for($j=0; $j < count($imgs); $j++){
		$images->open("$imgs[$j]");
		$images->thumb(740,380,\Think\Image::IMAGE_THUMB_FIXED)->save("$imgs[$j]");
	}	
	
	}
?>