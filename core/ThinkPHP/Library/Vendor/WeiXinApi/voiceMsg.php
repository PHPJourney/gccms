<?php
/*
 +-------------------------------------------
 | 音频消息
 | @Author journey<admin@libaoka.com>
 | @Date 11:08 2015-10-24
 +-------------------------------------------
 */
 	function voiceMsg($msg,$pc){
		
	/*		初始化xml对象	*/
		$xml = new \DOMDocument();
			
		$xml->loadXML($msg);
	/*		解析消息节点，取得内容		*/
		$array_user = $xml->getElementsByTagName('FromUserName');
		
		$data['fromusername'] = $array_user->item(0)->nodeValue;
		
		$array_appid = $xml->getElementsByTagName('ToUserName');
		
		$data['appid'] = $_GET['appid'];
		
		$appid = $array_appid->item(0)->nodeValue;
		
		$array_addtime = $xml->getElementsByTagName('CreateTime');
		
		$data['addtime'] = $array_addtime->item(0)->nodeValue;
		
		$array_mediaid = $xml->getElementsByTagName('MediaId');
		
		$data['mediaid'] = $array_mediaid->item(0)->nodeValue;
		
		$array_format = $xml->getElementsByTagName('Format');
		
		$data['format'] = $array_format->item(0)->nodeValue;
		
		$array_mid = $xml->getElementsByTagName('MsgId');
		
		$msgid = $array_mid->item(0)->nodeValue;
		
		$data['msgtype'] = "voice";
	/*		存储接收到的消息		*/
		$m = D('public_account_inbox');
		
		$m->add($data);
		
	}
