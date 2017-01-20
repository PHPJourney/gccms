<?php
namespace Common\Model;
class SessionModel extends \Think\Model{
	
	public function update(){
		session("sessiontime",time());
		D("session")->where(array("uid"=>session("uid")))->setField("time",session("sessiontime"));
		$sql[] = D('session')->getlastsql();
		$sql['remark'] = "用户登录缓存记录更新";
		$sql['_group'] = "Admin";
		$up[] = D("OperationLog")->update($sql);
	}
	
	public function write($uid){
		$data = array(
			"uid"	=> $uid,
			"time"	=> time(),
			"ip"	=> get_client_ip(),
		);
		D("session")->add($data);
		$sql[] = D('session')->getlastsql();
		$sql['remark'] = "用户登录缓存记录添加";
		$sql['_group'] = "Admin";
		$up[] = D("OperationLog")->update($sql);
	}
	
}