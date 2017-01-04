<?php
namespace Think;
class Minify{
	public function compress($content){
		$string = str_replace("\r\n", '', $content); //清除换行符  
		$string = str_replace("\n", '', $string); //清除换行符  
		$string = str_replace("\t", '', $string); //清除制表符  
		$pattern = array (  
						"/> *([^ ]*) *</", //去掉注释标记  
						"/[\s]+/",  
						"/<!--[^!]*-->/",  
						"/\" /",  
						"/ \"/",  
						"'/\*[^*]*\*/'"  
						);  
		$replace = array (  
						">\\1<",  
						" ",  
						"",  
						"\"",  
						"\"",  
						""  
						);  
		return preg_replace($pattern, $replace, $string); 
		// return $content;
	}
}