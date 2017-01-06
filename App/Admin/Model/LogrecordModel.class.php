<?php
namespace Admin\Model;
class LogrecordModel extends \Think\Model{
	
	public function read(){
		$m = D("logrecord");
		$count = $m->count();
		$page = new \Think\Page($count,15,'','_self');
		$list = $m->limit($page->firstRow.','.$page->listRows)->order("`logtime` desc")->select();
		$data = array(
			"list"	=> $list,
			"page"	=> $page->show()
		);
		return $data;
	}
	
}