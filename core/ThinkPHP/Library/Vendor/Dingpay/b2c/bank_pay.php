<? header("content-Type: text/html; charset=UTF-8");?>
<?php
/* *
 *功能：智付个人网银支付接口
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
	
	
	$merchant_code = "1118004517";//商户号，1118004517是测试商户号，线上发布时要更换商家自己的商户号！

	$service_type ="direct_pay";	

	$interface_version ="V3.0";

	$sign_type ="RSA-S";

	$input_charset = "UTF-8";
	
	$notify_url ="http://15l0549c66.iask.in:45191/testnewb2c/offline_notify.php";		
	
	$order_no = date( 'YmdHis' );	

	$order_time = date( 'Y-m-d H:i:s' );	

	$order_amount = "0.1";	

	$product_name ="testpay";	

	//以下参数为可选参数，如有需要，可参考文档设定参数值
	
	$return_url ="";	
	
	$pay_type = "";
	
	$redo_flag = "";	
	
	$product_code = "";	

	$product_desc = "";	

	$product_num = "";

	$show_url = "";	

	$client_ip ="" ;	

	$bank_code = "";	

	$extend_param = "";

	$extra_return_param = "";	

		
	

/////////////////////////////   参数组装  /////////////////////////////////
/**
除了sign_type参数，其他非空参数都要参与组装，组装顺序是按照a~z的顺序，下划线"_"优先于字母	
*/
	
	$signStr= "";
	
	if($bank_code != ""){
		$signStr = $signStr."bank_code=".$bank_code."&";
	}
	if($client_ip != ""){
		$signStr = $signStr."client_ip=".$client_ip."&";
	}
	if($extend_param != ""){
		$signStr = $signStr."extend_param=".$extend_param."&";
	}
	if($extra_return_param != ""){
		$signStr = $signStr."extra_return_param=".$extra_return_param."&";
	}
	
	$signStr = $signStr."input_charset=".$input_charset."&";	
	$signStr = $signStr."interface_version=".$interface_version."&";	
	$signStr = $signStr."merchant_code=".$merchant_code."&";	
	$signStr = $signStr."notify_url=".$notify_url."&";		
	$signStr = $signStr."order_amount=".$order_amount."&";		
	$signStr = $signStr."order_no=".$order_no."&";		
	$signStr = $signStr."order_time=".$order_time."&";	

	if($pay_type != ""){
		$signStr = $signStr."pay_type=".$pay_type."&";
	}

	if($product_code != ""){
		$signStr = $signStr."product_code=".$product_code."&";
	}	
	if($product_desc != ""){
		$signStr = $signStr."product_desc=".$product_desc."&";
	}
	
	$signStr = $signStr."product_name=".$product_name."&";

	if($product_num != ""){
		$signStr = $signStr."product_num=".$product_num."&";
	}	
	if($redo_flag != ""){
		$signStr = $signStr."redo_flag=".$redo_flag."&";
	}
	if($return_url != ""){
		$signStr = $signStr."return_url=".$return_url."&";
	}		
	
	$signStr = $signStr."service_type=".$service_type;

	if($show_url != ""){	
		
		$signStr = $signStr."&show_url=".$show_url;
	}
	
	  //echo $signStr."<br>";  
		
		
	
/////////////////////////////   获取sign值（RSA-S加密）  /////////////////////////////////

	$merchant_private_key= openssl_get_privatekey($merchant_private_key);
	
	openssl_sign($signStr,$sign_info,$merchant_private_key,OPENSSL_ALGO_MD5);
	
	$sign = base64_encode($sign_info);
	
	// echo $sign;
		
?>
<!-- 以post方式提交所有接口参数到智付支付网关https://pay.dinpay.com/gateway?input_charset=UTF-8 -->
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	</head>	
	<body onLoad="document.dinpayForm.submit();">
		<form name="dinpayForm" method="post" action="https://pay.dinpay.com/gateway?input_charset=UTF-8" target="_blank">
			<input type="hidden" name="sign"		  value="<?php echo $sign?>" />
			<input type="hidden" name="merchant_code" value="<?php echo $merchant_code?>" />
			<input type="hidden" name="bank_code"     value="<?php echo $bank_code?>"/>
			<input type="hidden" name="order_no"      value="<?php echo $order_no?>"/>
			<input type="hidden" name="order_amount"  value="<?php echo $order_amount?>"/>
			<input type="hidden" name="service_type"  value="<?php echo $service_type?>"/>
			<input type="hidden" name="input_charset" value="<?php echo $input_charset?>"/>
			<input type="hidden" name="notify_url"    value="<?php echo $notify_url?>">
			<input type="hidden" name="interface_version" value="<?php echo $interface_version?>"/>
			<input type="hidden" name="sign_type"     value="<?php echo $sign_type?>"/>
			<input type="hidden" name="order_time"    value="<?php echo $order_time?>"/>
			<input type="hidden" name="product_name"  value="<?php echo $product_name?>"/>
			<input Type="hidden" Name="client_ip"     value="<?php echo $client_ip?>"/>
			<input Type="hidden" Name="extend_param"  value="<?php echo $extend_param?>"/>
			<input Type="hidden" Name="extra_return_param" value="<?php echo $extra_return_param?>"/>
			<input Type="hidden" Name="pay_type"  value="<?php echo $pay_type?>"/>
			<input Type="hidden" Name="product_code"  value="<?php echo $product_code?>"/>
			<input Type="hidden" Name="product_desc"  value="<?php echo $product_desc?>"/>
			<input Type="hidden" Name="product_num"   value="<?php echo $product_num?>"/>
			<input Type="hidden" Name="return_url"    value="<?php echo $return_url?>"/>
			<input Type="hidden" Name="show_url"      value="<?php echo $show_url?>"/>
			<input Type="hidden" Name="redo_flag"     value="<?php echo $redo_flag?>"/>
		</form>
	</body>
</html>