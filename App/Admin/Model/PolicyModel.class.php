<?php
namespace Admin\Model;
class PolicyModel extends \Think\Model{
	
	public function update($data){
		$set = D("policy");
		$set->startTrans();
		$sqlcate = $data['_sql'];
		unset($data["_sql"]);
		if(isset($data['_type']) && $data['_type']==0){
			unset($data['_type']);
			$up = $set->where(array("variable"=>$data['variable']))->save($data);
			$sql[] = $set->getlastsql();
			$exists = $set->where(array("variable"=>$data['variable']))->find();
			if($up==0 && empty($exists)){
				$sData[] = $data;
			}
		}else{
			$aData = array();
			$arrkey = array_keys($data);
			for($i=0;$i<count($data[$arrkey[0]]);$i++){
				foreach($arrkey as $key=>$val){
					$aData[$val] = $data[$val][$i];
				}
				$up = $set->save($aData);
				$sql[] = $set->getlastsql();
				$exists = $set->where(array("variable"=>$aData['variable']))->find();
				if($up==0 && empty($exists)){
					$sData[] = $aData;
				}
			}
		}
		if(false !== C("TOKEN_ON")){
			$set->autoCheckToken($_POST);
		}
		if(!empty($sData)){
			$up[] = $set->addAll($sData);
			$sql[] = $set->getlastsql();
		}
		$sql['remark'] = "更新网站积分策略表 ($sqlcate)";
		$sql['_group'] = "Admin";
		$up[] = D("OperationLog")->update($sql);
		false !== $up ? $set->commit() : $set->rollback();
		return $up;
	}
	
	public function read($id=''){
		$m = D("policy");
		$data = $id=="" ? $m->select() : $m->where(array("id"=>$id))->find();
		return $data;
	}
	
	public function remove($prikey){
		$m = D("policy");
		$data = $m->where(array("variable"=>$prikey))->delete();
		$sql[] = $m->getlastsql();
		$sql['remark'] = "删除积分类型";
		$sql['_group'] = "Admin";
		$up[] = D("OperationLog")->update($sql);
		return $data;
	}
}