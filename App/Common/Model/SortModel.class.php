<?php
namespace Common\Model;
class SortModel extends \Think\Model{
	
	public function read(){
		$m = D("sort");
		extract(I(''));
		$map = $id=='' ? array("pid"=>0) : array("pid"=>$id);
		if($id!=''){
			$count = $m->where($map)->count();
			$page = new \Think\Page($count,20,'',"_self");
			$list = $m->where($map)->limit($page->firstRow.','.$page->listRows)->select();
			$data = array(
				"list"	=> $list,
				"page"	=> $page->show
			);
		}else{
			$list = $m->where($map)->select();
			$data['list'] = $list;
			$data['page'] = '';
		}
		return $data;
	}
	
	public function update($data,$map=array()){
		$m = D("sort");
		if(!$m->create($data)){
			$up = $m->getError();
		}else{
			unset($data['__hash__']);
			$sort = empty($map) ? $m->where($data)->find() : $m->where($map)->find();
			$up = empty($sort) ? $m->add($data) : $m->save($data);
			$sql[]	= $m->getlastsql();
			$sql['remark'] = "更新网站分类";
			$sql['_group'] = "Admin";
			$up[] = D("OperationLog")->update($sql);
		}
		return $up;
	}
	
}