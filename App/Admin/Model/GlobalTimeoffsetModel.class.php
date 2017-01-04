<?php
namespace Admin\Model;
class GlobalTimeoffsetModel extends \Think\Model {
	
	public function read(){
		$m = D("global_timeoffset");
		$data = $m->select();
		return $data;
	}
	
}