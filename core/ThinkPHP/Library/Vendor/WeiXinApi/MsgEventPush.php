<?php
/*
 +-------------------------------------------
 | 事件消息推送
 | @Author journey<admin@libaoka.com>
 | @Date 11:08 2015-10-24
 +-------------------------------------------
 */
 	function MsgEventPush($msg,$pc){
		
		$xml = new \DOMDocument();
			
		$xml->loadXML($msg);
		
		$array_event = $xml->getElementsByTagName('Event');
		
		$event = $array_event->item(0)->nodeValue;//事件类型
		
		$array_eventKey = $xml->getElementsByTagName('EventKey');
		
		$eventKey = $array_eventKey->item(0)->nodeValue;//事件key值，32位二维码场景id
		
		$array_ticket = $xml->getElementsByTagName("Ticket");
		
		$ticket = $array_ticket->item(0)->nodeValue;//二维码的ticket
		
		$array_addtime = $xml->getElementsByTagName('CreateTime');
		
		$addtime = $array_addtime->item(0)->nodeValue;//创建时间
		
		$array_fromuser = $xml->getElementsByTagName("FromUserName");
		
		$fromuser = $array_fromuser->item(0)->nodeValue;//发送方账号
		
		$array_touser = $xml->getElementsByTagName("ToUserName");
		
		$touser = $array_touser->item(0)->nodeValue;//开发者微信号
			
		$array_Latitude = $xml->getElementsByTagName("Latitude");//纬度
		
		$Latitude = $array_Latitude->item(0)->nodeValue;
		
		$array_Longitude = $xml->getElementsByTagName("Longitude");//经度
		
		$Longitude = $array_Longitude->item(0)->nodeValue;
		
		$array_Precision = $xml->getElementsByTagName("Precision");//精度
		
		$Precision = $array_Precision->item(0)->nodeValue;
		
		extract($_GET);
		
		$data = array(
			'appid'			=> $appid,//开发者微信号
			'fromusername'	=> $fromuser,//发送方账号
			'addtime'		=> $addtime, //创建时间
			'msgType'		=> 'event', //消息类型
			'event'			=> $event,//事件类型
			'ticket'		=> $ticket=='' ? "" : $ticket,//二维码ticket
		);
		
		$eventKey != '' ? $data['eventKey'] = $eventKey : '';//事件绑定参数关键字
		
		$Latitude != '' ? $data['latitude'] = $Latitude : '';//纬度
		
		$Longitude != '' ? $data['longitude'] = $Longitude : '';//经度
		
		$Precision != '' ? $data['precision'] = $Precision : '';//精度
		
		$public_account = D('public_account')->where('wxid="'.$touser.'"')->find();
		
		$m = D('public_account_inbox');
		
		$m->add($data); //添加事件消息
		
		logResult("Info:".debugBacktrace()."添加事件消息：".json_encode($data).$m->getlastsql()."\r\n");
		
		$replymsg = "";
		
		$follow = D('public_account')->where('name="'.uniqueinfo('follow').'"')->find();
		
		if($event=="subscribe"){ //订阅自动回复信息
			
			$qrscene = D("public_account_follow_reply")->where("appid='".$appid."'")->find(); //查询事件被订阅时场景关键字匹配数据
			
			logResult("Info:".debugBacktrace()."查询关注后回复配置".json_encode($qrscene).D("public_account_follow_reply")->getlastsql());
			
			$public_account['verify_type_info'] != '-1' ? addfans($fromuser,$touser) : ''; //当公众号已认证,检查重复添加粉丝 
			
			$public_account_follow = D("public_account_follow")->where("openid='{$fromuser}' AND wxid='{$touser}'")->find();//查询粉丝数据
			
			logResult("Info:".debugBacktrace()."查询粉丝数据".json_encode($public_account_follow).D("public_account_follow")->getlastsql());
			 
			$public_account_redpack = D("public_account_redpack")->where("wxid='{$appid}' AND eventType='subscribe'")->find();//查询公众号红包配置
			
			logResult("Info:".debugBacktrace()."查询公众号红包配置".json_encode($public_account_redpack).D("public_account_redpack")->getlastsql());
			 
			if($public_account_redpack['stated']==1 && $public_account_redpack['apply'] < $public_account_redpack['totalamount'] && $public_account_follow['subscribe_redpack']==0 && $public_account_redpack['totalnum']<$public_account_redpack['num'] && $public_account_redpack['begintime'] < time() && $public_account_redpack['endtime'] > time()){ //发送红包 判断用户关注发红包是否启用以及是否超出预算 以及数量是否达到
				
				switch($public_account_redpack['mold']){
					case 0:
						if($public_account_redpack['totalnum'] < $public_account_redpack['num']){
							$total_amount = $public_account_redpack['amount'];//固定红包 当红包数量小于已经发放的数量
						}
					break;
					case 1:
						$total_amount = rand($public_account_redpack['small'] * 100,$public_account_redpack['big'] * 100);//随机红包
					break;
				}
				
				$redpack = array(
					'nonce_str' 	=> rand_string(32),//随机字符串
					'wxappid'		=> $appid,//公众号appid
					'send_name'		=> $public_account_redpack['name'],//商户名称
					're_openid'		=> $fromuser,//用户openid
					'total_amount'	=> $total_amount,//发送红包金额
					'total_num'		=> '1',//红包数量
					'wishing'		=> $public_account_redpack['wishing'],//'感谢您关注我们公众号',//红包祝福语
					'client_ip'		=> get_client_ip(),//接口ip地址
					'act_name'		=> $public_account_redpack['actname'],//'关注公众号送现金',//活动名称
					'remark'		=> $public_account_redpack['remark'],//'每个粉丝关注后均可获得1-10元不等的随机红包.',//备注
				);
				
				$redpackconfig = json_decode($public_account['redpack'],true);//提取微信红包接口配置
				
				if(empty($redpackconfig)){
				
					$redpack['mch_id'] = $public_account['mch_id'];
					
					$redpack['mch_billno'] = $mch_id.date("Ymd",time()).time();
					
					ksort($redpack);
					
					$redpack['sign'] = strtoupper(md5(urldecode(http_build_query($redpack)).'&key='.$public_account['paykey']));//QoOT7Os2zr0Eo69Qzw4ECOOEWYbgIaFz
					
					logResult("Info:".debugBacktrace()."红包签名字符串".$redpack['sign']);
					
					logResult("Info:".debugBacktrace()." 红包模板内容".urldecode(http_build_query($redpack))."\r\n查询订单模板内容".urldecode(http_build_query($xmldata)));
					
					$redpaper = redpack($redpack,$pc);//进入组装工厂组装并发送.
					
				}else{
					
					$redpack['signature'] = strtoupper(md5(urldecode(http_build_query($redpack)).'&key='.$redpackconfig['encodingaeskey']));
					
					getcurl($redpackconfig['host'],$redpack);//发送给客户服务器组装验证并且发放红包
					
				}
					
				$fansupdate = D("public_account_follow")->where("openid='{$fromuser}' AND wxid='{$touser}'")->setField("subscribe_redpack",1);
				
				logResult("Info:".debugBacktrace()."更新粉丝:".D('public_account_follow')->getlastsql());
				
				$redpackap = array('apply'=>array('exp','apply + '.$total_amount/100),'totalnum'=>array('exp','totalnum + 1'));
				
				$apply = D("public_account_redpack")->where("wxid='{$appid}' AND eventType='subscribe'")->save($redpackap);
				
				logResult("Info:".debugBacktrace()."红包发放数量金额更新:".D("public_account_redpack")->getlastsql());
				
				$applytotal = $public_account_redpack['apply'] + $total_amount / 100;
				
				$modal = array(
						'touser'		=>$fromuser,
						'template_id' 	=> 'hM2q-kTXQupS0myxDPHNW3olUek5dYGbUYq3t6mBsJ0',
						'url'			=> 'http://'.uniqueinfo('domain'),
						'data'			=> array(
							'first'		=> array('value'=> '欢迎关注'.uniqueinfo('name').'公众号','color'=>'#3b98e75'),
							'keyword1'	=> array('value'=> $public_account_follow['nickname'],'color'=> '#E63E3E'),
							'keyword2'	=> array('value'=> '红包派发情况,预期派发数量:'.$public_account_redpack['num'].',实际派发数量:'.$public_account_redpack['totalnum'].',预期派发金额:'.$public_account_redpack['totalamount'].'元,实际派发金额:'. $applytotal .'元.','color'=> '#000000'),
							'remark'	=> array('value'=> '你好,感谢关注'.$public_account['name'].'公众号,特别为你送上'.$total_amount / 100 ."元微信红包.请收下我们的一点小小心意,希望你能玩的开心.",'color'=> '#00B5FB'),
						),
					);
					
					format_modal($modal,$touser);
					
					logResult("Info:".debugBacktrace()."发送模板消息:".ch_json_encode($modal));
					
			}
				
			if($public_account_redpack['stated']==1 && $public_account_redpack['apply'] >= $public_account_redpack['totalamount'] && $public_account_follow['subscribe_redpack']==0 && $public_account_redpack['totalnum'] >= $public_account_redpack['num'] && $public_account_redpack['begintime'] < time() && $public_account_redpack['endtime'] > time()){
				
				//红包已派完模板消息
				
					$modal = array(
						'touser'		=>$fromuser,
						'template_id' 	=> 'hM2q-kTXQupS0myxDPHNW3olUek5dYGbUYq3t6mBsJ0',
						'url'			=> 'http://'.uniqueinfo('domain'),
						'data'			=> array(
							'first'		=> array('value'=> '欢迎关注'.uniqueinfo('name').'公众号','color'=>'#3b98e75'),
							'keyword1'	=> array('value'=> '无','color'=> '#000000'),
							'keyword2'	=> array('value'=> uniqueinfo('name'),'color'=> '#000000'),
							'remark'	=> array('value'=> '你好,这是红包派发情况,预期派发数量:'.$public_account_redpack['num'].',实际派发数量:'.$public_account_redpack['totalnum'].',预期派发金额:'.$public_account_redpack['totalamount'].'元,实际派发金额:'.$public_account_redpack['apply'].'元.本次活动圆满结束,感谢您的支持','color'=> '#000000'),
						),
					);
					
					format_modal($modal,$touser);
					
					logResult("Info:".debugBacktrace()."发送模板消息:".ch_json_encode($modal));
			}
				
			if($public_account_redpack['stated']==1 && $public_account_follow['subscribe_redpack']==1 && $public_account_redpack['begintime'] < time() && $public_account_redpack['endtime'] > time()){
				
					$modal = array(
						'touser'		=>$fromuser,
						'template_id' 	=> 'hM2q-kTXQupS0myxDPHNW3olUek5dYGbUYq3t6mBsJ0',
						'url'			=> 'http://'.uniqueinfo('domain'),
						'data'			=> array(
							'first'		=> array('value'=> '欢迎关注'.uniqueinfo('name').'公众号','color'=>'#3b98e75'),
							'keyword1'	=> array('value'=> '无','color'=> '#000000'),
							'keyword2'	=> array('value'=> uniqueinfo('name'),'color'=> '#000000'),
							'remark'	=> array('value'=> '你好,系统检测你已经领取过红包了,不能重复领取.做人不可以贪心哦!当然你也可以邀请新用户关注我们的公众号.\r\n这是红包派发情况,\r\n预期派发数量:'.$public_account_redpack['num'].',\r\n实际派发数量:'.$public_account_redpack['totalnum'].',\r\n预期派发金额:'.$public_account_redpack['totalamount'].'元,\r\n实际派发金额:'.$public_account_redpack['apply'].'元.','color'=> '#000000'),
						),
					);
					
					format_modal($modal,$touser);
					
					logResult("Info:".debugBacktrace()."发送模板消息:".ch_json_encode($modal));
				
			}
				
			if(!empty($qrscene)){
				
				if($qrscene['msgtype']=='text'){
					
					$replymsg .= format_text($fromuser,$touser,$qrscene['addtime'],'text',$qrscene['detail'],$qrscene['id']);
					
					logResult("Info:".debugBacktrace().'创建关注回复信息：'.json_encode($replymsg));
					//当场景关键字匹配数据后需要处理的业务
					
				}else{
					
					//当场景关键字没有匹配数据后需要处理的业务
					
					$reply = D('public_account_msg')->where("appid='".$appid."' AND keywords like '%".$qrscene['keywords']."%'")->select();
					
					//查询事件类型为订阅的回复信息
					
					if(!empty($reply)){ //检查订阅回复信息事件非空
						
						$replymsg .= searchKeywords($fromuser,$touser,$qrscene['keywords']);
					 
					}else{
						
						$replymsg .= format_text($fromuser,$touser,time(),'text',"感谢您关注我们公众号,这是由".uniqueinfo('name')."提供第三方公众号解决方案",10000);
						
					}
					 
				}
			}
				
		}else if($event=="LOCATION"){
			
			logResult("Info:".debugBacktrace()."用户与微信公众号通信,自动发送位置坐标.");
			
			$mapdata = array(
				'latitude'	=> $Latitude,
				'longitude'	=> $Longitude,
				'precision'	=> $Precision,
			);
			
			$map = array(
				'wxid'			=> $touser,
				'openid'		=> $fromuser
			);
			
			D("public_account_follow")->where($map)->save($mapdata);
			
			logResult("Info:".debugBacktrace()."更新用户关注表,".http_build_query($data).D('public_account_follow')->getlastsql());
			
		}else if($event == 'SCAN' AND $touser ==$follow['wxid']){ //关注平台公众号的扫描事件.
			
			logResult("Info:".debugBacktrace()."用户扫描关注公众号".$touser);
			
			if(strstr($eventKey,'qrscene_')){ //微信扫描未关注绑定事件
				
				logResult("Info:".debugBacktrace()."关键字包含qrscene_");
				
				$bin = str_replace('qrscene_','',$eventKey);//提取事件关键字
				
				$isbin = D('user')->where('id='.$bin)->find();
				
				if($isbin['scanunionid']==""){
					
					logResult("Info:".debugBacktrace()."关键字包含qrscene_并且scanunionid为空");
					
					$bind = D('user')->where("id=".$bin)->setField('scanunionid',$fromuser);//关注公众号用户绑定.
					
					$user = $bind['user'] == '' ? $bind['name'] : $bind['user'];
					
					if($user==""){
					
						$replymsg .= format_text($fromuser,$touser,time(),'text',"对不起,您关注的公众号账户不存在,无法进行平台绑定",$bin);
						
					}else{
						
						$modal = array(
							'touser'		=>$fromuser,
							'template_id' 	=> 'hM2q-kTXQupS0myxDPHNW3olUek5dYGbUYq3t6mBsJ0',
							'url'			=> 'http://'.uniqueinfo('domain'),
							'data'			=> array(
								'first'		=> array('value'=> '欢迎关注'.uniqueinfo('name').'公众号,你已经成功绑定 '.$user." 账号",'color'=>'#3b98e75'),
								'keyword1'	=> array('value'=> $user,'color'=> '#000000'),
								'keyword2'	=> array('value'=> "你可以使用该微信账号实时接收开放平台绑定账号的操作消息事件通知",'color'=> '#000000'),
								'remark'	=> array('value'=> '您当前关注的公众号账户: '.$user.' 将默认作为'.uniqueinfo('name').'开放平台的管理员账号.在'.uniqueinfo('name').' 平台的一切操作事件消息我们将推送至当前的微信号.如果需要解除绑定平台微信号,可使用当前账号发送关键字`平台解绑`解除','color'=> '#000000'),
							),
						);
						
						format_modal($modal,$touser);
					
						// $replymsg .= format_text($fromuser,$touser,time(),'text','欢迎关注'.uniqueinfo('name').'公众号,您当前关注的公众号账户: '.$user.' 将默认作为'.uniqueinfo('name').'开放平台的管理员账号.在'.uniqueinfo('name').' 平台的一切操作事件消息我们将推送至当前的微信号.如果需要解除绑定平台微信号,可使用当前账号发送关键字`平台解绑`解除',$bin);//新用户关注公众平台, 自动绑定到当前登录用户
					
					}
					
					logResult("Info:".debugBacktrace()."平台公众号消息发出:".json_encode($replymsg));
					
				}else{ //已关注
					
					logResult("Info:".debugBacktrace()."关键字包含qrscene_并且scanunionid不为空");
					
					$msg = $isbin['scanunionid'] == $fromuser ? "你是".uniqueinfo('name')." 开放平台当前登录账号管理员.欢迎再次访问公众号." : "你的".uniqueinfo('name')."平台管理账号已被其他微信号绑定.如果需要更换微信号管理.可通过之前的微信号发送关键字`平台解绑`进行解除.然后重新使用当前微信号绑定";
					
					$replymsg .= format_text($fromuser,$touser,time(),'text',$msg,$bin);//不进行绑定 给出已绑定通知
				
					logResult("Info:".debugBacktrace()."平台公众号消息发出:".json_encode($replymsg));
					
				}
				
			}else if($event=="MASSSENDJOBFINISH"){ //群发消息反馈事件推送
				
				$array_massid = $xml->getElementsByTagName("MsgID");
				
				$massid = $array_massid->item(0)->nodeValue;//发送消息id
				
				$array_status = $xml->getElementsByTagName("Status");
				
				$status = $array_status->item(0)->nodeValue;//群发状态
				
				$array_totalcount = $xml->getElementsByTagName("TotalCount");
				
				$totalcount = $array_totalcount->item(0)->nodeValue;//分类粉丝数
				
				$array_filtercount = $xml->getElementsByTagName("FilterCount");
				
				$filtercount = $array_filtercount->item(0)->nodeValue;//准备发送的粉丝数
				
				$array_sentcount = $xml->getElementsByTagName("SentCount");
				
				$sentcount = $array_sentcount->item(0)->nodeValue;//发送成功的粉丝数
				
				$array_errorcount = $xml->getElementsByTagName("ErrorCount");
				
				$errorcount = $array_errorcount->item(0)->nodeValue;//发送失败的粉丝数
				
				switch($status){
					
					case 'send success':
						$remark = "发送成功";
						break;
					case 'send fail':
						$remark = "发送失败";
						break;
					case 'err(10001)':
						$remark = "涉嫌广告违规,发送被拒绝";
						break;
					case 'err(20001)':
						$remark = "涉嫌政治违规,发送被拒绝";
						break;
					case 'err(20004)':
						$remark = "涉嫌社会违规,发送被拒绝";
						break;
					case 'err(20002)':
						$remark = "涉嫌色情违规,发送被拒绝";
						break;
					case 'err(20006)':
						$remark = "涉嫌违法犯罪违规,发送被拒绝";
						break;
					case 'err(20008)':
						$remark = "涉嫌欺诈违规,发送被拒绝";
						break;
					case 'err(20013)':
						$remark = "涉嫌版权违规,发送被拒绝";
						break;
					case 'err(22000)':
						$remark = "涉嫌互推(互相宣传)违规,发送被拒绝";
						break;
					case 'err(21000)':
						$remark = "涉嫌其他违规,发送被拒绝";
						break;
				}
				
				$mass = array(
					'wxid'			=> $touser,
					'createtime'	=> $addtime,
					'massid'		=> $massid,
					'status'		=> $status,
					'totalcount'	=> $totalcount,
					'filtercount'	=> $filtercount,
					'sentcount'		=> $sentcount,
					'errorcount'	=> $errorcount,
					'remark'		=> $remark
				);
				
				D('mass')->add($mass);
			
			}else{
			
				logResult("Info:".debugBacktrace()."关键字为ID");
				
				$isbin = D('user')->where('id='.$eventKey)->find();
				
				if($isbin['scanunionid']==""){
					
					logResult("Info:".debugBacktrace()."关键字为ID,scanunionid为空");
					
					$bind = D('user')->where("id=".$eventKey)->setField('scanunionid',$fromuser);//关注公众号用户绑定.
					
					$user = $isbin['user'] == '' ? $isbin['name'] : $isbin['user'];
					
					$modal = array(
						'touser'		=>$fromuser,
						'template_id' 	=> 'hM2q-kTXQupS0myxDPHNW3olUek5dYGbUYq3t6mBsJ0',
						'url'			=> 'http://'.uniqueinfo('domain'),
						'data'			=> array(
							'first'		=> array('value'=> '欢迎关注'.uniqueinfo('name').'公众号','color'=>'#3b98e75'),
							'keyword1'	=> array('value'=> $user,'color'=> '#000000'),
							'keyword2'	=> array('value'=> uniqueinfo('name'),'color'=> '#000000'),
							'keyword3'	=> array('value'=> $user,'color'=> '#000000'),
							'keyword4'	=> array('value'=> '无','color'=> '#000000'),
							'keyword5'	=> array('value'=> "无",'color'=> '#000000'),
							'remark'	=> array('value'=> '您当前关注的公众号账户: '.$user.' 将默认作为'.uniqueinfo('name').'开放平台的管理员账号.在'.uniqueinfo('name').' 平台的一切操作事件消息我们将推送至当前的微信号.如果需要解除绑定平台微信号,可使用当前账号发送关键字`平台解绑`解除','color'=> '#000000'),
						),
					);
					format_modal($modal,$touser);
					
					logResult("Info:".debugBacktrace()."发送模板消息:".ch_json_encode($modal));
					
					// $replymsg .= format_text($fromuser,$touser,time(),'text','欢迎关注'.uniqueinfo('name').'公众号,您当前关注的公众号账户: '.$user.' 将默认作为'.uniqueinfo('name').'开放平台的管理员账号.在'.uniqueinfo('name').' 平台的一切操作事件消息我们将推送至当前的微信号.如果需要解除绑定平台微信号,可使用当前账号发送关键字`平台解绑`解除',$eventKey);//新用户关注公众平台, 自动绑定到当前登录用户
					
					logResult("Info:".debugBacktrace()."平台公众号消息发出:".json_encode($replymsg));
				
				}else{
				
					logResult("Info:".debugBacktrace()." 关键字为ID,unionid不为空");
					
					$msg = $isbin['scanunionid'] == $fromuser ? "你是".uniqueinfo('name')." 开放平台当前登录账号管理员.欢迎再次访问公众号." : "你的".uniqueinfo('name')."平台管理账号已被其他微信号绑定.如果需要更换微信号管理.可通过之前的微信号发送关键字`平台解绑`进行解除.然后重新使用当前微信号绑定";
					
					$modal = array(
						'touser'		=>$fromuser,
						'template_id' 	=> 'hM2q-kTXQupS0myxDPHNW3olUek5dYGbUYq3t6mBsJ0',
						'url'			=> 'http://'.uniqueinfo('domain'),
						'data'			=> array(
							'first'		=> array('value'=> '您已经绑定过平台账号,无需再次绑定','color'=>'#3b98e75'),
							'keyword1'	=> array('value'=> $isbin['user'],'color'=> '#000000'),
							'keyword2'	=> array('value'=> $msg,'color'=> '#000000'),
							'remark'	=> array('value'=> '解绑请回复`平台解绑`、`平台解绑`、`平台解绑`，重要的事说3遍','color'=> '#000000'),
						),
					);
					
					format_modal($modal,$touser);
					
					logResult("Info:".debugBacktrace()."发送模板消息:".ch_json_encode($modal));
					
					// $replymsg .= format_text($fromuser,$touser,time(),'text',$msg,$eventKey);//不进行绑定 给出已绑定通知
					
					logResult("Info:".debugBacktrace()." 平台公众号消息发出:".json_encode($replymsg));
					
				}
			}
			
		}else if($event=="unsubscribe"){
			
			//取消订阅
			
			$unsubscribe = D('user')->where('scanunionid="'.$formuser.'"')->setField('scanunionid',"");//取消关注同时解除微信绑定账号.
			
			$public_account['verify_type_info'] != '-1' ? delfans($fromuser,$touser) : ''; //销毁粉丝记录
				
		}else{
			
			$reply = D('public_account_msg')->where('appid="'.$appid.'" AND eventtype="'.$event.'" AND keywords="'.$eventKey.'"')->select();//查询非订阅事件响应信息
			
			if(!empty($reply)){ //检查非订阅事件响应信息非空
				
				foreach($reply as $key=>$val){
				
					switch($val['msgtype']){
							
						case 'text'	: 
						
						$replymsg .= format_text($fromuser,$touser,$val['addtime'],'text',$val['detail'],$val['id']);

						break;
						
						case 'image': $replymsg .= format_image($fromuser,$touser,$val['addtime'],'image',$val['mediaid'],$val['id']); break;
						
						case 'voice': $replymsg .= format_voice($fromuser,$touser,$val['addtime'],'voice',$val['mediaid'],$val['id']); break;
						
						case 'video': $replymsg .= format_video($fromuser,$touser,$val['addtime'],'video',$val['mediaid'],$val['title'],$val['description'],$val['id']); break;
						
						case 'music': $replymsg .= format_music($fromuser,$touser,$val['addtime'],'music',$val['title'],$val['description'],strstr($val['link'],"http") ? $val['link'] : "http://".$_SERVER['HTTP_HOST'].$val['link'],strstr($val['hqlink'],"http") ? $val['hqlink'] : "http://".$_SERVER['HTTP_HOST'].$val['hqlink'],$val['thumbmediaid']); break;
						
						case 'news'	: 
							
							$item = unserialize(StripSlashes($val['detail']));
								
							$article = "";
							
							foreach($item as $p=>$q){
								
								$news = $q;
								
								$url = htmlspecialchars_decode(str_replace("{id}",$val['id'],$news['url']));
								
								$url = strstr($url,'http://') || strstr($url,"https://") ? $url : "http://".$_SERVER['HTTP_HOST'].$url;
								
								$picurl = strstr($news['picurl'],"http") ? $news['picurl'] : "http://".$_SERVER['HTTP_HOST'].$news['picurl'];
								
								$description = count($item) == 1 ? $val['brief'] : $news['description'];
								
								$article .= "<item>
											<Title><![CDATA[{$news['title']}]]></Title> 
											<Description><![CDATA[{$description}]]></Description>
											<PicUrl><![CDATA[{$picurl}]]></PicUrl>
											<Url><![CDATA[{$url}]]></Url>
											</item>\r\n";
								
							}
							
							$replymsg .= format_news($fromuser,$touser,$val['addtime'],'news',count($item),$article); 
						
						break;
						
						default: $replymsg .= format_text($fromuser,$touser,time(),'text',"这是默认菜单回复信息",10000); break;
						
					}
				
				}
			
			}else{
				
				$replymsg = format_text($fromuser,$touser,time(),'text',"对不起，没有找到与关键字 {$eventKey} 相匹配的信息",10000);
				
			}
			
		}
		
		logResult("Info:".debugBacktrace()."Reply Content:".$replymsg."\r\n");
				 
		 $errorCode = $pc->encryptMsg($replymsg,time(),getrand(12),$encrypt); //aes 加密消息
		 
		 logResult("Error:".debugBacktrace()."errorCode：".$errorCode."\r\n"); //记录错误代码
		 
		 logResult("Info:".debugBacktrace()."reply Msg：".$encrypt."\r\n");//记录回复信息日志
		 
		 if($errorCode==0){
			 
			echo $encrypt;//回复消息
			
		 }else{
			 
			 logResult("Error:".debugBacktrace().$errorCode."\r\n");
			 
			echo 'success';//打印错误通知
			
		 }
		
	}
