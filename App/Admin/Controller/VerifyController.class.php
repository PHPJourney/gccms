<?php
namespace Admin\Controller;
use Think\Controller;
class VerifyController extends Controller {
    public function code(){
		$verify = new \Think\Verify();
		$verify->codeSet = '0123456789'; 
		$verify->entry();
    }
}