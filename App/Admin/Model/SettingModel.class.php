<?php
namespace Admin\Model;
class SettingModel extends \Think\Model{
	
	public function update($data){
		$set = D("setting");
		$set->startTrans();
		$aData = array();
		$sqlcate = $data["_sql"];
		unset($data["_sql"]);
		foreach($data as $key=>$val){
			$sData = array(
				"field"	=> $key,
				"val"	=> is_array($val) ? implode(",",$val) : $val
			);
			$up = $set->save($sData);
			$sql[] = $set->getlastsql();
			$exists = $set->where(array("field"=>$key))->find();
			if($up==0 && empty($exists)){
				$aData[] = $sData;
			}
		}
		if(false !== C("TOKEN_ON")){
			$set->autoCheckToken($_POST);
		}
		if(!empty($aData)){
			$up[] = $set->addAll($aData);
			$sql[] = $set->getlastsql();
		}
		$sql['remark'] = "更新网站配置表 ($sqlcate)";
		$sql['_group'] = "Admin";
		$up[] = D("OperationLog")->update($sql);
		false !== $up ? $set->commit() : $set->rollback();
		return $up;
	}
	
	public function read($id=''){
		$m = D("setting");
		$config = $id=="" ? $m->select() : $m->where(array("id"=>$id))->find();
		foreach($config as $key=>$val){
			$data[$val['field']] = $val['val'];
		}
		return $data;
	}
}