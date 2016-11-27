<?php

namespace Home\Controller;

use Think\Controller;
//首页
class IndexController extends BaseController{
	//显示主页面的作品
    public function index(){
		$model=M('display');
		$display=$model
			->alias('d')
			->join('LEFT JOIN (select pid,count(*) as comnum from comment group by pid) c on c.pid = d.id')
			->field('d.*,c.comnum')
			->where('type=1')
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
	
}
