<?php
/* *
 *���ܣ��Ǹ���������֧�����ʶ�����ѯ�ӿڣ�Ŀǰֻ�ܲ�ѯ�����µ�ʱ��12Сʱ���ڵģ�
 *�汾��3.0
 *���ڣ�2016-07-10
 *˵����
 *���´���ֻ��Ϊ�˷����̻����Զ��ṩ���������룬�̻����Ը����Լ���վ����Ҫ�����ռ����ĵ���д,
 *����һ��Ҫʹ�øô��롣�ô������ѧϰ���о��Ǹ��ӿ�ʹ�ã���Ϊ�ṩһ���ο���
 **/
	
///////////////////////////  ��ʼ���ӿڲ���  //////////////////////////////
/**
�ӿڲ�����ο��Ǹ�����֧���ĵ�������sign����������������Ҫ�������ʼ��
*/
	include_once("./merchant.php");
	
	$merchant_code = "1118004517";//�̻��ţ�1118004517�ǲ����̻��ţ�����ʱҪ�����̼��Լ����̻��ţ�
	
	$interface_version = "V3.0";
	
	$sign_type = "RSA-S";	
	
	$service_type = "single_trade_query";	
	
	$order_no = "20160712041929";	
	
	$trade_no = "";	

/////////////////////////////   ������װ  /////////////////////////////////
/**
����sign_type�����������ǿղ�����Ҫ������װ����װ˳���ǰ���a~z��˳���»���"_"��������ĸ
*/
	
	$signStr = "";

	$signStr = "interface_version=".$interface_version."&merchant_code=".$merchant_code."&order_no=".$order_no."&service_type=".$service_type;

	if($trade_no != ""){	
		$signStr = $signStr."&trade_no=".$trade_no; 
	}
	
	//echo $signStr;
	
/////////////////////////////   ��ȡsignֵ��RSA-S���ܣ�  /////////////////////////////////


	$merchant_private_key= openssl_get_privatekey($merchant_private_key);

	openssl_sign($signStr,$sign_info,$merchant_private_key,OPENSSL_ALGO_MD5);
	
	$sign = base64_encode($sign_info);
	//echo $sign;
	
?>
<!-- ��post��ʽ�ύ���нӿڲ������Ǹ���ѯ����https://query.dinpay.com/query -->
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