<?php
namespace Admin\Controller;
use Think\Controller;
class BaseController extends Controller{
	
	public function _initialize(){
		$this->setting = $this->setting();
		$this->checkLogin();
		$this->cache = operation();
		$this->memory = C("memory");
		$this->point = D("Point")->read();
		$this->sort = D("sort")->where(array("pid"=>0))->select();
		$this->basemenu();
	}
	
	protected function basemenu(){
		$menu = D("menu");
		$list = $menu->where(array('used=1'))->order("`order` asc")->select();
		$this->leftmenu = $list;
	}
	
	protected function setting(){
		return D("Setting")->read();
	}
	
	
	protected function checkBoolean($data){
		if(is_array($data)){
			foreach($data as $key=>$val){
				false !== is_numeric($val) ? '' : $this->error($val);
			}
		}else{
			false !== is_numeric($data) ? '' : $this->error($data);
		}

		false !== $data ? $this->success("操作成功") : $this->error("操作失败！");
	}
	
	protected function checkLogin(){
		if(!session("sessiontime") || time() - session("sessiontime") > 1800){
			echo '<script type="text/javascript">window.parent.location.href="/";</script>';
		}else{
			D("Session")->update();
		}
	}
}