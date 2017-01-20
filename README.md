# `GCCMS`

[![GCCMS](http://groupcoin.tech/Public/floderIcon/tplsecret.png)](http://groupcoin.tech "在线模板管理安全验证")<br>
[![GCCMS](http://groupcoin.tech/Public/floderIcon/tplModel.png)](http://groupcoin.tech "在线模板分组管理")<br>
[![GCCMS](http://groupcoin.tech/Public/floderIcon/tplView.png)](http://groupcoin.tech "在线模板视图管理")<br>
[![GCCMS](http://groupcoin.tech/Public/floderIcon/tplTheme.png)](http://groupcoin.tech "在线模板视图管理")<br>
[![GCCMS](http://groupcoin.tech/Public/floderIcon/themetpl.png)](http://groupcoin.tech "在线模板视图文件管理")<br>
#### 项目适用于对THINKPHP框架比较熟悉的用户
Version：0.0.1（初版）<br>
`GCCMS` UI框架使用 @pintuer，富媒体编辑器采用 @xhEditor，Excel为PHPExcel插件，后台核心框架为THINKPHP3.2.3<br>
[开源地址](https://github.com/PHPJourney/gccms.git "Github") https://github.com/PHPJourney/gccms.git<br>
[官网地址](http://groupcoin.tech "官方网站") http://groupcoin.tech
#### `GCCMS`是基于THINKPHP3.2.3 框架开发的一款基础功能管理后台CMS，其中集成了众多用户常用功能
##### 用户系统
##### 全局设置
##### 网站设置
 预留接口
### 电子商务
 对所有的支付接口类别以及参数进行集中管理
### 文章管理
 提供文章分类增删改查，满足用户多类别的文章发布需求
### 站长工具
##### 菜单管理
 允许开发人员灵活管理后台显示列表，一键排序、批量删除、创建、添加
##### 更新缓存
 更新缓存接口提供三类缓存更新（数据缓存、模板缓存、日志缓存），UI页面采用轮询模式在后台单独执行每一项任务，后台业务具体执行流程请自己拓展
##### 更新统计
 如果有需要，开发人员可以执行拓展新的统计需求，以满足自己的实际操作
##### 运行记录
 我们的后台设计之初，针对数据库设计到的更新、删除、增加操作进行了日志记录，用户可以通过它了解到系统每时每刻的变化
##### 计划任务
 计划任务将调用thinkphp的定时任务cron功能完成，目前不支持，开发人员可以自行拓展
##### 备份数据库
 该功能为完成品，随时都可以使用，我们提供的数据库备份功能将把数据库备份至文件服务器中的入口文件定义常量 DATABASE_PATH ；备份文件名以时间戳+卷名完成。同时我们还支持对数据表进行选择性备份、优化、以及表的修复<br>
```php
 define("DATABASE_PATH",'./*'); //入口文件此处定义数据库备份路径文件夹，需要确保有写权限
```
##### 还原数据库 
 该功能可以让你任意时间对指定备份时间段的数据进行还原操作
 
