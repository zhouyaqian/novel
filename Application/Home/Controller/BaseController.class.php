<?PHP
namespace Home\Controller;
use Think\Controller;

class BaseController extends Controller{
	public function _empty($name){
		echo '<script>javescripy:history.back(-1)</script>';
	}
}