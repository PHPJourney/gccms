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
//读取公钥
$pu_key = file_get_contents($publicKeyFilePath);
//读取私钥
$pi_key = file_get_contents($privateKeyFilePath);

//获取数据
$_t         = $_REQUEST['_t'];

print_r('http回调结果--><br/>'.$_t.'<br/>');

//解析json
$de_json = json_decode($_t,TRUE);

$mercNo=$de_json['mercNo'];
$tranCd=$de_json['tranCd'];
$orderNo=$de_json['orderNo'];
$resCode=$de_json['resCode'];
$resMsg=$de_json['resMsg'];
if($resCode=='000000'){
	print_r('接收成功'.'<br/>');
}else{
	print_r('失败'.'<br/>');
	return;
}


$resData=$de_json['resData'];
$sign=$de_json['sign'];

//验签 准备数据
$result= array(
    'mercNo'  => $mercNo,
    'orderNo'  => $orderNo,
    'tranCd' => $tranCd,
    'resCode' => $resCode,
    'resMsg'      => $resMsg,
	'resData' => $resData
);

$result=json_encode($result,JSON_UNESCAPED_UNICODE);
$result = stripslashes($result);
print_r('验签内容-->'.'<br/>'.$result.'<br/>');

$sign_result= openssl_verify($result, base64_decode($sign), $pu_key); 

print_r('验签结果--><br/>'.$sign_result.'<br/>');

if(!$sign_result=='1'){
	print_r('验签失败'.'<br/>');
	return;
}
print_r('验签成功'.'<br/>');

//解密
$encodeType=$de_json['encodeType'];
//加密加签方式RSA#RSA
$de_data=base64_decode(decode($resData,$pi_key));
print_r('解密resData结果-->'.$de_data.'<br/>');
?>


