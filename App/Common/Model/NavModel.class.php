<?php
namespace Common\Model;
class NavModel extends \Think\Model{
	
	public function read(){
		$m = D("nav");
		$nav["home"]	= $m->where(array("cate"=>"home"))->select();
		$nav["top"]		= $m->where(array("cate"=>"top"))->select();
		$nav["footer"]	= $m->where(array("cate"=>"footer"))->select();
		$nav["quick"]	= $m->where(array("cate"=>"quick"))->select();
		return $nav;
	}
	
	public function update($data){
		if(!$data["level"]){
			$id = array_keys($data['order']);
			
		}
	}
	
}