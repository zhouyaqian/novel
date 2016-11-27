<?php

namespace Home\Controller;

use Think\Controller;
//作品展示
class DisplayController extends BaseController{
	//显示主页面的作品
    public function index(){
		$model=M('display');
		$count  = $model->count();
		$Page = new \Extend\Page($count,2);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Page->show();// 分页显示输出
		$display = $model
				 ->alias('d')
				 ->join('LEFT JOIN (select pid,count(*) as comnum from comment group by pid) c on c.pid=d.id')
				 ->field('d.*,c.comnum')
				 ->limit($Page->firstRow.','.$Page->listRows)->order('id DESC')
				 ->select();
		for($i=0;$i<count($display);$i++){
			if(empty($display[$i]['comnum'])){
				$display[$i]['comnum']=0;
			}
		}
		$this->assign('list',$display);
		$this->assign('page',$show);
        $this->display();
    }
	//显示详细作品页面
	public function comment(){
		$m=M('display');
		$display=$m->where('id='.$_GET['id'])->field('pic_name,love,introdaction')->find();
		$search =array('<p>','</p>');
		$display['pic_name']=str_replace($search,'',$display['pic_name']);//去掉p标签
		$this->assign('display',$display); //显示详细作品图片
		$this->assign('id',$_GET['id']);//显示当前作品页面id
		$model=M('comment');
		$where['pid']=$_GET['id'];
		$count  = $model->where($where)->count();//显示各作品的评论
		$Page = new \Extend\Page($count,4);// 实例化分页类传入总记录数和每页显示的记录数
        $show = $Page->show();// 分页显示输出
		$comments = $model
				 ->alias('c')
				 ->join('LEFT JOIN comment_re r on c.id=r.pid')
				 ->field('c.*,r.time as time_re,r.content as content_re')
				 ->order('id DESC')
				 ->where('c.pid='.$_GET['id'])
				 ->select()	; //多表连接查询
		$comment = $model->limit($Page->firstRow.','.$Page->listRows)->where($where)->order('id DESC')->select();//评论表查询
		$number=count($comment); //评论表查询数目
		$num=count($comments);//多表连接查询数目
		for( $i=0;$i<$number;$i++ ){
			$a=0;
			for( $j=0;$j<$num;$j++ ){
				if( $comment[$i]['id'] == $comments[$j]['id'] && !empty($comments[$j]['content_re']) ){
					$comment[$i][$a]['time_re']=$comments[$j]['time_re'];
					$comment[$i][$a]['content_re']=$comments[$j]['content_re'];
					$a++;
				}
			}
		}
		$this->assign('comment',$comment);	//显示各自作品的评价内容
		$this->assign('page',$show);
		$this->display();
	}
	
	//添加评论
	public function addcomment(){
		$data['content']=$_POST['content'];
		$data['pid']=$_POST['id'];
		$data['time']=time();
		$model=M('comment');
		if(!empty($data['content'])){
			$num=$model->add($data);
			$arr=$model->where("id=".$num)->find();
			echo json_encode($arr);
		}
		
	}
	//回复评论
	public function commentre(){
		$data['content']=$_POST['content'];
		$data['pid']=$_POST['id'];
		$data['time']=time();
		$model=M('comment_re');
		if(!empty($data['content'])){
			$num=$model->add($data);
			$arr=$model->where("id=".$num)->find();
			echo json_encode($arr);
		}
	}

	//更新推荐指数
	public function putLove(){
		$data['id']=$_GET['id'];
		$flag=$_GET['al'];//设置点击标志,通过ajax返回
		if($flag==1){
			$model=M('display');
			$love=$model->where($data)->field('love')->find();
			$love['love']++;//自增
			$data['love']=$love['love'];
			$a = $model->save($data);
			echo $a;
		}
	}
	//更新回复点赞
	public function getLove(){
		$data['id']=$_GET['id'];
		$flag=$_GET['al'];//设置点击标志
		if($flag==1){
			$model=M('comment');
			$love=$model->where($data)->field('love')->find();
			$love['love']++;//自增
			$data['love']=$love['love'];
			$a = $model->save($data);
			echo $a;
		}
	}
	
}
