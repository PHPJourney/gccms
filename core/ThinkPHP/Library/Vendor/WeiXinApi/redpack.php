<?php
/*
 +-------------------------------------------
 | 红包消息
 | @Author journey<admin@libaoka.com>
 | @Date 11:08 2015-10-24
 +-------------------------------------------
 */
 	function redpack($data){
		
		$redpack = "<xml>";
		
		foreach($data as $key=>$val){
			
			$redpack .= "<{$key}><![CDATA[{$val}]]></{$key}>";
			
		}
		
		$redpack .= "</xml>";
		
		logResult("Info:".debugBacktrace()."红包发送组装".$redpack);
		
		postcurlssl(REDPACK,$redpack);//现金红包
		
	}
