<?php
define('AppKey'     , '21345199');  //正式环境用自已的 AppKey
define('AppSecret'  , 'c13bdd5c851862182a099eda68efe908');  //正式环境用自已的 AppSecret
define('Gateway'    , 'http://gw.api.taobao.com/router/rest');
define('Format',     'json');
define('SignMethod', 'md5');
define('APIVersion', '2.0');
define('SDKVersion', 'top_api_php_1.0');
function sign($params) {
    $items = array();
    foreach($params as $key => $value) $items[$key] = $value;
    ksort($items);
    $s = AppSecret;
    foreach($items as $key => $value) {
        $s .= "$key$value";
    }
    $s .= AppSecret;
    return strtoupper(md5($s));
}
function decode_top_parameters($top_parameters) {
    $params = array();
    $param_array = explode('&', base64decode($top_parameters));
    foreach($param_array as $p) {
        list($key, $value) = explode('=', $p);
        $params[$key] = $value;
    }
    return $params;
}
class TopRequest {
    private $method_name;
    private $api_params = array();
    function TopRequest($method_name) {
        $this->method_name = $method_name;
    }
    function set_param($param_name, $param_vaule) {
        $this->api_params[$param_name] = $param_vaule;
    }
    function get_api_params() {
        return $this->api_params;
    }
    function get_method_name() {
        return $this->method_name;
    }
    function execute($session = '') {
        $client = new TopClient;
        return $client->execute($this, $session);
    }
}
class TopClient {
    function execute($request, $session = '') {
        $sys_params = array(
                'app_key' => AppKey,
                'format'  => Format,
                'v'       => APIVersion,
                'sign_method' => SignMethod,
                'partner_id'  => SDKVersion
        );
        $api_params = $request->get_api_params();
        $sys_params['method'] = $request->get_method_name();
        $sys_params['timestamp'] = date("Y-m-d H:i:s");
        if($session != '') {
            $sys_params['session'] = $session;
        }
        $sys_params['sign'] = sign(array_merge($sys_params, $api_params));
        $param_string = '';
        foreach($sys_params as $p => $v) {
            $param_string .= "$p=" . urlencode($v) . "&";
        }
        $url = Gateway . '?' . substr($param_string, 0, -1);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $api_params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $postResult = curl_exec($ch);
        if (curl_errno($ch)){
            throw new Exception(curl_error($ch), 0);
        } else {
            $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if (200 !== $httpStatusCode) {
                throw new Exception($postResult, $httpStatusCode);
            }
        }
        curl_close($ch);
        $obj = json_decode($postResult);
        foreach($obj as $k => $v) {
            $obj = $v;
        }
        return $obj;
    }
}

function object_array($array)
{
    if(is_object($array))
    {
        $array = (array)$array;
    }
    if(is_array($array))
    {
        foreach($array as $key=>$value)
        {
            $array[$key] = object_array($value);
        }
   }
   return $array;
}
?>