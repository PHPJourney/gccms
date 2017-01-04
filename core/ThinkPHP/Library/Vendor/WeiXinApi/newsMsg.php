<?php
/*
 +-------------------------------------------
 | 图文消息
 | @Author journey<admin@libaoka.com>
 | @Date 11:08 2015-10-24
 +-------------------------------------------
 */
 /*
 +----------------------------------
 | 消息类型：新闻列表
 | @Author journey<admin@libaoka.com>
 | @Date 13:17 2015-9-4
 +----------------------------------
 */
	function newsMsg($msg,$pc){
		
		$xml = new \DOMDocument();
			
		$xml->loadXML($msg);
		
	}
