<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
		$this->checkLogin();
        $this->display();
    }
	
	private function checkLogin(){
		if(session("sessiontime") && time() - session("sessiontime") < 1800){
			redirect(U("Cpanel/index"));
		}
	}
}