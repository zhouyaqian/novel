<?php

namespace Home\Controller;

use Think\Controller;

class RegisterController extends BaseController
{
    public function register()
    {

        $this->display();
    }
	
		
    public function code()
    {
        //判断是否存在表单
        if(!IS_POST){
			echo'你输入有误';
        }
        if(IS_POST){
			$model = M('user');
			$data['username'] = I('username');
            $da = I('email');
			$data['email']= I('email');
            $data['password'] = md5(I('password'));
			
			//判断emil是否被注册过
			$Count = $model->where("email='%s'",$da)->count();
			
			if($Count==1){
					echo "此邮箱被注册过了！";
				
				}else{
						//判断密码是否为空
						if(I('password')!=""){
							$data['password']=md5(I('password'));
						}
						//写入唯一标识符
						$data['active'] = '1';
						$a = I('email');
						//写入数据库

						if($model->add($data)){
							$this->success('注册成功，请进行验证',SendMail("975289275@qq.com",'欢迎注册网站',"http://localhost/cnsecer-ThinkAdmin-master/ThinkAdmin/index.php?m=&c=Register&a=codeevent&tg_active=$a"));
						}else{
							$this->error('注册失败','Register/register');
						}

			}
            
        }
    }
    //邮箱验证
    public function codeevent ()
	{
					
					$db = M('user');
					$email = $_GET['tg_active'];//获取到唯一标识符的邮箱
					$data['active']='0';
					
				if ($db->where("  email='%s' ",$email)->save($data)) {
					
					$this->success('验证成功，请进行登录',U('login/login'));
					
					}else{
						$this->error('发送失败');
					}
				
	}
}

?>