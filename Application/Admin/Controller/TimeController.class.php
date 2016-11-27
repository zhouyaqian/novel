<?php
namespace Admin\Controller;
use Admin\Controller;
/**
 * 时间管理
 */
class TimeController extends BaseController
{
    /**
     * 时间列表
     * @return [type] [description]
     */
    public function index($key="")
    {
        if($key == ""){
            $model = M('time');  
        }else{
            
            $where['username'] = array('like',"%$key%");
           // $where['_logic'] = 'or';
            $model = M('time')->where($where); 
        } 
        $count = $model->where($where)->count();	// 查询满足条件的总记录数
		$Page = new \Extend\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show = $Page->show();		//分页显示输出
        $time = $model->limit($Page->firstRow.','.$Page->listRows)->where($where)->order('id ASC')->select();
        //$ass_time = assemble($time);
		//dump($time);
		//dump($ass_time);
		$length = count($time);
		for($i = 0; $i < $length; $i++){
			$ass_time[] = assemble($time[$i]);
		}
		$this->assign('model',$ass_time);
		$this->assign('page',$show);
        $this->display();   
    }

   
    /**
     * 删除时间
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function delete($id)
    {
        $model = M('time');
        
        $result = $model->delete($id);
        if($result){
            $this->success("删除成功", U('time/index'));
        }else{
            $this->error("删除失败");
        }
    }
}
