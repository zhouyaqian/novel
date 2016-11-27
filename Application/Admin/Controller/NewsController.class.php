<?php
namespace Admin\Controller;
use Admin\Controller;
/**
 * 新闻动态
 */
class NewsController extends BaseController{
	public function index($key="")   //显示总的记录数，并查询新闻，实现分页功能
    {   
		if($key == ""){   //没有查询，显示总的记录数
			$new=M('News');
			$count  = count($new->select());// 查询满足要求的总记录数
			$Page = new \Extend\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数(15)
			$show = $Page->show();// 分页显示输出
			$result = $new->limit($Page->firstRow.','.$Page->listRows)->order('news.id DESC')->select();
			$this->assign('result', $result);
			$this->assign('page',$show);
			$this->display();     
		}else{  //
			$new=M('News');
			$where['title'] = array('like',"%$key%");
			
			$count  = count($new->where($where)->select());// 查询满足要求的总记录数
			$Page = new \Extend\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数(15)
			$show = $Page->show();// 分页显示输出
			$result = $new->limit($Page->firstRow.','.$Page->listRows)->where($where)->order('news.id DESC')->select();
			$this->assign('result', $result);
			$this->assign('page',$show);
			$this->display(); 
			
		}
    }        
	/*
     * 添加新闻
     */
    public function add()             
    {
        if (!IS_POST) {   
            $this->display();
        }
        if (IS_POST) {
			$model = M("News");
			
			/**
			调用函数 用引号分割picname字符串，得到图片路径名及图片名（/Public/Uploads/news/201605/1462446085144027.jpg）
			 用img保存分割后的数组 /Public/Uploads/news/201605/1462446085144027.jpg
			*/
			deal_images($_POST['picname']);
			
			$model->picname=$_POST['picname']; 
            $model->title=$_POST['title'];
			$model->content=$_POST['content'];
			$model->time=time();
			
			if ($model->add()) {
                  $this->success("添加成功", U('news/index'));
              } else {
                  $this->error("添加失败");
              }
         }
    }
			
		
             
		
		
			
    /**
     * 点击编辑时更新新闻内容
     */
    public function update($id)
    {
       if (!IS_POST) {
            $model = M('news')->where('id='.$id)->find();
            $this->assign('post',$model);
            $this->display();
        }
        if (IS_POST) {
			$model = D('news');
			$model->id=$_POST['id'];
			/**
			调用函数用引号分割picname字符串，得到图片路径名及图片名（/Public/Uploads/news/201605/1462446085144027.jpg）
			 用img保存分割后的数组 /Public/Uploads/news/201605/1462446085144027.jpg
			*/
			deal_images($_POST['picname']);
			$model->picname=$_POST['picname'];
			$model->title=$_POST['title'];										
			$model->content=$_POST['content'];
			if ($model->save()) {
                  $this->success("更新成功", U('news/index'));
			} else {
                  $this->error("更新失败");
            }        
		}
    }
		   
    //删除新闻  
     public function delete($id)
    {
        $model = M('news');
        $result = $model->delete($id);
        if($result){
            $this->success("新闻删除成功", U('news/index'));
        }else{
			$this->error("新闻删除失败");
        }
    }
	
	
     
    
}


	
	