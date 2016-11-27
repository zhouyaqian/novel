<?php
namespace Admin\Controller;
use Admin\Controller;
/**
 * 作品展示
 */
class DisplayController extends BaseController
{
    /**
     * 作品展示
     * @return [type] [description]
     */
    public function index($key="")
    {	
		//搜索功能
        if($key == ""){
            $model = M('display');  
        }else{
			$where['love'] = array('like',"%$key%");
			$where['name'] = array('like',"%$key%");
			$where['time'] = array('like',"%$key%");
			$where['_logic'] = 'or';
            $model = M('display')->where($where); 
        } 
        
        $count  = $model->where($where)->count();// 查询满足要求的总记录数
        $Page = new \Extend\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Page->show();// 分页显示输出
		$display=$model->limit($Page->firstRow.','.$Page->listRows)->where($where)->order('id DESC')->select();
		$this->assign('model', $display);
        $this->assign('page',$show);
		$this->display();  
    }
	/**
     * 添加作品
     */
    public function add()
    {
        //默认显示添加表单
        if (!IS_POST) {
            $this->display();
        }
        if (IS_POST) {
            //如果用户提交数据
            $model = M("display");
			$data['name']=$_POST['name'];
			$data['love']=$_POST['love'];
			$data['time']=getTime($_POST['years'],$_POST['months'],$_POST['days']);
			$data['introdaction']=$_POST['introdaction'];
			$data['pic_name']=$_POST['pic_name'];
			$data['create_time']=time();
			$data['type']=$_POST['type'];
			$data['sl_name']=getImageName($data['pic_name']);
			$flag=flag($data['name'],$data['time'],$data['introdaction']); //标志(推荐指数，名字，时间，介绍)
			if($flag==true){
				$num=$model->add($data); 
			}
			if ($num>0) {
				$this->success("添加成功", U('Display/index'));
			} else {
				$this->error("添加失败");
			}
        }	
    }
	
	//更新作品
	public function update($id){
		if(!IS_POST){
			$model=M('display')->where('id='.$id)->find();
			$arr=explode ('-',$model['time']);
			$model['year']=$arr[0];
			$model['month']=$arr[1];
			$model['day']=$arr[2];
			$this->assign('display',$model);
			$this->display();
		}
		if(IS_POST){
			$model = M("display");
			$data['name']=$_POST['name'];
			$data['love']=$_POST['love'];
			$data['time']=getTime($_POST['years'],$_POST['months'],$_POST['days']);
			$data['introdaction']=$_POST['introdaction'];
			//$pic_name=$model->where('id='.$id)->field('pic_name')->find();
			$data['pic_name']=$_POST['pic_name'];
			//if($data['pic_name']!=$pic_name){
			$data['sl_name']=getImageName($data['pic_name']);
			//}
			$data['type']=$_POST['type'];
			$data['create_time']=time();
			$flag=flag($data['name'],$data['time'],$data['introdaction']); //标志(推荐指数，名字，时间，介绍)
			if($flag==true){
				$num=$model->where('id='.$id)->save($data); 
			}
			if ($num>0) {
				$this->success("修改成功", U('Display/index'));
			} else {
				$this->error("修改失败");
			}
		
		}
	}
	
	//一条删除
	public function delete($id){
		$model=M('display');
		$display=$model->where('id='.$id)->field('sl_name,pic_name')->find();
		preg_match_all("/\/Public\/Uploads\/images\/[0-9]+\/[0-9]+\.jpg|jpeg|png|gif|bmp/",$display['pic_name'],$img,PREG_PATTERN_ORDER );
		$m=M('comment');
		$ids=$m->count('pid='.$id);
		$num = ($ids>0 ? 1: 0 ); 
		if($num){
			$num=$m->where('pid='.$id)->delete();  //删除评论
		}else{
			$num=1;//置真
		}
		if($num){
			$result=$model->where('id='.$id)->delete(); //删除作品
			if($result){
				//删除图片
				unlink('./'.$display['sl_name']);
				foreach($img['0'] as $i){
					unlink('.'.$i);
				}
				$this->success("删除成功", U('display/index'));
			}else{
				$this->error("删除失败");
			}
		}else{
			$this->error('删除失败');
		}
	}
	
	//多选删除
	public function del_getid(){
		$model=M('display');
		$m=M('comment');
		$mre=M('comment_re');
		foreach($_POST['ids'] as $i){
			$str.=$i.',';
		}
		$str=substr($str,0,strlen($str)-1);
		$data['id']=array('in',"$str");
		$where['pid']=array('in',"$str");
		$com_re=$m->where($where)->field('id')->select();
		foreach($com_re as $arr){
			foreach($arr as $j){
				$str_re.=$j.',';
			}
		}
		$str_re=substr($str_re,0,strlen($str_re)-1);
		$wh['pid']=array('in',"$str_re");
		if($_POST['dosubmit']=="删除"){
			$display=$model->where($data)->field('sl_name,pic_name')->select();
			$ids=$mre->where($wh)->count();
			$re = ($ids>0 ? 1: 0 ); 
			if($re){
				$re=$mre->where($wh)->delete(); //删除回复
			}else{
				$re=1;//置真
			}
			if($re){
				$ids=count($com_re);
				$num = ($ids>0 ? 1: 0 ); 
				if($num){
					$num=$m->where($where)->delete();  //删除评论
				}else{
					$num=1;//置真
				}
				if($num){
					$result=$model->where($data)->delete(); //删除作品
					if($result){
						//删除作品
						foreach( $display as $arr){
							foreach( $arr as $key => $i){
								if($key=='sl_name'){
									unlink('./'.$i);
								}else{
									preg_match_all("/\/Public\/Uploads\/images\/[0-9]+\/[0-9]+\.jpg|jpeg|png|gif|bmp/",$i,$img,PREG_PATTERN_ORDER );
									foreach( $img['0'] as $j){
										unlink('.'.$j);
									}
								}
							}
						}
						$this->success("删除成功", U('display/index'));
					}else{
						$this->error("删除失败");
					}
				}else{
					$this->error('删除失败');
				}
			}else{
				$this->error('删除失败');
			}
		}else{
			foreach($_POST['ids'] as $id){
				$arr=$model->where('id='.$id)->field('type')->find();
				if($arr['type']==0){
					$num=$model->where('id='.$id)->data('type=1')->save();
				}else{
					$num=$model->where('id='.$id)->data('type=0')->save();
				}
			}
			if($num>0){
				$this->success("选择成功", U('display/index'));
			}
		}
	}
	
}