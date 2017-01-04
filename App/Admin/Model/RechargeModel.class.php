<?php
namespace Admin\Model;
class RechargeModel extends \Think\Model{
	
	public function read(){
		$m =D("recharge");
		$count = $m->count();
		$page = new \Think\Page($count,20,"","_self");
		$list = $m->limit($page->firstRow.','.$page->listRows)->select();
		$recharge = array(
			"list"	=> $list,
			"page"	=> $page->show(),
		);
		return $recharge;
	}
	
	public function update($id){
		$m = D("recharge");
		$order = $m->where(array("id"=>$id))->find();
		if(empty($order)){
			$up = "订单不存在";
			$sql[] = $up;
		}else{
			if($order['status']!=0){
				$up = "当前订单状态为" . $order['status']==1 ? "已到账" : "已取消";
				$sql[] = $up;
			}else{
				$up[] = $m->where(array("id"=>$id))->setField("status",1);
				$sql[] = $m->getlastsql();
				$up[] = D("memberWallet")->where(array("uid"=>$order["uid"]))->setInc("amount",$order["amount"]);
				$sql[] = D("memberWallet")->getlastsql();
			}
		}
		$sql['remark'] = "更新订单充值状态为已到账";
		$sql['_group'] = "Admin";
		D("OperationLog")->update($sql);
		return $up;
	}
	
}