<?php
/*
 +-------------------------------------------
 | 视频消息
 | @Author journey<admin@libaoka.com>
 | @Date 11:08 2015-10-24
 +-------------------------------------------
 */
 	function videoMsg($msg,$pc){
		
		$xml = new \DOMDocument();
			
		$xml->loadXML($msg);
		
	}
