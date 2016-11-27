<?PHP
//作品展示与发表评论表关联模型
namespace Common\Model;
use Think\Model\RelationModel;

class DisplayRelationModel extends RelationModel{
	//主表名称
	protected $tableName = 'display';
	//关联关系
	protected $_link = array(        
		'comment' => array(         
			'mapping_type' => self::HAS_MANY, 
			'foreign_key' => 'uid',        
		),       
	);
	//自动删除的方法
	public function del($where=null){
		$data = is_null($where) ? $_POST : $where;
		return $this->relation(true)->where($where)->select();
	}
}