<?php

namespace Admin\Controller;
use Admin\Controller;
/**
 * 文章管理
 */
class UserController extends BaseController
{
    public function index()
    {

        $count = M('user')->count();
        $Page = new \Extend\Page($count,10);
        $limit =$Page->firstRow.','.$Page->listRows;
        $data = M('user')->order('id DESC')->limit($limit)->select();
        $this->data = $data;
        $this->page = $Page->show();
        $this->display();
    }

    public function deleAttr()
    {
        $id = $_GET['id'];
        $db = M('user');
        if ($db->where("id=$id")->delete()) {
            $this->success('删除成功',  U('user/index'));
        } else {
            $this->error('删除失败');
        }
    }

    /**
     *更新数据库
     */
    public function revise()
    {
        //默认显示添加表单
        if (!IS_POST) {
            $xye = M('user')->find(I('id'));
            $this->assign('xye', $xye);
            $this->display();
        }
        if (IS_POST) {
            $xye = D("User");
            if (!$xye->create()) {
                $this->error($xye->getError());
            } else {
                //验证密码是否为空
                $data = I();

                unset($data['password']);
                if(I('password') != ""){
                    $data['password'] = md5(I('password'));
                }

                if(M('user')->save($data)){
                    $this->success("用户信息更新成功", U('user/index'));
                }else{
                    $this->success("用户信息0成功", U('user/index'));
                    dump($data);
                }




            }
        }
    }
/*
 * 添加用户进行管理
 */
        public function add(){

            if(!IS_POST){

                $this->display();
            }
            if(IS_POST){
                $xye = M('user');
				if(I('password')==I('notpassword')){
					$data['username'] = I('username');
					$data['email'] = I('email');
					$da = I('email');
					$data['type'] = I('type');
					$data['password'] = md5(I('password'));
					$data['active']=1;
					$Count = $xye->where("email='%s'",$da)->count();
					if($Count==1){
						$this->error('邮箱已被注册');
					}else if($xye->add($data)){

						$this->success('用户添加成功',U('user/index'));

					}else{

                    $this->error('用户添加失败');
					}

                }else{

                    $this->error('用户添加失败');

				}
            }
        }
}