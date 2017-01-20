<?php
namespace Common\Model;
class OperationLogModel extends \Think\Model{
	
	public function update($sql){
		$group = $sql['_group'];
		$remark = $sql['remark'];
		unset($sql['remark']);
		unset($sql['_group']);
		$data = array(
			"uid"	=> session("uid"),
			"nick"	=> session("uname"),
			"cate"	=> $group,
			"sql"	=> serialize($sql),
			"remark"=> $remark,
		);
		$up = D('OperationLog')->add($data);
		return $up;
	}	
	
	public function read(){
		$m = D("operationLog");
		$count = $m->count();
		$page = new \Think\Page($count,20,'','_self');
		$list = $m->limit($page->firstRow.','.$page->listRows)->order("id desc")->select();
		$data = array(
			"list"	=> $list,
			"page"	=> $page->show()
		);
		return $data;
	}
}