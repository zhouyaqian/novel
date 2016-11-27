<?php
namespace Admin\Model;
use Think\Model;
class NewsModel extends Model{
    protected $_validate = array(
        array('title','require','请填写文章标题！'), //默认情况下用正则进行验证
    );
    protected $_auto = array ( 
        array('time','time',1,'function'),  // 对time字段在增加新闻的时候写入当前时间戳
		
	);	
	
	
		
		
		
		
	
        
    
    
}