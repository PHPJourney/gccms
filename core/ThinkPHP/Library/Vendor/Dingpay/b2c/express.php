<?php
class express{
	
// private $priKey='-----BEGIN RSA PRIVATE KEY-----
// MIICXAIBAAKBgQC2y9SD7KVcLPYePhqAy+iid/6L6iO4ThtU/U5WxtaJ9tX78hrr
// L1+ixP5yPRaIsXtYDkaD1WkDhabsxR8zQTvOkoPnlSwfZkycX1fnb7sqdksLkizm
// yFakvkYjbD5CdvQ+xgSQzrxQL8u+mfPY6FL5QTirhifBISnwTtXIgNAClwIDAQAB
// AoGAeNhb0DNcRom609d+sfMcAnyNnXXW03tfelpTte6R2neCk6NExIJ3GSZeiKt2
// ADxFLLuTRoiJejibWCAhNkNEA3gXbszEOr0KmGNKrFACYMKSn2rto7YjB5DB/F9q
// Yd2sQxhMoY9qCX7sNXLli028m0ucKz5T3RElTG6SOF01hJECQQDnFVzLekKPpPGW
// Y27kx9m4rCA0xWGCZuZrlay8a4eoEj9lXtMijxpTLjkkFThVsV9fQp0A/0U+iJsq
// izzrB3FdAkEAyoGWJKiu97xZ1ikYlOKBq76mLT4GprdsbgaL7RqJUQzv+eWaVpv7
// LsuPRi49YcRTiFFRPPiUb5LxBpEN1vUAgwJAb9vba3PnPHlvqIjBaWWEcux/OoxB
// Q0pkR7fQQfUbWbRbk8pvEc+LwrAhYOIUvwZ5UDeCoLTw4/BkjBeSiYK00QJARgV6
// 6iAdp/HLyn6ZTlnn5n/crAYnfJwt9Pl0hr7HPmxPykP3Ev2KZArk9qpkdRrSm28q
// vP9jLBVOHCwp8erziwJBAL7y+W1B8QgefgxGRhHfZ/dZkEjm4MK9ynL9g16NPnRT
// iEmcZjkkWn2t9rMoicY4bBJ7m9H6mCxzaWDp21AmW+8=
// -----END RSA PRIVATE KEY-----';

	// private $pubKey = '-----BEGIN PUBLIC KEY-----
// MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDCK5Tk4l3sjF+ycDNfPa5C7a++
// qqFCIFCJxERLQpoypD/xIX+Spsie2WNmc+e41vv3H9G0bC/gtaIHKYWbXcWGbcJK
// NpbKHlQh1r6XvansdtfXojwzAaHi5Iz68ObRGlbMxikXhGqTx0SgL/lxF50Mje0g
// v7BO/A8885lghyToZQIDAQAB
// -----END PUBLIC KEY-----';
	private $priKey = '';
	private $pubKey = '';
	private $merchant_code = "1118004517";//商户号，1118004517是测试商户号，线上发布时要更换商家自己的商户号！
	private $service_type ="direct_pay";	
	private $interface_version ="V3.0";
	private $sign_type ="RSA-S";
	private $input_charset = "UTF-8";
	private $notify_url ="http://15l0549c66.iask.in:45191/testnewb2c/offline_notify.php";	//回调地址	
	private $order_no = '';	
	private $order_time = '';	
	private $order_amount = "0.01";	
	private $product_name ="";	
	//以下参数为可选参数，如有需要，可参考文档设定参数值
	private $return_url ="";	
	private $pay_type = "";
	private $redo_flag = "";
	private $product_code = "";	
	private $product_desc = "";	
	private $product_num = "";
	private $show_url = "";	
	private $client_ip ="" ;	
	private $bank_code = "";	
	private $extend_param = "";
	private $extra_return_param = "";	
	function __construct($config){
		$this->priKey = openssl_get_privatekey($config['prikey']);
		$this->pubKey = openssl_get_publickey($config['pubkey']);
		$this->merchant_code = $config['merchant_code'];
		$this->_config($config['data']);
	}
	
	function _config($data){
		foreach($data as $key=>$val){
			$this->$key = $val;
		}
	}
	
	function bankpay(){
		$data = array(
			"input_charset"			=> $this->input_charset,
			"interface_version"		=> $this->interface_version,
			"merchant_code"			=> $this->merchant_code,
			"notify_url"			=> $this->notify_url,
			"order_amount"			=> $this->order_amount,
			"order_no"				=> $this->order_no,
			"order_time"			=> $this->order_time,
			"service_type"			=> $this->service_type,
			"product_name"			=> $this->product_name,
		);
		$this->bank_code != '' ? $data['bank_code'] = $this->bank_code : '';
		$this->client_ip != '' ? $data['client_ip'] = $this->client_ip : '';
		$this->extend_param != '' ? $data['extend_param'] = $this->extend_param : '';
		$this->extra_return_param != '' ? $data['extra_return_param'] = $this->extra_return_param : '';
		$this->product_code != '' ? $data['product_code'] = $this->product_code : '';
		$this->pay_type != '' ? $data['pay_type'] = $this->pay_type : '';
		$this->product_desc != '' ? $data['product_desc'] = $this->product_desc : '';
		$this->product_num != '' ? $data['product_num'] = $this->product_num : '';
		$this->redo_flag != '' ? $data['redo_flag'] = $this->redo_flag : '';
		$this->return_url != '' ? $data['return_url'] = $this->return_url : '';
		$this->show_url != '' ? $data['show_url'] = $this->show_url : '';
		ksort($data);
		$signStr = urldecode(http_build_query($data));
		openssl_sign($signStr,$sign_info,$this->priKey,OPENSSL_ALGO_MD5);
		$data['sign'] = base64_encode($sign_info);
		$data['sign_type'] = $this->sign_type;
		return $data;
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