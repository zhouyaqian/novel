<?PHP
//��Ʒչʾ�뷢�����۱����ģ��
namespace Common\Model;
use Think\Model\RelationModel;

class DisplayRelationModel extends RelationModel{
	//��������
	protected $tableName = 'display';
	//������ϵ
	protected $_link = array(        
		'comment' => array(         
			'mapping_type' => self::HAS_MANY, 
			'foreign_key' => 'uid',        
		),       
	);
	//�Զ�ɾ���ķ���
	public function del($where=null){
		$data = is_null($where) ? $_POST : $where;
		return $this->relation(true)->where($where)->select();
	}
}