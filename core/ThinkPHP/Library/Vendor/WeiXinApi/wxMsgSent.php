<?php

	const CALLBACK = "/WeixinApi/callback";
	
	const REDIRECT = 'https://mp.weixin.qq.com/cgi-bin/componentloginpage';
	
	const PARAUTHCODE =  "https://api.weixin.qq.com/cgi-bin/component/api_create_preauthcode?component_access_token=";
	
	const GETTOKEN = "https://api.weixin.qq.com/cgi-bin/component/api_component_token";
	
	const ACCESS_TOKEN = "https://api.weixin.qq.com/sns/oauth2/access_token?";
	
	const GET_USER_INFO  = "https://api.weixin.qq.com/cgi-bin/component/api_query_auth?component_access_token=";//换取公众号授权信息接口
	
	const GET_REFRESH_PUBLIC_ACCOUNT_TOKEN = "https://api.weixin.qq.com/cgi-bin/component/api_authorizer_token?component_access_token=";//获取刷新公众号刷新令牌
	
	const GET_AUTHORIZER_INFO = "https://api.weixin.qq.com/cgi-bin/component/api_get_authorizer_info?component_access_token=";//获取授权方账户信息
	
	const REFRESH_TOKEN = "https://api.weixin.qq.com/sns/oauth2/refresh_token?appid={appid}&grant_type=refresh_token&refresh_token=";//刷新令牌 手动接口
	
	const FANS = "https://api.weixin.qq.com/cgi-bin/user/get?access_token={accesstoken}&next_openid=";//access_token API
	
	const GETMENU = "https://api.weixin.qq.com/cgi-bin/get_current_selfmenu_info?access_token="; //菜单接口
	
	const ENCODINGAESKEY = "fYeRtLire6He4EExe1r6BSiGTL1ApXUmO1JEOTZwhdj39MnoVE0prF4SP3Kc4HWMlCDFyoe3S0PX294ORq2z1EoPlnD67CXkfP6feLZCuxySXIqObZVmP3opGBQgZMCD";//第三方服务托管授权key 第三方服务网站 https://api.lc  提供认证网站授权访问 为非认证公众号做跳转

	const SCENELIST = "http://h5.webifynetwork.com/Sync-getlist.html?token=KYzmyWGeqAWb74uEfDKIb89IMikTkcEFvHXrz9mfnK1vEkjnk&signature=";//批量获取场景列表
	
	const REDPACK = "https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack";//现金红包发送
	
	const KFAPI = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token="; //客服消息接口地址
	
	const MODALAPI = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=";//模板消息接口
	
	const USERINFOAPI = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=";//用户网页授权API
	
	const REDPACKCALLBACK = "https://api.mch.weixin.qq.com/mmpaymkttransfers/gethbinfo";//红包查询接口
	
	const AUTHORIZAR = "https://api.lc/Api/Weixin/public_account_auth";//外部独立域名授权公众号
	
	const ORDERQUERY = "https://api.mch.weixin.qq.com/pay/orderquery"; //订单查询接口
	
	include_once "textMsg.php";
	
	include_once "imageMsg.php";
	
	include_once "voiceMsg.php";
	
	include_once "videoMsg.php";
	
	include_once "locationMsg.php";
	
	include_once "linkMsg.php";

	include_once "redpack.php";

	include_once "MsgEventPush.php";

	include_once "newsMsg.php";

	include_once "format.php";

	include_once "searchKeywords.php";

	include_once "dataCrypt.php";

?>