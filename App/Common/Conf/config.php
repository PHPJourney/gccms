<?php
return array(
    'MULTI_MODULE'          =>  true, // 是否允许多模块 如果为false 则必须设置 DEFAULT_MODULE
    'DEFAULT_MODULE'        =>  "Admin", // 是否允许多模块 如果为false 则必须设置 DEFAULT_MODULE
    'DEFAULT_THEME'         =>  'default',	// 默认模板主题名称
	'URL_ROUTER_ON'         =>  true,   // 是否开启URL路由
	'URL_HTML_SUFFIX'       =>  'shtml',  // URL伪静态后缀设置
	'LOG_FILE_SIZE' 		=>  40960,   // 日志文件大小限制
	'LOG_TYPE'              =>  'File', // 日志记录类型 默认为文件方式
	// 'LOG_LEVEL' 			=>  'EMERG,ALERT',   // 允许记录的日志级别
    'LOG_LEVEL'             =>  'EMERG,ALERT,CRIT,ERR,WARN,NOTIC,INFO,DEBUG,SQL',// 允许记录的日志级别'EMERG,ALERT,CRIT,ERR,WARN,NOTIC,INFO,DEBUG,SQL',  // 允许记录的日志级别
	'LOG_EXCEPTION_RECORD' 	=>  true,   // 是否记录异常信息日志
	'LOG_RECORD' 			=>  true,   // 默认不记录日志
	// "SHOW_PAGE_TRACE"		=> true,
	'URL_MODEL'				=> 2,
	'MODULE_ALLOW_LIST'    	=>    array('Home',"Admin"),
	'TMPL_PARSE_STRING' 	=> array (
		'__PUBLIC__'		=> '/Public',
	),
	'TMPL_EXCEPTION_FILE'     => APP_PATH.'Common/Tpl/dispatch_jump.tpl', // 500错误
	"DB_TYPE"				=> "mysqli",
	"DB_HOST"				=> "localhost",
	"DB_PORT"				=> "3306",
	"DB_NAME"				=> "cms",
	"DB_USER"				=> "cms",
	"DB_PWD"				=> "cms",
    'DB_PREFIX'             =>  'gccms_',    // 数据库表前缀
	'TOKEN_ON'      		=>    true,  // 是否开启令牌验证 默认关闭
	'TOKEN_NAME'    		=>    '__hash__',    // 令牌验证的表单隐藏字段名称，默认为__hash__
	'TOKEN_TYPE'    		=>    'md5',  //令牌哈希验证规则 默认为MD5
	'TOKEN_RESET'   		=>    true,  //令牌验证出错后是否重置令牌 默认为true
	"memory"	=> array(
		"redis"	=> array(
			'server'	=> false,
			"config"	=> array(
				"port"			=> 6379,
				"pconnect"		=> 1,
				"timeout"		=> 0,
				"serializer"	=> 1,
				"requirepass"	=> '',
			),
		),
		"memcache"	=> array(
			'server'	=> true,
			"config"	=> array(
				"port"		=> 11211,
				"pconnect"	=> 1,
				"timeout"	=> 1,
			),
		),
		"apc"	=> array(
			'server'	=> true,
			"config"	=> array(),
		),
		"xcache"	=> array(
			'server'	=> true,
			"config"	=> array(),
		),
		"eaccelerator"	=> array(
			'server'	=> true,
			"config"	=> array(),
		),
		"wincache"	=> array(
			'server'	=> false,
			"config"	=> array(),
		),
	),
	"HTML_CACHE_ON"		=> true,
	"HTML_CACHE_RULES"	=> array(
		// "index:index"	=> array("index","6000"),
	),
);