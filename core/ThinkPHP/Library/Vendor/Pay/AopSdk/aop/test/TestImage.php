<?php
/**
 * Alipay.com Inc.
 * Copyright (c) 2004-2014 All Rights Reserved.
 */



include('../AlipayMobilePublicMultiMediaClient.php');


header("Content-type: text/html; charset=gbk");

/**
 *
 * @author wangYuanWai
 * @version $Id: Test.hp, v 0.1 Aug 6, 2014 4:20:17 PM yikai.hu Exp $
 */
class TestImage{


	public $partner_public_key  = "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCdPxgmsTVZeHhPuBSJgo8hw0fR9BASQAgguj7IOR44eKKGrImANwfFuI13tFecfQ66V2Eq6+1dI09+SQmZWztp8rUic1R8DnaQfpBaNErvs7QCEvUIv1B90GiV6OTZ+9rYoS9Gb9dsY7hnZRAQ6H61N61acFX4bB0MKa5tXwRGLQIDAQAB";
	public $alipay_public_key   = "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDIgHnOn7LLILlKETd6BFRJ0GqgS2Y3mn1wMQmyh9zEyWlz5p1zrahRahbXAfCfSqshSNfqOmAQzSHRVjCqjsAw1jyqrXaPdKBmr90DIpIxmIyKXv4GGAkPyJ/6FTFY99uhpiq0qadD/uSzQsefWo0aTvP/65zi3eof7TcZ32oWpwIDAQAB";
		//公用变量
	public $serverUrl = 'http://publicexprod.d5336aqcn.alipay.net/chat/multimedia.do';//'http://publicexprod.d5336aqcn.alipay.net/chat/multimedia.do';//'http://i.com/works/photo-sdk/_data/1.jpg';//"http://i.com/works/photo-sdk/_data/publicexprod.php";//"http://publicexprod.d5336aqcn.alipay.net/chat/multimedia.do";
	public $appId = "2013121100055554";

	public $partner_private_key = 'MIICdgIBADANBgkqhkiG9w0BAQEFAASCAmAwggJcAgEAAoGBAJ0/GCaxNVl4eE+4FImCjyHDR9H0EBJACCC6Psg5Hjh4ooasiYA3B8W4jXe0V5x9DrpXYSrr7V0jT35JCZlbO2nytSJzVHwOdpB+kFo0Su+ztAIS9Qi/UH3QaJXo5Nn72tihL0Zv12xjuGdlEBDofrU3rVpwVfhsHQwprm1fBEYtAgMBAAECgYBRpSz5ChHVPsPZQI8JRwziTu6/iKW/lBekRo/Kjj2uvJRGsNdEB061zrlFahIDYrt+7Ve6XX2FWowv2eRuB/y0maYZdljxV2BaGTRWEBXgbNa/EW4cf7hV0/J6jJi/FcHlw7ndnVKIKAjw4wVZDNl4Kdzto4SWlXXCv5ixZjLgAQJBAM9LdzQRS3F8PAJ7ZPYBMJ8bOhqdUIrgB8Z8+AAeuP8bukgC9QtXImnSh3wWLKC3gJYC6dqXhWbw8Jaso5FNEC0CQQDCMUgWd/HtZ0FNx92WT2ZoDPC26XHdMZ2UInUUiMWbRLRRpxY0vh5h5ACAPHTj4Yd7cIt8Dtd0bEtSSAwyX84BAkEAjmCB5kQ+shqnSPkhtgnJMG7N8Lu+NzR6gq0Q1VxEqguMXauSTRCy9UYBgovkaRrAechUgKvzl2nDhWncCo+InQJAYrWsQAeOSS/ASSo8H6iSlHdncIKvZ1FOGTt+qgZv8+HzisHVDtBJH1dHTeftPtyoAn4N2OyuZjaZ/uQylvSOAQJAazBBLeAttgaDnXq+c50JOrjBa5R7gbZvTSEB38AMpqoQvAu9IbxI6Jer+AMB2scIokOuRESMtXWxEbNOHIiUIQ==';

	public $format = "json";
	public $charset = "GBK";



	function __construct(){

	}

	public function load() {
		$alipayClient = new AlipayMobilePublicMultiMediaClient(
			$this -> serverUrl,
			$this -> appId,
			$this -> partner_private_key,
			$this -> format,
			$this -> charset
		);
		$response = null;
		$outputStream = null;
		$request = $alipayClient -> getContents() ;

		//200
		//echo( '状态码：'. $request -> getCode() .', ');
		//echo '<hr /><br /><br /><br />';

		$fileType = $request -> getType();
		//echo( '类型：'. $fileType .', ');
		if( $fileType == 'text/plain'){
			//出错，返回 json
			echo $request -> getBody();

		}else{

			$type = $request -> getFileSuffix( $fileType );

			//echo $this -> getParams();
			//exit();

			//返回 文件流
			header("Content-type: ". $fileType ); //类型


			header("Accept-Ranges: bytes");//告诉客户端浏览器返回的文件大小是按照字节进行计算的
			header("Accept-Length: ". $request -> getContentLength() );//文件大小
			header("Content-Length: ". $request -> getContentLength() );//文件大小
			header('Content-Disposition: attachment; filename="'. time() .'.'. $type .'"'); //文件名
			echo $request -> getBody() ;
			exit ( ) ;
		}

		//echo( '内容： , '. $request -> getContentLength()  );

		//echo '<hr /><br /><br /><br />';
		//echo  '参数：<pre>';

		//echo ($request -> getParams());

		//echo '</pre>' ;
	}
}





//  测试
$test1 = new TestImage();
$test1 -> load();
