<?php
/**
 *
 *
 * PHP Version 5
 *
 * @category  Class
 * @file      order.php
 * @package ${NAMESPACE}
 * @author    ma_chao <ma_chao@suixingpay.com>
 */

include 'sxfCommon.php';

header("Content-type: text/html; charset=utf-8");
class vbill{
	private $mercNo         = '';
	private $tranCd         = '';
	private $version        = '';
	private $orderNo        = '';
	private $tranAmt        = '';
	private $ccy            = '';
	private $pname          = '';
	private $pnum           = '';
	private $pdesc          = '';
	private $retUrl         = '';
	private $notifyUrl      = '';
	private $payWay         = '';
	private $payChannel     = '';
	private $bankWay        = '';
	private $period         = '';
	private $ip             = '';
	private $desc           = '';
	private $encodeType     = '';
	private $userId     	= '';
	private $userName     	= '';
	
/**
 * 密钥文件的路径
 */

private static function privateKeyFilePath() { return  __dir__ .'/key/private.pem'; }

/**
 * 公钥文件的路径
 */

private static function publicKeyFilePath() { return __dir__ .'/key/public.pem'; }

	public function __construct($config){
		$this->mercNo = $config['mercNo'];
		$this->_config($config['data']);
		$this->encodeData();
	}
	
	function _config($data){
		foreach($data as $key=>$val){
			$this->$key = $val;
		}
	}
	function reqData(){
		$data = array(
			'orderNo'   => $this->orderNo,
			'tranAmt'   => $this->tranAmt,
			'ccy'       => $this->ccy,
			'pname'     => $this->pname,
			'pnum'      => $this->pnum,
			'pdesc'     => $this->pdesc,
			'retUrl'    => urldecode($this->retUrl),
			'notifyUrl' => urldecode($this->notifyUrl),
			'payWay'    => $this->payWay,
			'payChannel'=> $this->payChannel,
			'bankWay'   => $this->bankWay,
			'period'    => $this->period,
			'ip'        => $this->ip,
			'userId'    => $this->userId,
			'userName'  => $this->userName,
			'desc'      => $this->desc
		);
		return json_encode($data);
	}
	
	function encodeData(){
		$reqData = $this->reqData();
		//读取公钥
		$pu_key = file_get_contents($this->publicKeyFilePath());
		//数据加密
		$encodeData = encode($reqData,$pu_key);
		
		$this->_config(array("encodeData"=>$encodeData));
		return $encodeData;
	}

	// $reqData = json_encode($data);
	//读取公钥
	// $pu_key = file_get_contents($publicKeyFilePath);
	//读取私钥
	// $pi_key = file_get_contents($privateKeyFilePath);
	//数据加密
	// $encodeData = encode($reqData,$pu_key);

	// echo 'encodeData<br>'.$encodeData.'<br>';
	function signData(){
		
		$signData = array(
			'mercNo'  => $this->mercNo,
			'tranCd'  => $this->tranCd,
			'version' => $this->version,
			'reqData' => $this->encodeData,
			'ip'      => $this->ip
		);

		$signData = json_encode($signData);
		$signData = stripslashes($signData);
		return $signData;
	}
	// $signData = array(
		// 'mercNo'  => $mercNo,
		// 'tranCd'  => $tranCd,
		// 'version' => $version,
		// 'reqData' => $encodeData,
		// 'ip'      => $ip
	// );

