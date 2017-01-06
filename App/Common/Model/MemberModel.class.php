<?php
namespace Common\Model;
class MemberModel extends \Think\Model{
	
	public function check($a,$b){
		return $a != $b ? 0 : 1;
	}
/*
 *++++++++++++++++++++++++++++++++++++++++
 | 新型加密方式（封存）
 | crc32 计算CRC值 冗余效验码
 | SHA1 计算散列值 
 | md5 计算哈希值
 | 哈希值 = CRC值 + 散列值
 *++++++++++++++++++++++++++++++++++++++++
*/
	protected function scrypt($string){
		return md5(crc32($string).SHA1($string));
	}
	
}