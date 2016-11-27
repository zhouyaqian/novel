<?php

namespace Home\Controller;

use Think\Controller;
//��Ʒչʾ
class DisplayController extends BaseController{
	//��ʾ��ҳ�����Ʒ
    public function index(){
		$model=M('display');
		$count  = $model->count();
		$Page = new \Extend\Page($count,2);// ʵ������ҳ�� �����ܼ�¼����ÿҳ��ʾ�ļ�¼��(25)
        $show = $Page->show();// ��ҳ��ʾ���
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
	//��ʾ��ϸ��Ʒҳ��
	public function comment(){
		$m=M('display');
		$display=$m->where('id='.$_GET['id'])->field('pic_name,love,introdaction')->find();
		$search =array('<p>','</p>');
		$display['pic_name']=str_replace($search,'',$display['pic_name']);//ȥ��p��ǩ
		$this->assign('display',$display); //��ʾ��ϸ��ƷͼƬ
		$this->assign('id',$_GET['id']);//��ʾ��ǰ��Ʒҳ��id
		$model=M('comment');
		$where['pid']=$_GET['id'];
		$count  = $model->where($where)->count();//��ʾ����Ʒ������
		$Page = new \Extend\Page($count,4);// ʵ������ҳ�ഫ���ܼ�¼����ÿҳ��ʾ�ļ�¼��
        $show = $Page->show();// ��ҳ��ʾ���
		$comments = $model
				 ->alias('c')
				 ->join('LEFT JOIN comment_re r on c.id=r.pid')
				 ->field('c.*,r.time as time_re,r.content as content_re')
				 ->order('id DESC')
				 ->where('c.pid='.$_GET['id'])
				 ->select()	; //������Ӳ�ѯ
		$comment = $model->limit($Page->firstRow.','.$Page->listRows)->where($where)->order('id DESC')->select();//���۱��ѯ
		$number=count($comment); //���۱��ѯ��Ŀ
		$num=count($comments);//������Ӳ�ѯ��Ŀ
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
		$this->assign('comment',$comment);	//��ʾ������Ʒ����������
		$this->assign('page',$show);
		$this->display();
	}
	
	//�������
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
	//�ظ�����
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

	//�����Ƽ�ָ��
	public function putLove(){
		$data['id']=$_GET['id'];
		$flag=$_GET['al'];//���õ����־,ͨ��ajax����
		if($flag==1){
			$model=M('display');
			$love=$model->where($data)->field('love')->find();
			$love['love']++;//����
			$data['love']=$love['love'];
			$a = $model->save($data);
			echo $a;
		}
	}
	//���»ظ�����
	public function getLove(){
		$data['id']=$_GET['id'];
		$flag=$_GET['al'];//���õ����־
		if($flag==1){
			$model=M('comment');
			$love=$model->where($data)->field('love')->find();
			$love['love']++;//����
			$data['love']=$love['love'];
			$a = $model->save($data);
			echo $a;
		}
	}
	
}
