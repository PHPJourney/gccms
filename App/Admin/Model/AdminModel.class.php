<?php
namespace Admin\Model;
class AdminModel extends \Think\Model{
	
	 protected $_validate = array(
		array('pwd','require','新密码不允许为空',1), // 验证确认密码是否和密码一致
		array('pwd','repwd','确认密码不正确',0,'confirm'), // 验证确认密码是否和密码一致
	);
	
	public function read(){
		$user = D("admin")->where(array("id"=>session("uid")))->getField("pwd");
		return $user;
	}
}