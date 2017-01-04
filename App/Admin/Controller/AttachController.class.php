<?php
namespace Admin\Controller;
use Think\Controller;
class AttachController extends Controller{
	
	public function upload(){
		$up = new \Think\Upload();
		$up->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$up->rootPath = "../groupcoin/";
		$up->savePath  = '/Attachment/Uploads/'; // 设置附件上传目录
		$up->subName  = array('date','Ymd');
		$info = $up->uploadOne($_FILES['attr']);
		if($info){
			$this->ajaxReturn($info,"xml");
		}else{
			$this->ajaxReturn($up->getError(),"xml");
		}
	}
	
	public function upload_thumb(){
		$up = new \Think\Upload();
		$up->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$up->rootPath = "../groupcoin/";
		$up->savePath  = '/Attachment/Uploads/'; // 设置附件上传目录
		$up->subName  = array('date','Ymd');
		$info = $up->uploadOne($_FILES['attr']);
		if($info){
			$setting = D("Setting")->read();
			$image = C("setting.imglib") == 0 ? new \Think\Image() : new \Think\Image("Imagick");
			$image->open(".".$info['savepath'].$info['savename']);
			$width = $image->width();
			$height = $image->height();
			$type = $image->type();
			$mime = $image->mime();
			$size = $image->size();
			$savew = $width / 100 * $setting['thumbquality'];
			$saveh = $height / 100 * $setting['thumbquality'];
			$water = $setting['watermarkstatus_article'];
			$waterminwidth = $setting['watermarkminwidth_article'];
			$waterminheight = $setting['watermarkminheight_article'];
			if($water != 0 && $width >= $waterminwidth && $height >= $waterminheight ){
				$watertype = $setting['watermarktype_article'];
				$wateropa = $type == "gif" ? $setting['watermarktrans_article'] : $setting['watermarkquality_article'];
				$watertext = $setting['watermarktext_article'];
				switch($watertype){
					case 0:
						$image->water("./Attachment/water/watermark.gif",$water,$wateropa)->save(".".$info['savepath'].$info['savename']);
						$image->thumb($savew,$saveh)->save(".".$info['savepath']."thumb_".$info['savename']);
					break;
					case 1:
						$image->water("./Attachment/water/watermark.png",$water,$wateropa)->save(".".$info['savepath'].$info['savename']);
						$image->thumb($savew,$saveh)->save(".".$info['savepath']."thumb_".$info['savename']);
					break;
					case 2:
						$image->text($watertext,"./Public/attach/fonts/".$setting['watermarktext_fontpath_article'],$setting['watermarktext_size_article'],$setting['watermarktext_color_article'],$water)->save(".".$info['savepath'].$info['savename']);
						$image->thumb($savew,$saveh)->save(".".$info['savepath']."thumb_".$info['savename']);
					break;
				}
				
			}else{
				$image->thumb($savew,$saveh)->save(".".$info['savepath']."thumb_".$info['savename']);//生成缩略图
			}
			$info['thumbimg'] = $info['savepath']."thumb_".$info['savename'];
			$this->ajaxReturn($info,"xml");
		}else{
			$this->ajaxReturn($up->getError(),"xml");
		}
	}
}