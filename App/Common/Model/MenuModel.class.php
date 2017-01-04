<?php
namespace Common\Model;
class MenuModel extends \Think\Model{
	
	public function update($data,$map=array()){
		$m = D("menu");
		if(!$m->create($data)){
			$up = $m->getError();
		}else{
			unset($data['__hash__']);
			if($data["_all"]){
				unset($data["_all"]);
				foreach($data as $key=>$val){
					$result = explode(":",$val);
					$up = $m->where(array("id"=>$result[0]))->setField("order",$result[1]);
					$sql[]	= $m->getlastsql();
				}
			}else{
				$menu = empty($map) ? $m->where($data)->find() : $m->where($map)->find();
				$up = empty($menu) ? $m->add($data) : $m->where($map)->save($data);
				$sql[]	= $m->getlastsql();
			}
			$sql['remark'] = "更新网站菜单排序";
			$sql['_group'] = "Admin";
		}
			D("OperationLog")->update($sql);
		return $up;
	}
	
	public function read($id=''){
		$m = D("menu");
		$menu = $m->where(array("id"=>$id))->find();
		return $menu;
	}
	
	public function remove($id){
		$m = D("Menu");
		$up = $m->delete($id);
		return $up;
	}
	
}