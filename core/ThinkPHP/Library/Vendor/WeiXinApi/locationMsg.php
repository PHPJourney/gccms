<?php
/*
 +-------------------------------------------
 | 地理位置消息
 | @Author journey<admin@libaoka.com>
 | @Date 11:08 2015-10-24
 +-------------------------------------------
 */
 	function locationMsg($msg,$pc){
		
		$xml = new \DOMDocument();
			
		$xml->loadXML($msg);
		
		//记录用户地理位置
		
		$array_appid = $xml->getElementsByTagName('ToUserName');
		
		$appid = $_GET['appid'];
		
		$touser = $array_appid->item(0)->nodeValue;
		
		
		$array_Latitude = $xml->getElementsByTagName("Location_X");
		
		$Latitude = $array_Latitude->item(0)->nodeValue;//地理位置纬度
		
		$array_Longitude = $xml->getElementsByTagName("Location_Y");
		
		$Longitude = $array_Longitude->item(0)->nodeValue;//地理位置经度
		
		$array_Scale = $xml->getElementsByTagName("Scale");
		
		$Scale = $array_Scale->item(0)->nodeValue;//地理位置精度
		
		$array_user = $xml->getElementsByTagName('FromUserName');
		
		$openid = $array_user->item(0)->nodeValue;
		
		$array_addtime = $xml->getElementsByTagName('CreateTime');
		
		$CreateTime = $array_addtime->item(0)->nodeValue;
		
		$array_Label = $xml->getElementsByTagName('Label');
		
		$Label = $array_Label->item(0)->nodeValue;
		
		logResult("Info:".debugBacktrace()."更新用户地理位置信息.");
		
		$msg = array(
			'fromusername' 	=> $openid,
			'appid'			=> 	$appid,
			'event'			=>	'LOCATION',
			'latitude'		=> $Latitude,
			'longitude'		=> $Longitude,
			'scale'			=> $Scale,
			'label'			=> $Label,
			'addtime'		=> $CreateTime,
			
		);
		
		D('public_account_inbox')->add($msg);
		
		logResult("Info:".debugBacktrace()."写入地理位置消息.".http_build_query($msg).D('public_account_inbox')->getlastsql());
		
		$map = array(
			'openid'		=> $openid,
			'wxid'			=> $touser
		);
		
		$data = array(
			'latitude'		=> $Latitude,
			'longitude'		=> $Longitude,
			'scale'			=> $Scale,
			'label'			=> $Label
		);
		
		D('public_account_follow')->where($map)->save($data);
		
		logResult("Info:".debugBacktrace()."更新用户地理位置".http_build_query($data).D('public_account_follow')->getlastsql());
		
	}
