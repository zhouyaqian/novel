<?php

namespace Home\Controller;

use Think\Controller;

//登录
class UserController extends BaseController{
	public function index(){
		//$this->display(U('User/login'));
	}
	
	//验证登录
	function login(){
		$flag = 0;		//用来验证用户名或密码是否正确的标志
		$mail = 0;		//用来验证用户邮箱是否激活
		if($_POST && $_POST!=''){
			$data['username']=$_POST['name'];//I('post.name');	
			$data['password']=md5($_POST['phone']);//I('post.phone');
			$data['_logic'] = 'and';
			//$user = M('user')->where($data)->select();
			$user = M('User');
			$count = $user->where($data)->find(); 	//根据用户提交过来的数据条件查询数据库
			
			if($count){		//如果数据库存在，将有用信息记录到session中
				if($count['active'] == 1){	//验证用户是否已经激活
					$_SESSION['username'] = $count['username'];
					$_SESSION['userid'] = $count['id'];
					$_SESSION['usertype'] = $count['type'];
					$this->redirect('Time/index');		//登录成功跳转到签到页面
				}else{
					$mail = -1;
				}
			}else{
				$flag = -1;		//用户名或密码错误的标志
			}
		}
		$this->assign('flag',$flag);
		$this->assign('mail',$mail);
		$this->display();
	}
	
	//退出登录
	public function logout(){
		session('userid',null);
		session('username',null);
		session('usertype',null);
		//$this-success('退出登录成功！');
		$this->redirect('User/login');
	}

}
