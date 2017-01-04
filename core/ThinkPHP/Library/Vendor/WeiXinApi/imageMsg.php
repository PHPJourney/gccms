<?php
/*
 +-------------------------------------------
 | 图片消息
 | @Author journey<admin@libaoka.com>
 | @Date 11:08 2015-10-24
 +-------------------------------------------
 */
	function imageMsg($msg,$pc){
		
		$xml = new \DOMDocument();
			
		$xml->loadXML($msg);
		
	}