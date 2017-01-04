<?php
class express{
	
	private $priKey= '';//私钥
	private $pubKey = '';//公钥
	private $service_type='express_sign_pay';//接口类型
	private $interface_version = "V3.0";//接口版本
	private	$merchant_code ="1111110166";//商户号
	private	$input_charset = "UTF-8";//查询编码
	private	$sign_type = "RSA-S";//签名类型
		//获取验证码时返回的交易流水号
	private	$sms_trade_no = "";//交易流水号
		//手机收到的验证码
	private	$sms_code = "";//手机验证码
	private $sms_type = "0";//签约+支付验证码:0  支付验证码:1
	private	$notify_url = "http://www.dinpay.com";//回调地址
	private	$order_no = "456612212";//商户订单号
	private	$order_amount = "0.01";//付款金额
	private	$order_time = "2015-11-11 12:12:12";//订单时间
	private	$mobile = "15989882747";//手机号码
	private	$bank_code="ICBC";//银行类型
	private	$card_type="0";//银行卡类型 0 普卡 1 信用卡
	private	$product_code ="";//产品代码
	private	$product_num ="";//产品编号
	private	$product_name ="check";//产品名称
	private	$product_desc ="";	//产品描述
	private $card_no = "6226620409813938";//卡号
	private	$card_name = "邓辉";//开户名
	private	$id_no = "430523199204201537";//身份证号码
	private	$merchant_sign_id = "";//商户签约ID
	private $card_cvv2="";//信用卡cvv
	private $cared_exp_date="";//信用卡有效期
		//获取卡的签约状态
	private	$sign_status ="0";
	private $send_type = "0";
	
	function __construct($config){
		$this->priKey = openssl_get_privatekey($config['prikey']);
		$this->pubKey = openssl_get_publickey($config['pubkey']);
		$this->merchant_code = $config['merchant_code'];
		$this->_config($config['data']);
	}
	
	function getsms(){
		if($this->sms_type==0){
			$encrypt = $this->card_no."|".$this->card_name."|".$this->id_no;
			openssl_public_encrypt($encrypt,$info,$this->pubKey);
			$encrypt_info = base64_encode($info);//encrypt_info参数参与签名 签约签名
			// die($encrypt_info);
		}
		if($this->sign_status ==2){
			$signStr = array(
				"bank_code"				=> $this->bank_code,
				"card_type"				=> $this->card_type,
				"encrypt_info"			=> $encrypt_info,
				"input_charset"			=> $this->input_charset,
				"interface_version"		=> $this->interface_version,
				"merchant_code"			=> $this->merchant_code,
				"mobile"				=> $this->mobile,
				"order_amount"			=> $this->order_amount,
				"order_no"				=> $this->order_no,
				"send_type"				=> $this->send_type,
				"service_type"			=> $this->service_type,
				"sms_type"				=> $this->sms_type,
			);
			ksort($signStr);
			$signStr = urldecode(http_build_query($signStr));
			openssl_sign($signStr,$sign_info,$this->priKey,OPENSSL_ALGO_MD5);
			$sign = base64_encode($sign_info);
		};
		if($this->sign_status=='0'&&$this->card_type=="0"){
			$signStr = array(
				"input_charset"			=> $this->input_charset,
				"interface_version"		=> $this->interface_version,
				"merchant_code"			=> $this->merchant_code,
				"merchant_sign_id"		=> $this->merchant_sign_id,
				"mobile"				=> $this->mobile,
				"order_amount"			=> $this->order_amount,
				"order_no"				=> $this->order_no,
				"send_type"				=> $this->send_type,
				"service_type"			=> $this->service_type,
				"sms_type"				=> $this->sms_type,
			);
			ksort($signStr);
			$signStr = http_build_query($signStr);
			openssl_sign($signStr,$sign_info,$this->priKey,OPENSSL_ALGO_MD5);
			$sign = base64_encode($sign_info);
		}
		if($this->sign_status=='0'&&$this->card_type=="1"){
			$signStr = array(
				"encrypt_info"			=> $encrypt_info,
				"input_charset"			=> $this->input_charset,
				"interface_version"		=> $this->interface_version,
				"merchant_code"			=> $this->merchant_code,
				"merchant_sign_id"		=> $this->merchant_sign_id,
				"mobile"				=> $this->mobile,
				"order_amount"			=> $this->order_amount,
				"order_no"				=> $this->order_no,
				"send_type"				=> $this->send_type,
				"service_type"			=> $this->service_type,
				"sms_type"				=> $this->sms_type,
			);
			ksort($signStr);
			$signStr = http_build_query($signStr);
			openssl_sign($signStr,$sign_info,$this->priKey,OPENSSL_ALGO_MD5);
			$sign = base64_encode($sign_info);
		}
		$data = array(
			"sign"				=> $sign,
			"service_type"		=> $this->service_type,
			"merchant_code"		=> $this->merchant_code,
			"interface_version"	=> $this->interface_version,
			"input_charset"		=> $this->input_charset,
			"sign_type"			=> $this->sign_type,
			"order_no"			=> $this->order_no,
			"order_amount"		=> $this->order_amount,
			"sms_type"			=> $this->sms_type,
			"send_type"			=> $this->send_type,
			"mobile"			=> $this->mobile,
			"merchant_sign_id"	=> $this->merchant_sign_id,
		);
		if($this->sms_type==0){
			$data['encrypt_info']	= $encrypt_info;
			$data['card_type']		= $this->card_type;
			$data['bank_code']		= $this->bank_code;
		}
		return $data;
	}
	
	function _config($data){
		foreach($data as $key=>$val){
			$this->$key = $val;
		}
	}
	
	function  postCurl($postdata,$url){
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postdata));  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response=curl_exec($ch);
		return  $response;
	}
}