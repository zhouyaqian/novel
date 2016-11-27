<?php
	
	namespace Home\Controller;
	use Think\Controller;
	
	
	/*
	
		通过获取时间戳来实现签到
	
	*/
	class TimeController extends BaseController{
		
		//显示时间页面
		public function index(){
			$time = M('time');  
			$where['username'] = $_SESSION['username'];
			$count = $time->where($where)->find();
			if($count['week'] < date('W')){	//通过当前是第几周与数据库的周数判断记录是否过期，是则删除
				$time->where($where)->delete();
				$count = $time->where($where)->find();	//从数据库中重新查询当前数据
			}
			
			//dump($count);
			$ass_count = assemble($count);//将时间组装成格式化的字符串，函数在common/function.php
			//dump($ass_count);
			$this->assign('time',$ass_count);
			$this->display();
		}
		//echo $ip;
		//开始时间
		public function begin(){
			
			if($_POST && $_POST!=''){
				//$ip = get_client_ip();
				//$ip =gethostbyname($url); 
				//$Ip=$_SERVER["REMOTE_ADDR"];
				//$ip = '223.150.148.55';
				//dump($_SESSION);
				$usertype = $_SESSION['usertype'];
				
				//$preg = '/192\.168\.0\.\d{1,3}/';
				$username = $_SESSION['username'];
				
				//echo $ip;
				if($usertype != 1){	//	判断用户是否为管理员
					echo '您没有该权限！';
					
				}/*else if($_SERVER["REMOTE_ADDR"] != $ip){
					echo '您的ip地址不符合要求';
				}*/else{
				
					$time = M('time');
					$where['username'] = $username;
					$count = $time->where($where)->find();   //从数据库中查询当前用户
					if($count){	//判断用户是否已经存在于数据库中
						if($count['beg_time']!=0){
							echo '您今天已签到';
							
						}else{
							$count['beg_time'] = time();
							$time->where($where)->save($count);	//更新用户时间
							echo '签到成功';
							
						}
					}else{
						$data['username'] = $username;
						$data['week'] = date('W');
						$data['beg_time'] = time();
						$time->add($data);		//将用户信息添加到数据库中
						echo '签到成功';
						
					}	
				} 
			}
		}
		//离开时间，并将时间写入数据库
		public function leave(){
			if($_POST && $_POST!=''){
				//$ip= get_client_ip();
				
				$usertype = $_SESSION['usertype'];
				$preg = '/192\.168\.0\.\d{1,3}/';
				$username = $_SESSION['username'];
				if($usertype != 1){	//	判断用户是否为管理员
					echo '您没有该权限';
				}/*else if($_SERVER["REMOTE_ADDR"] != $ip){
					echo '您的IP地址不符合要求';
				}*/else{
					$time = M('time');
					$where['username'] = $username;
					$count = $time->where($where)->find();
					if(!$count || $count['beg_time'] ==0){	//判断用户是否已经点过签到按钮
						echo '您今天还没有签到';
					}else{
						
						$total = time() - $count['beg_time'];	//计算时间戳的差值
						switch(date('w')){	//判断今天为星期几，将数据写到对应的数据库字段中
							case 0:{
								$count['sunday'] += $total;
								break;
							}
							case 1:{
								$count['monday'] += $total;
								break;
							}
							case 2:{
								
								$count['tuesday'] += $total;
								break;
							}
							case 3:{
								$count['wednesday'] += $total;
								break;
							}
							case 4:{
								$count['thursday'] += $total;
								break;
							}
							case 5:{
								$count['friday'] += $total;
								break;
							}
							case 6:{
								$count['saturday'] += $total;
								break;
							}
							default:{
							
							}
						}
						$where['username'] = $username;
						//$count['total']+=$total;
						$count['beg_time'] = 0;		//将签到按钮开始的时间重新置为0
						$time->where($where)->save($count);	//更新用户时间
						echo '离开成功';
					}
				}
			}
		}
		
	}