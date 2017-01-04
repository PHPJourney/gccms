<?php
// +----------------------------------------------------------------------
// | TOPThink [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2011 http://topthink.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

namespace Think\Log\Driver;

class File {

    protected $config  =   array(
        'log_time_format'   =>  ' c ',
        'log_file_size'     =>  2097152,
        'log_path'          =>  '',
    );

    // 实例化并传入参数
    public function __construct($config=array()){
		$this->config['log_file_size'] = C("LOG_FILE_SIZE");
        $this->config   =   array_merge($this->config,$config);
    }

    /**
     * 日志写入接口
     * @access public
     * @param string $log 日志信息
     * @param string $destination  写入目标
     * @return void
     */
    public function write($log,$destination='') {
        $now = date($this->config['log_time_format']);
        if(empty($destination))
            $destination = $this->config['log_path'].date('y_m_d').'.log';
        // 自动创建日志目录
        $log_dir = dirname($destination);
        if (!is_dir($log_dir)) {
            mkdir($log_dir, 0755, true);
        }        
        //检测日志文件大小，超过配置大小则备份日志文件重新生成
        if(is_file($destination) && floor($this->config['log_file_size']) <= filesize($destination) ){
			if(false !== C("LOG_DB_RECORD")){
				$datakey = $this->datakey(C("LOG_DB_FIELDS"));
				$data = array(
					"$datakey[0]"	=> $this->rand_string(C("LOG_DB_TAGS")),
					"$datakey[1]"	=> file_get_contents($destination),
				);
				$table = C('LOG_DB_TABLES');
				$result = D($table)->add($data);
				if(false !== $result){
					unlink($destination);
				}
			}else{
              rename($destination,dirname($destination).'/'.time().'-'.basename($destination));
			}
		}
        error_log("[{$now}] ".$_SERVER['REMOTE_ADDR'].' '.$_SERVER['REQUEST_URI']."\r\n{$log}\r\n", 3,$destination);
    }
	
	public function datakey($fields){
		$field = explode(",",$fields);
		return $field;
	}
	
	private function rand_string($len = 6, $type = '', $addChars = '') {
		$str = '';
		switch ($type) {
			case 0 :
				$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz' . $addChars;
				break;
			case 1 :
				$chars = str_repeat ( '0123456789', 3 );
				break;
			case 2 :
				$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' . $addChars;
				break;
			case 3 :
				$chars = 'abcdefghijklmnopqrstuvwxyz' . $addChars;
				break;
			default :
				// 默认去掉了容易混淆的字符oOLl和数字01，要添加请使用addChars参数
				$chars = 'ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789' . $addChars;
				break;
		}
		if ($len > 10) { //位数过长重复字符串一定次数
			$chars = $type == 1 ? str_repeat ( $chars, $len ) : str_repeat ( $chars, 5 );
		}
		if ($type != 4) {
			$chars = str_shuffle ( $chars );
			$str = substr ( $chars, 0, $len );
		} else {
			// 中文随机字
			for($i = 0; $i < $len; $i ++) {
				$str .= $this->msubstr ( $chars, floor ( mt_rand ( 0, mb_strlen ( $chars, 'utf-8' ) - 1 ) ), 1 );
			}
		}
		return $str;
	}
	
	
/*
 +-----------------------------
 | @Author journey
 | @email admin@libaoka.com
 | @Date 2015-04-20
 | @Desc 字符串截取
 +-----------------------------
 */
	private function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true) {
		if(function_exists("mb_substr"))
		$slice = mb_substr($str, $start, $length, $charset);
		elseif(function_exists('iconv_substr')) {
			$slice = iconv_substr($str,$start,$length,$charset);
		}else{
			$re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
			$re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
			$re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
			$re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
			preg_match_all($re[$charset], $str, $match);
			$slice = join("",array_slice($match[0], $start, $length));
		}
		return $suffix ? $slice.'...' : $slice;
	}
}
