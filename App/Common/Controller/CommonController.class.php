<?php
namespace Common\Controller;
class CommonController extends \Think\Controller{
	
	public function _initialize(){
		$this->setting = $this->setting();
	}

	protected function setting(){
		return D("Setting")->read();
	}
}