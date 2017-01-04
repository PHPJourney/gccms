<?php
/*
 +----------------------------
 | 数据加密
 | @Author journey<admin@libaoka.com>
 | @Date　16:54 2015-9-29
 +----------------------------
 */
	function Encrypt($json){
		
		$encodingAesKey = "UezFPEzYaqamBzNtIJI2E7Onb7h3Uenyss8t8Y67jxCJNXotaZp3XSVoI8b2lycMye6H8ctpkzEzqKppRtYKGUCBcBx7hBEAgAA2CxQQVvf1QwRVWqjJMf01VwPEXwOH";
		
		$sha1 = sha1(base64_encode($encodingAesKey.$json));
		
		return $sha1;
	
	}
/*
 +---------------------------------
 | 手动添加微信公众号验证接口
 | @Author journey<admin@libaoka.com>
 | @Date 10:20 2015-8-27
 +---------------------------------
 */
	function checkSignature($token){
        extract(I(''));
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}