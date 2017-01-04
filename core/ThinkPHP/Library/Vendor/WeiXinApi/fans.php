<?php
/*
 +-------------------------------------------
 | 粉丝消息
 | @Author journey<admin@libaoka.com>
 | @Date 11:08 2015-10-24
 +-------------------------------------------
 */
 /*
 +----------------------------------
 | 粉丝关注建档
 | @Author journey<admin@libaoka.com>
 | @Date 11:14 2015-9-28
 +----------------------------------
 */
	function addfans($openid,$wxid){
		
		$m = D("public_account_follow");
		
		$fans = $m->where('openid like "'.$openid.'" AND wxid="'.$wxid.'"')->find();
		
		if(empty($fans)){ //判断没有粉丝记录
			
			$access_token = getToken($wxid);
			
			$url = USERINFOAPI.$access_token."&openid=$openid&lang=zh_CN";
			
			$result = getcurl($url);
			
			$getresult = json_decode($result,true);
			
			foreach($getresult as $key=>$val){
				
				if($key != 'subscribe'){
					
					$data[$key] = $val;
					
				}
				
			}
			
			$data['wxid'] = $wxid;
				
			if($getresult['subscribe'] ==1){ //判断已关注	
			
				$data['subscribe'] = 1;
				
				$data['last_time']	= time();
				
				$m->add($data);
				
			}
			
			logResult("Info:".debugBacktrace()."接口地址：$url ， 返回参数：$result , 插入记录 {$m->getlastsql()}");
			
		}else{
			
			if($fans['subscribe']==0){
			
				$update = $m->where('openid like "'.$openid.'" AND wxid="'.$wxid.'"')->setField('subscribe',1);
				
				logResult("Info:".debugBacktrace()."更新关注状态！");
			
			}
			
		}
		
	}
/*
 +----------------------------------
 | 粉丝关注消档
 | @Author journey<admin@libaoka.com>
 | @Date 11:14 2015-9-28
 +----------------------------------
 */
	function delfans($openid,$wxid){
		
		$m = D("public_account_follow");
		
		$fans = $m->where('openid like "'.$openid.'" AND wxid="'.$wxid.'"')->setField('subscribe',0);
		
		logResult("Info:".debugBacktrace()."销毁记录 {$m->getlastsql()}，去掉粉丝关注状态。");
		
	}
