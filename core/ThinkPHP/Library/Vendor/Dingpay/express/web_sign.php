<?php
	
	
	require_once('merchant.php');
	
	$priKey= openssl_get_privatekey($priKey);
	
	$pubKey = openssl_get_publickey($pubKey);
	
	
	
	$service_type = "express_web_sign_pay";

	$merchant_code = "1111110166";

	$interface_version = "V3.0";

	$input_charset = "UTF-8";

	$sign_type ="RSA-S";
	
	
	$notify_url = "http://www.dinpay.com";
	
	$order_no = "78445595544";
	
	
	$order_amount = "0.01";
	
	$order_time = "2015-11-11 12:12:12";	
	
	$mobile = "15989882747";

	
	$bank_code = "ICBC";

	$card_type = "0";

	$card_no = "6212264000014203646";
	
	$card_name = "黄豪";
	
	$id_no = "441622199207100012";
	
	$encrypt = $card_no."|".$card_name."|".$id_no;
	
	openssl_public_encrypt($encrypt,$info,$pubKey);
	
	$encrypt_info = base64_encode($info);//encrypt_info参数参与签名
	
	$product_name ="check";
	
	$product_code ="";
	
	$product_num ="";
	
	$product_desc ="";
	
	
	
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
	
	
	$signStr = $signStr."service_type=".$service_type;
	
	echo $signStr;

	openssl_sign($signStr,$sign_info,$priKey,OPENSSL_ALGO_MD5);
	
	$sign = base64_encode($sign_info);
	
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	</head>	
	<body onLoad="document.dinpayForm.submit();">
		<form name="dinpayForm" method="post" action="https://api.dinpay.com/gateway/api/express" target="_blank">
			<input type="hidden" name="sign"		  value="<?php echo $sign?>" />
			<input type="hidden" name="merchant_code" value="<?php echo $merchant_code?>" />
			<input type="hidden" name="bank_code"     value="<?php echo $bank_code?>"/>
			<input type="hidden" name="notify_url"      value="<?php echo $notify_url?>"/>
			<input type="hidden" name="card_type"  value="<?php echo $card_type?>"/>
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
			<input type="hidden" name="encrypt_info"     value="<?php echo $encrypt_info?>"/>
		</form>
	</body>
</html>