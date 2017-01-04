<?php
/**
 * Created by PhpStorm.
 * User: MaChao
 * Date: 16/4/29
 * Time: 上午10:45
 */

header("Content-type: text/html; charset=utf-8");

include 'merchantProperties.php';

//加密    请修改成循环，我不会写
function encode($reqData, $pu_key)
{	
  	$pub_key = openssl_get_publickey($pu_key);
	for($i=0;$i< ceil(strlen($reqData) / 245);$i++){
		$begin = $i * 245;
		$end = $begin + 245;
		openssl_public_encrypt(substr($reqData,$begin,$end),$en[$i],$pu_key);
	}
	return base64_encode(implode("",$en));
    // openssl_public_encrypt(substr($reqData, 0, 245), $en1, $pub_key);
    // openssl_public_encrypt(substr($reqData, 245), $en2, $pub_key);
    // return base64_encode($en1 . $en2);
}


//解密    请修改成循环，我不会写
function decode($en, $pi_key)
{
    $de1 = '';
    $de2 = '';
    $en0 = base64_decode($en);
    $en11 = substr($en0, 0, 256);
    $en21 = substr($en0, 256);
	$pi_key = openssl_get_privatekey($pi_key);
    openssl_private_decrypt($en11, $de1, $pi_key);
    openssl_private_decrypt($en21, $de2, $pi_key);
    return base64_encode($de1 . $de2);
}


/**
 * @param $reqData
 * @param $pi_key
 * 签名
 */
function reqsign($signData, $pi_key)
{
    openssl_sign($signData, $sign, $pi_key, OPENSSL_ALGO_SHA1);

    return base64_encode($sign);
}

function httpRequestPost($url, $param)
{
    $curl = curl_init(absoluteUrl($url));

    curl_setopt($curl, CURLOPT_HEADER, 0); // 过滤HTTP头
//    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
//        'Content-Type: application/vnd.ehking-v1.0+json'
//    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);// 显示输出结果
    curl_setopt($curl, CURLOPT_POST, true); // post传输数据
    curl_setopt($curl, CURLOPT_POSTFIELDS, $param);// post传输数据
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//SSL证书认证
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);//2严格认证,0不认证
    $responseText = curl_exec($curl);
    if (curl_errno($curl) || $responseText === false) {

        var_dump(curl_error($curl));

        exit;
    }

    curl_close($curl);

    //$data = json_decode($responseText, true);

    if ($responseText === null) {

        echo "ResponsData data is null ";
    }

    return $responseText;
}


function absoluteUrl($url, $param = null)
{
    if ($param !== null) {
        $parse = parse_url($url);

        $port = '';
        if (($parse['scheme'] == 'http') && (empty($parse['port']) || $parse['port'] == 80)) {
            $port = '';
        } else {
            $port = $parse['port'];
        }
        $url = $parse['scheme'] . '//' . $parse['host'] . $port . $parse['path'];

        if (!empty($parse['query'])) {
            parse_str($parse['query'], $output);
            $param = array_merge($output, $param);
        }
        $url .= '?' . http_build_query($param);
    }

    return $url;
}


/**
 * Curl版本
 * 使用方法：
 * $post_string = "app=request&version=beta";
 * request_by_curl('http://www.qianyunlai.com/restServer.php', $post_string);
 */
function request_by_curl($url, $data)
{
    $curl = curl_init(); // 启动一个CURL会话
    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
    //curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
    curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
    curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
    curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
    curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
    $tmpInfo = curl_exec($curl); // 执行操作
    if (curl_errno($curl)) {
        echo 'Errno' . curl_error($curl);//捕抓异常
    }
    curl_close($curl); // 关闭CURL会话
    return $tmpInfo; // 返回数据
}
function decodeUnicode($str)
{
    return preg_replace_callback('/\\\\u([0-9a-f]{4})/i',
        create_function(
            '$matches',
            'return mb_convert_encoding(pack("H*", $matches[1]), "UTF-8", "UCS-2BE");'
        ),
        $str);
}
?>