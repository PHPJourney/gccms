<?php
/*
 +-------------------------------------------
 | 文本消息
 | @Author journey<admin@libaoka.com>
 | @Date 11:08 2015-10-24
 +-------------------------------------------
 */
/*
 +----------------------------------
 | 文本消息
 | @Author journey <admin@libaoka.com>
 | @Date 10:20 2015-8-27
 +----------------------------------
 */
	function textMsg($msg,$pc){
		
		extract($_GET);
		
		
	/*		初始化xml对象	*/
		$xml = new \DOMDocument();
			
		$xml->loadXML($msg);
	/*		解析消息节点，取得内容		*/
		$array_user = $xml->getElementsByTagName('FromUserName');
		
		$data['fromusername'] = $array_user->item(0)->nodeValue;
		
		$array_to = $xml->getElementsByTagName('ToUserName');
		
		$touser = $array_to->item(0)->nodeValue;
		
		$data['appid'] = $appid;
		
		$array_addtime = $xml->getElementsByTagName('CreateTime');
		
		$data['addtime'] = $array_addtime->item(0)->nodeValue;
		
		$array_detail = $xml->getElementsByTagName('Content');
		
		$data['detail'] = $array_detail->item(0)->nodeValue;
		
		$array_mid = $xml->getElementsByTagName('MsgId');
		
		$msgid = $array_mid->item(0)->nodeValue;
		
		$data['msgtype'] = "text";
		
		/*		存储接收到的消息		*/
		$m = D('public_account_inbox');
			
		$m->add($data);
		/*		查询消息关键字匹配数据		*/
		
		// $vscene = str_replace(" ",'',msubstr($data['detail'],0,3,'utf8',false));
		
		// logResult("\r\n\t微场景截取字符串:".$vscene."\r\n");
		
		if(strstr($data['detail'],"微场景") !== false){
			
			logResult("Info:".debugBacktrace()."进入场景查询页面");
			
			$keywords = str_replace(" ","",str_replace("微场景",'',$data['detail']));
			
			$public_account = D('public_account')->where('wxid="'.$touser.'"')->find();
			
			logResult("Info:".debugBacktrace()."通过wxid查询公众号:".D('public_account')->getlastsql());
			
			$m = D('vscene_bind');
				
			$scene = $m->where("uid=".$public_account['uid'].' AND token like "'.$public_account['accesstoken'].'"')->select();
			
			logResult("Info:".debugBacktrace()." 通过公众号信息查询绑定微场景账户:".D('vscene_bind')->getlastsql());
				
			if(empty($scene)){
				
				$format = format_text($data['fromusername'],$touser,time(),'text',"很抱歉,公众号没有开启微场景应用.",404);
				
			}else{
				
				foreach($scene as $key=>$val){
					$to[] = array(
						'user' => $val['user'],
						'vscene_sha1' => $val['vscene_sha1'],
					);
					$data['to'] = json_encode($to);
				}
				
				$data['timestamp'] = time();
				
				$data['keywords'] = $keywords;
				
				$data['nonce']	= rand_string(22);
				
				ksort($data);
				
				$signature = Encrypt(base64_encode($data));
				
				$jsons = postCurl(SCENELIST.$signature,$data);
				logResult("Info:".debugBacktrace()."jsons:".$jsons);
				$json = json_decode($jsons,true);
				
				$count = count($json) > 10 ? 10 : count($json);
				
				for($i=0;$i<$count;$i++){
					
					$result[] = $json[$i];
					
				}
				
				$article = "";
				
				foreach($result as $key=>$val){
					
					$url = $val['scenecode_varchar'];
					
					$article .= "<item><Title><![CDATA[{$val['scenename_varchar']}]]></Title> 
								<Description><![CDATA[{$val['desc_varchar']}]]></Description>
								<PicUrl><![CDATA[{$val['thumbnail_varchar']}]]></PicUrl>
								<Url><![CDATA[{$url}]]></Url>
								</item>\r\n";
									
				}
				
				if(count($json)==0){
					
					$format = format_text($data['fromusername'],$touser,time(),'text',"很抱歉,没有找到微场景 '".$keywords."'",404);
					
				}else{
				
					$format = format_news($data['fromusername'],$touser,time(),"news",count($result),$article);
				
				}
			
			}
			
			logResult("Info:".debugBacktrace()."Reply Content:".$format."\r\n");
	 
			 $errorCode = $pc->encryptMsg($format,time(),getrand(12),$encrypt); //aes 加密消息
			 
			 logResult("Error:".debugBacktrace()."errorCode：".$errorCode."\r\n"); //记录错误代码
			 
			 logResult("Info:".debugBacktrace()."reply Msg：".$encrypt."\r\n");//记录回复信息日志
			 
			 if($errorCode==0){
				 
				exit($encrypt);//回复消息
				
			 }else{
				 
				 logResult($errorCode."\r\n");
				 
				exit($errorCode);//打印错误通知
			 }
		}
		
		if(strstr($data['detail'],"音乐") !== false){
			
			logResult("Info:".debugBacktrace()."进入场景查询页面");
			
			$keywords = str_replace(" ","",str_replace("音乐",'',$data['detail']));
			
			$music = D('public_account_msg')->where('appid="'.$appid.'" AND msgtype="music"')->order("id desc")->select();
			
			logResult("Info:".debugBacktrace()." 通过wxid查询公众号:".D('public_account_msg')->getlastsql());
				
			if(empty($music)){
				
				$format = format_text($data['fromusername'],$touser,time(),'text',"很抱歉,当前公众号没有发布音乐消息.",404);
				
			}else{
				
				$result = $music[rand(0,count($music)-1)];
				
				$link = strstr($result['link'],'http://') || strstr($result['link'],"https://") ? $result['link'] : "http://".$_SERVER['HTTP_HOST'].$result['link'];
				$link = strstr($result['hqlink'],'http://') || strstr($result['hqlink'],"https://") ? $result['hqlink'] : "http://".$_SERVER['HTTP_HOST'].$result['hqlink'];
				
				$format = format_music($data['fromusername'],$touser,time(),"music",$result['title'],msubstr("系统为您随机推荐歌曲 ".$rsult['description'],0,30,'utf8',false),$link,$hqlink,$result['thumbmediaid']);
			
			}
			
			logResult("Info:".debugBacktrace()."Reply Content:".$format."\r\n");
	 
			 $errorCode = $pc->encryptMsg($format,time(),getrand(12),$encrypt); //aes 加密消息
			 
			 logResult("Error:".debugBacktrace()."errorCode：".$errorCode."\r\n"); //记录错误代码
			 
			 logResult("Info:".debugBacktrace()."reply Msg：".$encrypt."\r\n");//记录回复信息日志
			 
			 if($errorCode==0){
				 
				exit($encrypt);//回复消息
				
			 }else{
				 
				 logResult("Error:".debugBacktrace().$errorCode."\r\n");
				 
				exit($errorCode);//打印错误通知
			 }
		}
		
		if(strtolower($data['detail'])=='redpack'){
			
			$format = redpack($data['fromusername'],$touser,time(),'text',"测试Vendor接口".CALLBACK,"133381");
			logResult("Info:".debugBacktrace()."redpack 消息回复 {$format}");
			/*$redpack = '<xml><act_name><![CDATA[关注公众号送现金]]></act_name><client_ip><![CDATA[218.244.157.189]]></client_ip><mch_billno><![CDATA[1268103801201510231445589889]]></mch_billno><mch_id><![CDATA[1268103801]]></mch_id><nonce_str><![CDATA[hnNoSCcA_LJyt_/oBnjsNIQtxuhrPrK_]]></nonce_str><re_openid><![CDATA[o3BdNweC6lC4i26iJh4yhx_6xRpc]]></re_openid><remark><![CDATA[每个粉丝首次关注后可1-2元红包]]></remark><send_name><![CDATA[Tkpig]]></send_name><total_amount><![CDATA[1.29]]></total_amount><total_num><![CDATA[1]]></total_num><wishing><![CDATA[感谢您关注我们公众号]]></wishing><wxappid><![CDATA[wxc2281db54c3704a1]]></wxappid><sign><![CDATA[D64FFBE205D8F95EDDC20BDB523DED97]]></sign></xml>';
			
			logResult("\r\n 发送红包".$redpack.REDPACK);
			
			postcurlssl(REDPACK,$redpack);//现金红包
			
			exit;*/
		}

		$msg = searchKeywords($data['fromusername'],$touser,$data['detail']);
		
		logResult("Info:".debugBacktrace()."chaKey:".$data['detail'].$msg);
		
		if($msg==''){
			
			$db = D('public_account_default_reply');
			
			$defaultmsg = $db->where('appid="'.$appid.'"')->find();
			
			logResult("Info:".debugBacktrace()."默认回复信息查询：".implode(',',$defaultmsg).";SQL语句打印：".$db->getlastsql());
			
			$format = "";
			
			if(!empty($defaultmsg)){ //检查默认回复是否为空
			
				switch($defaultmsg['msgtype']){
					
					case 'image':
					
						$format = format_image($data['fromusername'],$touser,$defaultmsg['addtime'],$defaultmsg['msgtype'],$defaultmsg['mediaid'],$defaultmsg['id']);
					
					 break;
					 
					 case 'text':
						
						$format = format_text($data['fromusername'],$touser,$defaultmsg['addtime'],$defaultmsg['msgtype'],$defaultmsg['detail'],$defaultmsg['id']);
					 
					 break;
					
					case 'voice':
					
						$format = format_voice($data['fromusername'],$touser,$defaultmsg['addtime'],$defaultmsg['msgtype'],$defaultmsg['mediaid'],$defaultmsg['id']);
						
						break;
						
					case 'video':
					
						$format = format_video($data['fromusername'],$touser,$defaultmsg['addtime'],$defaultmsg['msgtype'],$defaultmsg['title'],$defaultmsg['description'],$defaultmsg['id']);
						
						break;
						
					case 'music':
					
						$format = format_music($data['fromusername'],$touser,$defaultmsg['addtime'],$defaultmsg['msgtype'],$defaultmsg['title'],$defaultmsg['description'],strstr($defaultmsg['link'],'http') ? $defaultmsg['link'] : "http://".$_SERVER['HTTP_HOST'].$defaultmsg['link'],strstr($defaultmsg['hqlink'],'http') ? $defaultmsg['hqlink'] : "http://".$_SERVER['HTTP_HOST'].$defaultmsg['hqlink'],$defaultmsg['thumbmediaid']);
						
						break;
						
					case 'news':
						
						$format = searchKeywords($data['fromusername'],$touser,$defaultmsg['keywords']);//默认图文消息回复
						
						logResult("Info:".debugBacktrace()."回复默认图文消息");
						
					break;
						
					default: 
					
						$format = format_text($data['fromusername'],$touser,time(),'text',"对不起，我不明白你讲的是什么",10000);
						
					break;
					
				}
				
			}else{
				
				$format = format_text($data['fromusername'],$touser,time(),'text',"对不起，我不明白你说的是什么",10000);
				
			}
			
			 $contents = $format;//设置自动回复为空，提取默认配置
			 
		}else{
			
			$contents = $msg;//设置关键词回复消息
			
		}
		 logResult("Info:".debugBacktrace()."Reply Content:".$contents."\r\n");
		 
		 $errorCode = $pc->encryptMsg($contents,time(),getrand(12),$encrypt); //aes 加密消息
		 
		 logResult("Error:".debugBacktrace()."errorCode：".$errorCode."\r\n"); //记录错误代码
		 
		 logResult("Info:".debugBacktrace()."reply Msg：".$encrypt."\r\n");//记录回复信息日志
		 
		 if($errorCode==0){
			 
			echo $encrypt;//回复消息
			
		 }else{
			 
			 logResult("Error:".debugBacktrace().$errorCode."\r\n");
			 
			echo $errorCode;//打印错误通知
		 }
	}	
