<?php
/**
*实名认证接口
*/

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
   $service_type = "identity_check";
   
   //商家号，必填
   $merchant_code="1118004517";
   
   //流水号，必填，商家自己设置
   $merchant_serial_no ="789";
   
   //身份证号码，必填
   $id_no = "441622199207100012";
   
   //银行卡号，必填
   $card_no="6212264000014203646";
   
    //银行卡户名，必填
   $card_name="黄豪";
   
    //银行预留手机号，必填
   $mobile_no="15989882747";
   
   //接口版本，固定值
   $interface_version = "V3.0";
   
   //签名类型(加密方式)，必填，RSA-S或者RSA
   $sign_type="RSA-S";
   
   
   /**
		参数组装，并且加密
   */
	$signStr= "";
	$signStr = $signStr."card_name=".$card_name."&";	
	$signStr = $signStr."card_no=".$card_no."&";	
	$signStr = $signStr."id_no=".$id_no."&";	
	$signStr = $signStr."interface_version=".$interface_version."&";	
	$signStr = $signStr."merchant_code=".$merchant_code."&";	
	$signStr = $signStr."merchant_serial_no=".$merchant_serial_no."&";	
	$signStr = $signStr."mobile_no=".$mobile_no."&";		
	$signStr = $signStr."service_type=".$service_type;	
	
	/**
		调用openssl_sign函数获取到参数sign的值,需要在php_ini文件里打开php_openssl插件
   */
	
	openssl_sign($signStr,$sign_info,$priKey,OPENSSL_ALGO_MD5);
	
	$sign = base64_encode($sign_info);

?>
<!-- 以post方式提交所有接口参数到智付网关https://identiy.dinpay.com/accountCheck -->
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	</head>	
	<body onLoad="document.dinpayForm.submit();">
		<form name="dinpayForm" method="post" action="https://identiy.dinpay.com/accountCheck" target="_self">
			<input type="hidden" name="sign"		  value="<?php echo $sign?>" />
			<input type="hidden" name="merchant_code" value="<?php echo $merchant_code?>" />
			<input type="hidden" name="merchant_serial_no"     value="<?php echo $merchant_serial_no?>"/>
			<input type="hidden" name="sign_type"      value="<?php echo $sign_type?>"/>
			<input type="hidden" name="card_name"  value="<?php echo $card_name?>"/>
			<input type="hidden" name="card_no"  value="<?php echo $card_no?>"/>
			<input type="hidden" name="mobile_no"  value="<?php echo $mobile_no?>"/>
			<input type="hidden" name="service_type"  value="<?php echo $service_type?>"/>
			<input type="hidden" name="interface_version" value="<?php echo $interface_version?>"/>
			<input type="hidden" name="id_no"    value="<?php echo $id_no?>">
			</form>
	</body>
</html>