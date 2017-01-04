<?php
/* *
 *功能：智付个人网银支付单笔订单查询接口（目前只能查询距离下单时间12小时以内的）
 *版本：3.0
 *日期：2016-07-10
 *说明：
 *以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,
 *并非一定要使用该代码。该代码仅供学习和研究智付接口使用，仅为提供一个参考。
 **/
	
///////////////////////////  初始化接口参数  //////////////////////////////
/**
接口参数请参考智付网银支付文档，除了sign参数，其他参数都要在这里初始化
*/
	include_once("./merchant.php");
	
	$merchant_code = "1118004517";//商户号，1118004517是测试商户号，调试时要更换商家自己的商户号！
	
	$interface_version = "V3.0";
	
	$sign_type = "RSA-S";	
	
	$service_type = "single_trade_query";	
	
	$order_no = "20160712041929";	
	
	$trade_no = "";	

/////////////////////////////   参数组装  /////////////////////////////////
/**
除了sign_type参数，其他非空参数都要参与组装，组装顺序是按照a~z的顺序，下划线"_"优先于字母
*/
	
	$signStr = "";

	$signStr = "interface_version=".$interface_version."&merchant_code=".$merchant_code."&order_no=".$order_no."&service_type=".$service_type;

	if($trade_no != ""){	
		$signStr = $signStr."&trade_no=".$trade_no; 
	}
	
	//echo $signStr;
	
/////////////////////////////   获取sign值（RSA-S加密）  /////////////////////////////////


	$merchant_private_key= openssl_get_privatekey($merchant_private_key);

	openssl_sign($signStr,$sign_info,$merchant_private_key,OPENSSL_ALGO_MD5);
	
	$sign = base64_encode($sign_info);
	//echo $sign;
	
?>
<!-- 以post方式提交所有接口参数到智付查询网关https://query.dinpay.com/query -->
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>
	<body onLoad="javascript:document.getElementById('queryForm').submit();">
		<form  id="queryForm" action="https://query.dinpay.com/query" method="post"  target="_self">
			<input type="hidden" name="interface_version" value="<?php echo $interface_version?>" />
			<input type="hidden" name="service_type" value="<?php echo $service_type?>" />
			<input type="hidden" name="merchant_code" value="<?php echo $merchant_code?>" />
			<input type="hidden" name="sign_type" value="<?php echo $sign_type?>" />
			<input type="hidden" name="sign" value="<?php echo $sign?>" />
			<input type="hidden" name="order_no" value="<?php echo $order_no?>" />
			<input type="hidden" name="trade_no" value="<?php echo $trade_no?>" />
		</form>
	</body>
</html>