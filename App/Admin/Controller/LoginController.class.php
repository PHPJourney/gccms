<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller{
	
	public function index(){
		if(IS_POST){
			extract(I(''));
			$name == '' ? $this->error("请输入用户名") : '';
			$password == '' ? $this->error("请输入登录密码") : '';
			$code == '' ? $this->error("请填写验证码") : '';
			$this->check($code) ? '' : $this->error("验证码不正确，请重新填写");
			$user = D("admin")->where(array("user"=>$name))->find();
			if(empty($user)){
				$this->error("用户名不存在");
			}
			md5($password) != $user['pwd'] ? $this->error("密码不正确，请重新填写") : '';
			$dynamic != $user['secauth'] && $user['secrand']!='' ? $this->error("动态验证码不正确，请重试") : '';
			session("token",$user);
			session("uid",$user["id"]);
			session("uname",$user["user"]);
			session("sessiontime",time());
			D("Session")->write($user['id']);
			$this->success("登录成功！",U("Cpanel/index"));
		}
	}
	
	public function check($code,$id=''){
		$verify = new \Think\Verify();
		return $verify->check($code, $id);
	}
	
}