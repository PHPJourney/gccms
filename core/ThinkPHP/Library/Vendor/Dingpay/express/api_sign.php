<?php
	
	
	require_once('merchant.php');
	
	$priKey= openssl_get_privatekey($priKey);
	
	$pubKey = openssl_get_publickey($pubKey);
	
	
	$service_type = "express_sign_pay";
	
	$interface_version = "V3.0";
	
	$merchant_code ="1111110166";
	
	$input_charset = "UTF-8";
	
	$sign_type = "RSA-S";
	
	//获取验证码时返回的交易流水号
	$sms_trade_no = "";
	
	//手机收到的验证码
	$sms_code = "";
	
	$notify_url = "http://www.dinpay.com";
	
	$order_no = "456612212";
	
	$order_amount = "0.01";
	
	$order_time = "2015-11-11 12:12:12";
	
	$mobile = "15989882747";
	
	
	
	$bank_code="ICBC";
	
	$card_type="0";
	
	$product_code ="";
	
	$product_num ="";
	
	$product_name ="check";
	
	$product_desc ="";	
	
	
	//获取卡的签约状态
	$sign_status =="0"
	
	//未签约借记卡或者信用卡
	if($sign_status =="2"){
		
		$bank_code = "ICBC";
	
		$card_no = "6226620409813938";
	
		$card_name = "邓辉";
	
		$id_no = "430523199204201537";
	
		$encrypt = $card_no."|".$card_name."|".$id_no;
	
		openssl_public_encrypt($encrypt,$info,$pubKey);
	
		$encrypt_info = base64_encode($info);//encrypt_info参数参与签名
		
	
	}
	//签约借记卡
	if($sign_status=='0'&&$card_type=="0"){
		
		//获取签约号
		$merchant_sign_id = "";
	
	}else{//签约信用卡
		
			$merchant_sign_id = "";
	
			$card_cvv2="";
	
			$cared_exp_date="";
	
			$encrypt = $card_cvv2."|".$cared_exp_date;
	
			openssl_public_encrypt($encrypt,$info,$pubKey);
	
			$encrypt_info = base64_encode($info);//encrypt_info参数参与签名
	
	}	
	
		
	
	if($sign_status =="2"){
	
	$signStr = "";
	
	$signStr = $signStr."bank_code=".$bank_code."&";	
	
	$signStr = $signStr."card_type=".$card_type."&";	

	$signStr = $signStr."encrypt_info=".$encrypt_info."&";

	$signStr = $signStr."input_charset=".$input_charset."&";		
	
	$signStr = $signStr."interface_version=".$interface_version."&";		
	
	
	$signStr = $signStr."merchant_code=".$merchant_code."&";
	
	$signStr = $signStr."mobile=".$mobile."&";
	
	$signStr = $signStr."notify_url=".$notify_url."&";
	
	
	$signStr = $signStr."order_amount=".$order_amount."&";
	
	
	$signStr = $signStr."order_no=".$order_no."&";
	
	$signStr = $signStr."order_time=".$order_time."&";
	
	
	
	
	if($product_code != ""){
		$signStr = $signStr."product_code=".$product_code."&";
	}	
	
	$signStr = $signStr."product_name=".$product_name."&";
	
	if($product_desc != ""){
		$signStr = $signStr."product_code=".$product_code."&";
	}	
	
	
	$signStr = $signStr."service_type=".$service_type."&";
	
	$signStr = $signStr."sms_code=".$sms_code."&";
	
	$signStr = $signStr."sms_trade_no=".$sms_trade_no;

	openssl_sign($signStr,$sign_info,$priKey,OPENSSL_ALGO_MD5);
	
	$sign = base64_encode($sign_info);
	}
	
	if($sign_status=='0'&&$card_type=="0"){
		
	$signStr = "";
	
	$signStr = $signStr."input_charset=".$input_charset."&";		
	
	$signStr = $signStr."interface_version=".$interface_version."&";		
	
	$signStr = $signStr."merchant_code=".$merchant_code."&";
	
	$signStr = $signStr."merchant_sign_id=".$merchant_sign_id."&";	
	
	$signStr = $signStr."mobile=".$mobile."&";
	
	$signStr = $signStr."notify_url=".$notify_url."&";
	
	
	$signStr = $signStr."order_amount=".$order_amount."&";
	
	
	$signStr = $signStr."order_no=".$order_no."&";
	
	$signStr = $signStr."order_time=".$order_time."&";
	
	
	
	
	if($product_code != ""){
		$signStr = $signStr."product_code=".$product_code."&";
	}	
	
	$signStr = $signStr."product_name=".$product_name."&";
	
	if($product_desc != ""){
		$signStr = $signStr."product_code=".$product_code."&";
	}	
	
	
	$signStr = $signStr."service_type=".$service_type."&";
	
	$signStr = $signStr."sms_code=".$sms_code."&";
	
	$signStr = $signStr."sms_trade_no=".$sms_trade_no;

	openssl_sign($signStr,$sign_info,$priKey,OPENSSL_ALGO_MD5);
	
	$sign = base64_encode($sign_info);
	}else{
		
	
	
	$signStr = "";
		
	$signStr = $signStr."encrypt_info=".$encrypt_info."&";	
	
	$signStr = $signStr."input_charset=".$input_charset."&";		
	
	$signStr = $signStr."interface_version=".$interface_version."&";		
	
	$signStr = $signStr."merchant_code=".$merchant_code."&";
	
	$signStr = $signStr."merchant_sign_id=".$merchant_sign_id."&";	
	
	$signStr = $signStr."mobile=".$mobile."&";
	
	$signStr = $signStr."notify_url=".$notify_url."&";
	
	
	$signStr = $signStr."order_amount=".$order_amount."&";
	
	
	$signStr = $signStr."order_no=".$order_no."&";
	
	$signStr = $signStr."order_time=".$order_time."&";
	
	
	
	
	if($product_code != ""){
		$signStr = $signStr."product_code=".$product_code."&";
	}	
	
	$signStr = $signStr."product_name=".$product_name."&";
	
	if($product_desc != ""){
		$signStr = $signStr."product_code=".$product_code."&";
	}	
	
	
	$signStr = $signStr."service_type=".$service_type."&";
	
	$signStr = $signStr."sms_code=".$sms_code."&";
	
	$signStr = $signStr."sms_trade_no=".$sms_trade_no;

	openssl_sign($signStr,$sign_info,$priKey,OPENSSL_ALGO_MD5);
	
	$sign = base64_encode($sign_info);
		
	}
		
	
	
	
	
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	</head>	
	<body onLoad="document.dinpayForm.submit();">
		<form name="dinpayForm" method="post" action="https://api.dinpay.com/gateway/api/express" target="_blank">
			<input type="hidden" name="sign"		  value="<?php echo $sign?>" />
			<input type="hidden" name="merchant_code" value="<?php echo $merchant_code?>" />
			<input type="hidden" name="notify_url"      value="<?php echo $notify_url?>"/>
			<input type="hidden" name="service_type"  value="<?php echo $service_type?>"/>
			<input type="hidden" name="input_charset" value="<?php echo $input_charset?>"/>
			<input type="hidden" name="mobile"    value="<?php echo $mobile?>">
			<input type="hidden" name="interface_version" value="<?php echo $interface_version?>"/>
			<input type="hidden" name="order_no"     value="<?php echo $order_no?>"/>
			<input type="hidden" name="order_amount"     value="<?php echo $order_amount?>"/>
			<input type="hidden" name="order_time"     value="<?php echo $order_time?>"/>
			<input type="hidden" name="product_name"     value="<?php echo $product_name?>"/>
			<input type="hidden" name="product_code"     value="<?php echo $product_code?>"/>
			<input type="hidden" name="product_desc"     value="<?php echo $product_desc?>"/>
			<input type="hidden" name="product_num"     value="<?php echo $product_num?>"/>
			<input type="hidden" name="sign_type"     value="<?php echo $sign_type?>"/>
			<input type="hidden" name="merchant_sign_id"     value="<?php echo $merchant_sign_id?>"/>
			<input type="hidden" name="sms_code"     value="<?php echo $sms_code?>"/>
			<input type="hidden" name="sms_trade_no"     value="<?php echo $sms_trade_no?>"/>
			<!--未签约商户必传以下三个参数，已经签约借记卡不需要传这三个参数，已经签约信用卡只需传encrypt_info
			<input type="hidden" name="encrypt_info"     value="<?php echo $encrypt_info?>"/>
			<input type="hidden" name="card_type"  value="<?php echo $card_type?>"/>
			<input type="hidden" name="bank_code"     value="<?php echo $bank_code?>"/>
			-->			
				
		</form>
	</body>
</html>
