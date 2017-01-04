<?php
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',true);
// 定义备份路径
define('DATABASE_PATH','./DbbakfkEu6Eqt3SRMjMCTM3uELK4StyMjWAOJ/');
// 定义应用目录
// define('APP_NAME','CMS');

define('APP_PATH','./App/');
// 引入ThinkPHP入口文件
require '../core/ThinkPHP/ThinkPHP.php';

// 亲^_^ 后面不需要任何代码了 就是如此简单
