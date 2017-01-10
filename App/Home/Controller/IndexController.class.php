<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
		extract(I(''));
       // $cache = S(array("type"=>"memcache",'host'=>"127.0.0.1",'port'=>11211,"length"=>10,"prefix"=>"gift","expire"=>60));
	   // S('name',$uid);
	   echo "原文：".$uid."<br>";
	   echo "CRC32:".crc32($uid)."<br>";
	   echo "SHA1:".SHA1($uid)."<br>";
	   echo "MD5:".md5($uid)."<br>";
	   echo "MD5 GROUP:". MD5(crc32($uid).SHA1($uid));
	   // echo S("name");
		// $cache->name = $uid; //设置缓存
		// echo $value = $cache->name;//获取缓存
		// print_r($value);
		// unset($cache->uid);//删除缓存
    }
}