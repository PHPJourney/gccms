<?php
	
	
	require_once('merchant.php');
	
	$priKey= openssl_get_privatekey($priKey);
	
	$pubKey = openssl_get_publickey($pubKey);
	
	$service_type = "sign_pay_sms_code";

	$merchant_code = "1111110166";

	$interface_version = "V3.0";

	$input_charset = "UTF-8";

	$sign_type = "RSA-S";

	$order_no = "789945666";
	
	$order_amount = "0.01";
	
	$mobile = "15989882747";
	
	//签约+支付验证码:0  支付验证码:1
	$sms_type = "1";
	
	$send_type = "0";
	
	
	//银行卡类型,参数可选，未签约商户必输  借记卡：0 信用卡：1
	$card_type = "0";
	
	//可选，已经签约用户必输
	$merchant_sign_id = "395c83f725ee3ef3";
	
	//可选，未签约商户必输
	$bank_code = "ICBC";
	
	
	//encrypt_info,可选，未签约用户、信用卡用户必输，此处测试是已经签约的借记卡,如果是其他情况，请将注释去掉
	
	/**
	$card_no = "6212264000014203646";
	
	$card_name = "黄豪";
	
	$id_no = "441622199207100012";
	
	$encrypt = $card_no."|".$card_name."|".$id_no;
	
	openssl_public_encrypt($encrypt,$info,$pubKey);
	
	$encrypt_info = base64_encode($info);//encrypt_info参数参与签名
	**/
	
	
	//签名状态，从查询页面sign_query获取
	$sign_status = "0";
	
	
	
	if($sign_status=='2'){
		
		$signStr = "";
	
	$signStr = $signStr."bank_code=".$bank_code."&";	
	
	$signStr = $signStr."card_type=".$card_type."&";	

	$signStr = $signStr."encrypt_info=".$encrypt_info."&";
	
	$signStr = $signStr."input_charset=".$input_charset."&";		
	
	$signStr = $signStr."interface_version=".$interface_version."&";		
	
	$signStr = $signStr."merchant_code=".$merchant_code."&";
	
	$signStr = $signStr."mobile=".$mobile."&";
	
	$signStr = $signStr."order_amount=".$order_amount."&";
	
	$signStr = $signStr."order_no=".$order_no."&";

	$signStr = $signStr."send_type=".$send_type."&";
	
	$signStr = $signStr."service_type=".$service_type."&";
	
	$signStr = $signStr."sms_type=".$sms_type;
	
	
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
	
	$signStr = $signStr."order_amount=".$order_amount."&";
	
	$signStr = $signStr."order_no=".$order_no."&";

	$signStr = $signStr."send_type=".$send_type."&";
	
	$signStr = $signStr."service_type=".$service_type."&";
	
	$signStr = $signStr."sms_type=".$sms_type;
	
	
	openssl_sign($signStr,$sign_info,$priKey,OPENSSL_ALGO_MD5);
	
	$sign = base64_encode($sign_info);
		
	}
	
	if($sign_status=='0'&&$card_type=="1"){
		
		
	$signStr = "";
		
	$signStr = $signStr."encrypt_info=".$encrypt_info."&";
	
	$signStr = $signStr."input_charset=".$input_charset."&";		
	
	$signStr = $signStr."interface_version=".$interface_version."&";		
	
	$signStr = $signStr."merchant_code=".$merchant_code."&";
	
	$signStr = $signStr."merchant_sign_id=".$merchant_sign_id."&";
	
	$signStr = $signStr."mobile=".$mobile."&";
	
	$signStr = $signStr."order_amount=".$order_amount."&";
	
	$signStr = $signStr."order_no=".$order_no."&";

	$signStr = $signStr."send_type=".$send_type."&";
	
	$signStr = $signStr."service_type=".$service_type."&";
	
	$signStr = $signStr."sms_type=".$sms_type;
	
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
			<input type="hidden" name="service_type"		  value="<?php echo $service_type?>" />
			<input type="hidden" name="merchant_code" value="<?php echo $merchant_code?>" />
			<input type="hidden" name="interface_version" value="<?php echo $interface_version?>"/>
			<input type="hidden" name="input_charset" value="<?php echo $input_charset?>"/>
			<input type="hidden" name="sign_type"     value="<?php echo $sign_type?>"/>
			<input type="hidden" name="order_no"     value="<?php echo $order_no?>"/>
			<input type="hidden" name="order_amount"     value="<?php echo $order_amount?>"/>
			<input type="hidden" name="sms_type"     value="<?php echo $sms_type?>"/>
			<input type="hidden" name="send_type"     value="<?php echo $send_type?>"/>
			<input type="hidden" name="mobile"    value="<?php echo $mobile?>">
			<input type="hidden" name="merchant_sign_id"     value="<?php echo $merchant_sign_id?>"/>
			<!--未签约商户必传以下三个参数，已经签约借记卡不需要传这三个参数，已经签约信用卡只需传encrypt_info
			<input type="hidden" name="encrypt_info"     value="<?php echo $encrypt_info?>"/>
			<input type="hidden" name="card_type"  value="<?php echo $card_type?>"/>
			<input type="hidden" name="bank_code"     value="<?php echo $bank_code?>"/>
			-->			
		</form>
	</body>
</html>



