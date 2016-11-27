<?php
namespace Admin\Controller;
use Admin\Controller;
/**
 * 联系我们
 */
class ContactController extends BaseController
{
    /**
     * 联系列表
     * @return [type] [description]
     */
    public function index($key="")
    {
        if($key == ""){
            $model = M('contact');  
        }else{
            $where['name'] = array('like',"%$key%");
            $where['phone'] = array('like',"%$key%");
            $where['_logic'] = 'or';
            $model = M('contact')->where($where); 
        } 
        
        $count  = $model->where($where)->count();// 查询满足要求的总记录数
        $Page = new \Extend\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Page->show();// 分页显示输出
		$contact=$model->limit($Page->firstRow.','.$Page->listRows)->where($where)->order('id DESC')->select();
		$this->assign('model', $contact);
        $this->assign('page',$show);
        $this->display();  
    }
	/**
     * 查看联系信息
     * @param  [type] $id [联系ID]
     * @return [type]     [description]
     */
    public function update($id)
    {
		$model = M('contact')->where('id='.$id)->find();
		$this->assign('contact',$model);
		$this->display();
    }
	   /**
     * 删除联系
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function delete($id)
    {
        $model = M('contact');
        $result = $model->where("id=".$id)->delete();
        if($result){
            $this->success("删除成功", U('contact/index'));
        }else{
            $this->error("删除失败");
        }
    }
}