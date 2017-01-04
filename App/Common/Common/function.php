<?php

function dbrecord($message,$tags){
	$data = array(
		"logtags"	=> $tags,
		"logtext"	=> $message,
	);
	D("logrecord")->add($data);
}

function operation(){
	$extension['redis'] = extension_loaded('redis');
	$extension['memcache'] = extension_loaded('memcache');
	$extension['apc'] = function_exists('apc_cache_info') && @apc_cache_info();
	$extension['xcache'] = function_exists('xcache_get');
	$extension['eaccelerator'] = function_exists('eaccelerator_get');
	$extension['wincache'] = function_exists('wincache_ucache_meminfo') && wincache_ucache_meminfo();
	return $extension;
}
/*
 +-----------------------------
 | @Author journey
 | @email admin@libaoka.com
 | @Date 2015-04-20
 | @Desc 字符串截取
 +-----------------------------
 */
	function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true) {
		if(function_exists("mb_substr"))
		$slice = mb_substr($str, $start, $length, $charset);
		elseif(function_exists('iconv_substr')) {
			$slice = iconv_substr($str,$start,$length,$charset);
		}else{
			$re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
			$re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
			$re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
			$re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
			preg_match_all($re[$charset], $str, $match);
			$slice = join("",array_slice($match[0], $start, $length));
		}
		return $suffix ? $slice.'...' : $slice;
	}
function format_bytes($size, $delimiter = '')
{
	$units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');

	for ($i = 0; $i < 5; $i++) {
		$size /= 1024;
	}

	return round($size, 2) . $delimiter . $units[$i];
}

function getfiles($path){
	switch($path){
		case "fonts":
			$path = "./Public/attach/fonts/";
		break;
	}
	foreach(scandir($path) as $afile){
		if($afile=='.'||$afile=='..'){
			continue; 
		}
		if(is_dir($path.'/'.$afile)){ 
			getfiles($path.'/'.$afile); 
		} else { 
			$file[] = $afile;
		} 
	}
	return $file;
}