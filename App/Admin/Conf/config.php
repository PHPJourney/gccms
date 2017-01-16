<?php
return array(
	'LOG_DB_RECORD'			=>  true,   // 开启日志数据库记录
	'LOG_DB_TABLES'			=>  "logrecord",   // 日志记录数据库表名，默认 log 
	'LOG_DB_TAGS'			=>  8,   // 日志记录数据库标记长度 
	'LOG_FILE_SIZE' 		=>  40960,   // 日志文件大小限制
	'LOG_DB_FIELDS'			=>  "logtags,logtext",   // 日志记录数据库字段 0为tags 1为内容
	"SUB_DOMAIN_MODE"		=> false,//是否开启子域名模式
);