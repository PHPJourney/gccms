<?php
/**
*实名认证结果查询API
**/

///////////////////////////////////////////////////////////////////////////////////
	
	/**
		商户私钥，由openssl工具生成，生成方法请参考《密钥对的生成与使用文档》，格式上是要求换行的
   */

$priKey='-----BEGIN RSA PRIVATE KEY-----
MIICXAIBAAKBgQC2y9SD7KVcLPYePhqAy+iid/6L6iO4ThtU/U5WxtaJ9tX78hrr
L1+ixP5yPRaIsXtYDkaD1WkDhabsxR8zQTvOkoPnlSwfZkycX1fnb7sqdksLkizm
yFakvkYjbD5CdvQ+xgSQzrxQL8u+mfPY6FL5QTirhifBISnwTtXIgNAClwIDAQAB
AoGAeNhb0DNcRom609d+sfMcAnyNnXXW03tfelpTte6R2neCk6NExIJ3GSZeiKt2
ADxFLLuTRoiJejibWCAhNkNEA3gXbszEOr0KmGNKrFACYMKSn2rto7YjB5DB/F9q
Yd2sQxhMoY9qCX7sNXLli028m0ucKz5T3RElTG6SOF01hJECQQDnFVzLekKPpPGW
Y27kx9m4rCA0xWGCZuZrlay8a4eoEj9lXtMijxpTLjkkFThVsV9fQp0A/0U+iJsq
izzrB3FdAkEAyoGWJKiu97xZ1ikYlOKBq76mLT4GprdsbgaL7RqJUQzv+eWaVpv7
LsuPRi49YcRTiFFRPPiUb5LxBpEN1vUAgwJAb9vba3PnPHlvqIjBaWWEcux/OoxB
Q0pkR7fQQfUbWbRbk8pvEc+LwrAhYOIUvwZ5UDeCoLTw4/BkjBeSiYK00QJARgV6
6iAdp/HLyn6ZTlnn5n/crAYnfJwt9Pl0hr7HPmxPykP3Ev2KZArk9qpkdRrSm28q
vP9jLBVOHCwp8erziwJBAL7y+W1B8QgefgxGRhHfZ/dZkEjm4MK9ynL9g16NPnRT
iEmcZjkkWn2t9rMoicY4bBJ7m9H6mCxzaWDp21AmW+8=
-----END RSA PRIVATE KEY-----
';

	
	$priKey= openssl_get_privatekey($priKey);
	
	
	//接口类型，必填，固定值identity_check
   $service_type = "account_query";
   
   //商家号，必填
   $merchant_code="1118004517";
   
   //商家流水号，智付流水号，二选一，必填  serial_no可在验证API返回参数中找到
	$merchant_serial_no ="789444";
	$serial_no = "";
   
   //接口版本，固定值
   $interface_version = "V3.0";
   
   //签名类型(加密方式)，必填，RSA-S或者RSA
   $sign_type="RSA-S";
   
   
   /**
		参数组装，并且加密
   */
	$signStr= "";
	$signStr = $signStr."interface_version=".$interface_version."&";	
	$signStr = $signStr."merchant_code=".$merchant_code."&";	
	$signStr = $signStr."merchant_serial_no=".$merchant_serial_no."&";		
	$signStr = $signStr."service_type=".$service_type;	
	
	/**
		调用openssl_sign函数获取到参数sign的值,需要在php_ini文件里打开php_openssl插件
   */
	
	openssl_sign($signStr,$sign_info,$priKey,OPENSSL_ALGO_MD5);
	
	$sign = base64_encode($sign_info);

?>
<!-- 以post方式提交所有接口参数到智付网关https://identiy.dinpay.com/accountQuery -->
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	</head>	
	<body onLoad="document.dinpayForm.submit();">
		<form name="dinpayForm" method="post" action="https://identiy.dinpay.com/accountQuery" target="_self">
			<input type="hidden" name="sign"		  value="<?php echo $sign?>" />
			<input type="hidden" name="merchant_code" value="<?php echo $merchant_code?>" />
			<input type="hidden" name="merchant_serial_no"     value="<?php echo $merchant_serial_no?>"/>
			<input type="hidden" name="serial_no"     value="<?php echo $serial_no?>"/>
			<input type="hidden" name="sign_type"      value="<?php echo $sign_type?>"/>
			<input type="hidden" name="service_type"  value="<?php echo $service_type?>"/>
			<input type="hidden" name="interface_version" value="<?php echo $interface_version?>"/>
			</form>
	</body>
</html>