	// $signData = json_encode($signData);
	// $signData = stripslashes($signData);
	//$signData='{"mercNo":"600000000000016","tranCd":"1001","version":"1.0","reqData":"zR/kh6A0LotgEcaMMjJCOuKT3EHD7z9w2pKLC2TAWkTbmCkRc9wOhOGM6V3x6GtC+t9RVykQzbiReIixPeg4P7nonLvbj5EQplO1x8kwHDhYd2oWr0ATQzITjGVxMGdboDnRm+glSD5VfD6UCXUXN4lFd/lFVaUcBQA08kujzzPJ+WT/mpE2AfCM8orccQw4LfGNKlfhhQ2eu7N9b54vXoHWsG2wa98XGtzXJvC1HVbypVDkC3+o49VR+mPFBGsz+QGSjcVyBVF9enPIKFljMVx8mAGUKH0B+X1DB7gC/UtwjMozcxA0YZt1QY/N3Wa0UkRrFzMLux4Qf1s9HIo4BJP+gvyRHXPJ4Fgj5JdJybgaNAccREpJtkFwrJbAYRBm8wxwlckOmJRFhDOR3bNhZSJqsMYH3bNRGZVPDiO+3S3lJ6yF2T+UwMg6lrugCD4nXJxXJgcaViSNso9AxWTsN/mWDH86jG+N2odMXsC4wVYk9W2luZJUJ1QUA8Du/EwkLeOFB2SMeLA24iH2yj/FeNrVyQAcxjKbixInE/2Qd5aj7EJ1Hqx1dr92fpdbdTzA09JSppZnzQwWee3hbe0we55gQfyovfKki220f7MzV6TXUb5IHrKaPxTbQLWPbpqAdTBq5g2D30LpDAKzb/X13M6W06sHfXAHqYVDYURBpX4=","ip":"172.16.40.250"}';
	// echo 'signData<br>'.$signData.'<br>';
	//签名加密
	function sign(){
		$sign = reqsign($this->signData(),openssl_get_privatekey(file_get_contents($this->privateKeyFilePath())));
		return $sign;
	}
	function sendData(){
		return array(
			"mercNo"	=> $this->mercNo,
			"tranCd"	=> $this->tranCd,
			"version"	=> $this->version,
			"reqData"	=> $this->encodeData,
			"ip"		=> $this->ip,
			"encodeType"=> $this->encodeType,
			"sign"		=> $this->sign(),
			// "reqnewData"=> $this->reqData(),
			// "signData"	=> $this->signData(),
		);
	}
	
	function verify($data){
	
		foreach($data as $key=>$val){
			$$key = $val;
		}
		if($resCode!='000000'){
			die('签名参数接收失败');
			return;
		}else{
			$result['resCode'] = 1;
		}

		//验签 准备数据
		$result= array(
			'mercNo'  => $mercNo,
			'orderNo'  => $orderNo,
			'tranCd' => $tranCd,
			'resCode' => $resCode,
			'resMsg'      => $resMsg,
			'resData' => $resData
		);
		//读取公钥
		$pu_key = file_get_contents($this->publicKeyFilePath());
		//读取私钥
		$pi_key = file_get_contents($this->privateKeyFilePath());
		
		$result=json_encode($result,JSON_UNESCAPED_UNICODE);
		
		$result = stripslashes($result);

		$result= openssl_verify($result, base64_decode($sign), $pu_key); 

		if($result !=1){
			$results['sign'] = 0;
		}else{
			$results['sign'] = 1;
		}
		//加密加签方式RSA#RSA
		$de_data=base64_decode(decode($resData,$pi_key));
		$results['deData'] = $de_data;
		return $results;
	}
}
/*<html>
<head>
    <title>To SXF Page</title>
</head>
<META http-equiv="content-type" content="text/html; charset=utf-8">
<body onLoad1="document.sxf.submit();">
<form name='sxf' action='<?php echo $payURL; ?>' method='post'>
    <input type='hidden' name='mercNo'        value='<?php echo $mercNo;?>'>
    <input type='hidden' name='tranCd'        value='<?php echo $tranCd;?>'>
    <input type='hidden' name='version'       value='<?php echo $version;?>'>
    <input type='hidden' name='reqData'       value='<?php echo $encodeData;?>'>
    <input type='hidden' name='ip'            value='<?php echo $ip;?>'>
	<input type='hidden' name='encodeType'          value='<?php echo $encodeType;?>'>
	<input type='hidden' name='sign'          value='<?php echo $sign;?>'>
    <!--<input type="submit"/>-->
</form>
</body>
</html>

*/
?>