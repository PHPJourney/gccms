<?php
namespace Common\Controller;
class CommonController extends \Think\Controller{
	
	public function _initialize(){
		$this->setting = $this->setting();
		$this->state($this->setting);
	}

	protected function setting(){
		return D("Setting")->read();
	}
/*
 +---------------------
 | 重新定义静态缓存
 |
 |
 +---------------------
 */
	protected function state($setting){
		C("HTML_CACHE_ON", $setting['htmlcache']=='' ? C('HTML_CACHE_ON') : $setting['htmlcache']);
		if($setting['htmlcacherules'] != ''){
			$rules = explode("\r\n",str_replace(array("	"," "),array("",""),htmlspecialchars_decode($setting['htmlcacherules'])));
			foreach($rules as $key=>$val){
				if($val!=''){
					$rule = explode("|",$val);
					$cacherules[$rule[0]] = $rule[3] ? array($rule[1],$rule[2],$rule[3]) : array($rule[1],$rule[2]);
				}
			}
		}
		C("HTML_CACHE_TIME",$setting['htmlcachetime']=='' ? C('HTML_CACHE_TIME') : $setting['htmlcachetime']);
		C("HTML_FILE_SUFFIX",$setting['htmlfilesuffix']=='' ? C('HTML_FILE_SUFFIX') : $setting['htmlfilesuffix']);
		C("HTML_CACHE_RULES",!$cacherules ? C("HTML_CACHE_RULES") : $cacherules);
	}
}