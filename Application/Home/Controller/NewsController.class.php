<?php

namespace Home\Controller;
use Think\Controller;

class NewsController extends Controller{
    //显示所有新闻
	public function index(){    
		$news=M("News");
		$count=count($news->select());
		$Page = new \Extend\Page($count,4);// 实例化分页类 传入总记录数和每页显示的记录数4
		$show = $Page->show();// 分页显示输出
		$result= $news->limit($Page->firstRow.','.$Page->listRows)->order('news.id DESC')->select();
		
			for($i=0;$i<$count;$i++){
				$list[$i]['id']=$result[$i]['id'];  //取出的ID给数组list
				$list[$i]['title']=$result[$i]['title'];   //取出的title给数组list
				/*用引号分割picname字符串，得到第一张图片路径名及图片名 如(/Public/Uploads/news/201605/1462446085144027.jpg)
				 并将其赋给list数组*/
				$image=preg_split("/\"/",$result[$i]['picname']);  
				$list[$i]['picname']=$image[1]; 
				//preg_match_all("/\/Public\/Uploads\/news\/[0-9]+\/[0-9]+\.(jpg|jpeg|png|gif|bmp)/",$re['picname'],$img,PREG_PATTERN_ORDER );
				//$list['img1'] =  $img[0][0];  //$img[1]是第一张图片
				/*用htmlspecialchars_decode去掉内容的标签，如果内容较多，则取出前面一部分内容，在后面加上......
				若内容较少，则直接显示所有内容*/
				$str =strlen(htmlspecialchars_decode($result[$i]['content']));
					if($str < 501){
						$list[$i]['content']=htmlspecialchars_decode($result[$i]['content']);
						}
					else{
						$str1=htmlspecialchars_decode($result[$i]['content']);
						$st=mb_substr($str1,0,120,'utf-8');
						$list[$i]['content']=$st."......";
						}
						
				$list[$i]['time']=$result[$i]['time'];
			}
			$this->assign('list', $list);
			$this->assign('page',$show);
			$this->display(); 
		
	}
	  //点击更多时，显示此新闻标题和内容
		public function more(){           
			$id= $_GET['id'];
			$new=M('News');
			$re=$new->find($id);//根据ID找到对应的记录
			/**
			用正则匹配picname字符串，得到图片路径名及图片名（/Public/Uploads/images/201605/1462446085144027.jpg）
			 用img保存匹配出来的数组 /Public/Uploads/images/201605/1462446085144027.jpg
			*/
			preg_match_all("/\/Public\/Uploads\/images\/[0-9]+\/[0-9]+\.(jpg|jpeg|png|gif|bmp)/",$re['picname'],$img,PREG_PATTERN_ORDER );
			for($m=0;$m<5;$m++){
			$more[$m] =  $img[0][$m];  //$img[1]是第一张图片
			}
			$more['title']=$re['title'];  //将标题给list数组
			$more['content']=$re['content'];   //将内容给list数组
			
			/*more数组里面有新闻的标题($more['title'])，新闻的内容($more['content'])以及所需的
			五张轮播图($more[0到$more[4])
			*/
			$this->assign('more',$more);
			$this->display();
	}
	//空操作
	public function _empty(){        
	 echo '<script>script:history.back(-1)</script>';
	}    
	
}	
	
	
	
		
	
