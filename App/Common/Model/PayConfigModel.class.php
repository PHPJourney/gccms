<?php
namespace Common\Model;
class PayConfigModel extends \Think\Model{
	
	public function read(){
		$m = D("payConfig");
		$count = $m->count();
		$page = new \Think\Page($count,20,'','_self');
		$list = $m->limit($page->firstRow.','.$page->listRows)->select();
		$pay = array(
			"list"	=> $list,
			"page"	=> $page->show()
		);
		return $pay;
	}
	
	public function remove($id){
		$m = D("payConfig");
		$config = $m->where(array("id"=>$id))->find();
		if(empty($config)){
			$up = "充值类型不存在";
			$sql[] = $up;
		}else{
			$up[] = $m->delete($id);
			$up[] = D("setting")->where(array("field"=>array("like","%".$config['tags']."%")))->delete();
			$sql[] = $m->getlastsql();
			$sql[] = D("setting")->getlastsql();
		}
		$sql['remark'] = "删除充值类型";
		$sql['_group'] = "Admin";
		D("OperationLog")->update($sql);
		return $up;
	}
	
	public function update($data,$map=array()){
		$m = D("payConfig");
		if(!$m->create($data)){
			$up = $m->getError();
		}else{
			unset($data['__hash__']);
			$sort = empty($map) ? $m->where($data)->find() : $m->where($map)->find();
			if($data['_type']=='add' && !empty($sort)){
				$up = "渠道标识已存在";
				$sql[] = $up;
			}else{
				unset($data['_type']);
				$up = empty($sort) ? $m->add($data) : $m->save($data);
				$sql[]	= $m->getlastsql();
			}
		}
			$sql['remark'] = "更新充值类型";
			$sql['_group'] = "Admin";
			D("OperationLog")->update($sql);
		return $up;
	}
}