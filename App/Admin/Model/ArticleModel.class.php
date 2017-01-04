<?php
namespace Admin\Model;
class ArticleModel extends \Think\Model{
	
	protected $_validate =array(
		array("title","require","标题不允许为空"),
		array('intro','require','简介不能为空'), //默认情况下用正则进行验证
		array('imgurl','require','请上传封面'), //默认情况下用正则进行验证
		array('detail','require','文章内容不能为空'), //默认情况下用正则进行验证
	);
	
	public function read(){
		$m = D("article");
		extract(I(''));
		$map = $id=='' ? array("sid"=>0) : array("sid"=>$id);
		$count = $m->where($map)->count();
		$page = new \Think\Page($count,20);
		$list = $m->where($map)->limit($page->firstRow.','.$page->listRows)->select();
		$data = array(
			"list"	=> $list,
			"page"	=> $page->show
		);
		return $data;
	}
	
	public function update($data){
		$m = D("article");
		if(!$m->create($data)){
			$up = $m->getError();
		}else{
			unset($data["__hash__"]);
			$sort = $m->where($data)->find();
			$up = empty($sort) ? $m->add($data) : $m->save($data);
		}
		return $up;
	}
}