<?PHP
namespace Home\Controller;
use Think\Controller;
//联系我们
class ContactController extends BaseController{
	//显示页面
	public function index(){
		$this->display();
	}
	//处理提交表单
	public function contact(){
		$data['name']=$_POST['name'];
		$data['phone']=$_POST['phone'];
		$data['content']=$_POST['content'];
		$flag=true;
		$sub=0;
		//验证名字格式与意见
		if($data['name']==""||strlen($data['name'])<2||strlen($data['name'])>8||$data['content']==""){
			$flag=false;
		}
		//验证手机号码格式
		if(!preg_match('/^(13[0-9]|14[0-9]|15[0-9]|18[0-9])\d{8}$/',$data['phone'])){
			$flag=false;
		}
		//标志为真则创建数据
		if($flag==true){
			$num=M('contact')->add($data);
		}
		if($num>0){
			$this->redirect('Contact/index');
		}else{
			$this->error('提交失败',index);
		}
		
	}
	
}