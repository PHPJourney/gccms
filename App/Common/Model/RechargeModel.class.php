<?php
namespace Common\Model;
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
				$up = $order['status']==1 ? "当前订单状态为已到账" : "当前订单状态为已取消";
				$sql[] = $up;
			}else{
				$data = array(
					"mer_no"	=> 1,
					"status"	=> 1
				);
				$up[] = $m->where(array("id"=>$id))->save($data);
				$sql[] = $m->getlastsql();
				$setting = D("Setting")->read();
				$map = array("uid"=>$order["uid"],"coin"=>$setting['pointcreditstrans']);
				$wallet = D("memberWallet")->where($map)->find();
				if(empty($wallet)){
					$newdata = array(
						"uid"	=> $order['uid'],
						"amount"=> $order['amount'],
						"coin"	=> $setting['pointcreditstrans']
					);
					$up[] = D("memberWallet")->add($newdata);
				}else{
					$up[] = D("memberWallet")->where($map)->setInc("amount",$order["amount"]);
				}
				$sql[] = D("memberWallet")->getlastsql();
			}
		}
		$sql['remark'] = "更新订单充值状态为已到账";
		$sql['_group'] = "Admin";
		D("OperationLog")->update($sql);
		return $up;
	}
	
}