<?php
/*
 +-----------------------------------------
 | 关键字数据库查询
 | @Author journey<admin@libaoka.com>
 | @Date 11:43 2015-10-24
 +-----------------------------------------
 */
function searchKeywords($fromusername,$touser,$keywords){
		
		extract($_GET);
			
		$msg = "";
		
		$follow = D('public_account')->where('name="'.uniqueinfo('follow').'"')->find();
		
		if($keywords=='平台解绑' && $touser==$follow['wxid']){
							
			$user = D('user')->where('scanunionid="'.$fromusername.'"')->find();
			
			if(!empty($user)){
				
				$update = D('user')->where('id='.$user['id'])->setField('scanunionid',"");
				
				$msg .= format_text($fromusername,$touser,time(),'text','对不起,您还没有进行平台绑定.无法解除',$user['id']);
			
			}else{
				
				$modal = array(
					'touser'		=>$fromuser,
					'template_id' 	=> 'zB2cDkv7x3SiPTTXQ4PRfA07nQA2zaPTO5yW6WsAdDA',
					'url'			=> 'http://'.uniqueinfo('domain'),
					'data'			=> array(
						'first'		=> array('value'=> '你已成功与'.uniqueinfo('name').'平台账号解除绑定','color'=>'#3b98e75'),
						'keyword1'	=> array('value'=> $user,'color'=> '#000000'),
						'keyword2'	=> array('value'=> "该微信已无法接收".uniqueinfo('name').' 模板消息通知','color'=> '#000000'),
						'remark'	=> array('value'=> '如需继续获取平台账号动态消息,请到平台扫描我们的二维码绑定您的账户,请点击后查看更多详细内容','color'=> '#000000'),
					),
				);
				
				format_modal($modal,$touser);
				
				$msg .= format_text($fromusername,$touser,time(),'text',uniqueinfo('name')."开放平台商户账号消息事件通知微信号解除绑定成功!",$user['id']);
				
				
			}
			
		}else{
		
			$m = D('public_account_msg');
			
			$search = $m->where('appid="'.$appid.'" AND keywords="'.$keywords.'" AND stype=1')->select(); //精确查询关键词匹配
			
			$search1 = $m->where('appid="'.$appid.'" AND keywords like "%'.$keywords.'%" AND stype=0')->select();//模糊查询关键词匹配
			
			if(!empty($search)){ //精确查询
			
				foreach($search as $key=>$val){
					
					switch($val['msgtype']){
						
						case 'image':
						
							$msg .= format_image($fromusername,$touser,$val['addtime'],$val['msgtype'],$val['mediaid'],$val['id']);
						 
						 break;
						 
						 case 'text':
							
							$msg .= format_text($fromusername,$touser,$val['addtime'],$val['msgtype'],$val['detail'],$val['id']);
						
						 break;
						
						case 'voice':
							
							$msg .= format_voice($fromusername,$touser,$val['addtime'],$val['msgtype'],$val['mediaid'],$val['id']);
						 
							break;
							
						case 'video':
							
							$msg .= format_video($fromusername,$touser,$val['addtime'],$val['msgtype'],$val['mediaid'],$val['title'],$val['description'],$val['id']);
							
							break;
							
						case 'music':
							
							$msg .= format_music($fromusername,$touser,$val['addtime'],$val['msgtype'],$val['title'],$val['description'],strstr($val['link'],'http') ? $val['hqlink'] : "http://".$_SERVER['HTTP_HOST'].$val['link'],strstr($val['hqlink'],'http') ? $val['hqlink'] : "http://".$_SERVER['HTTP_HOST'].$val['hqlink'],$val['thumbmediaid']);
							
							break;
							
						case 'news':
							
							$item = explode(':::',$val['detail']);
							
							$article = "";
							
							$count = count($item);
							
							if($count < 10){
								
								foreach($item as $p=>$q){
									
									$news = json_decode($q,true);
									
									$url = str_replace("{id}",$val['id'],$news['url']);
									
									$url = strstr($url,'http://') || strstr($url,"https://") ? $url : "http://".$_SERVER['HTTP_HOST'].$url;
									
									$picurl = strstr($news['picurl'],'http://') || strstr($news['picurl'],"https://") ? $news['picurl'] : "http://".$_SERVER['HTTP_HOST'].$news['picurl'];
									
									$article .= "<item><Title><![CDATA[{$news['title']}]]></Title> 
												<Description><![CDATA[{$news['description']}]]></Description>
												<PicUrl><![CDATA[{$picurl}]]></PicUrl>
												<Url><![CDATA[{$url}]]></Url>
												</item>\r\n";
												
								}
								
							}else{
								
								for($i=0;$i<10;$i++){
									
									$news = json_decode($item[$i],true);
									
									$url = str_replace("{id}",$val['id'],$news['url']);
									
									$url = strstr($url,'http://') || strstr($url,"https://") ? $url : "http://".$_SERVER['HTTP_HOST'].$url;
									
									$picurl = strstr($news['picurl'],'http://') || strstr($news['picurl'],"https://") ? $news['picurl'] : "http://".$_SERVER['HTTP_HOST'].$news['picurl'];
									
									$article .= "<item><Title><![CDATA[{$news['title']}]]></Title> 
												<Description><![CDATA[{$news['description']}]]></Description>
												<PicUrl><![CDATA[{$picurl}]]></PicUrl>
												<Url><![CDATA[{$url}]]></Url>
												</item>\r\n";
									
								}
								
							}
							
							$msg .= format_news($fromusername,$touser,$val['addtime'],$val['msgtype'],$count,$article);
							
						break;
						
					}
				
				}
				
			}
			
			if(!empty($search1) && $count < 10 ){ //模糊查询
				
				foreach($search1 as $key=>$val){ //循环组装
				
					switch($val['msgtype']){
						
						case 'image':
						
							$msg .= format_image($data['formusername'],$touser,$val['addtime'],$val['msgtype'],$val['mediaid'],$val['id']);
							
						 break;
						 
						 case 'text':
						 
							$msg .= format_text($fromusername,$touser,$val['addtime'],$val['msgtype'],$val['detail'],$val['id']);
						 break;
						
						case 'voice':
						
							$msg .= format_voice($fromusername,$touser,$val['addtime'],$val['msgtype'],$val['mediaid'],$val['id']);
							
							break;
							
						case 'video':
						
							$msg .= format_video($fromusername,$touser,$val['addtime'],$val['msgtype'],$val['mediaid'],$val['title'],$val['description'].$val['id']);
							
							break;
							
						case 'music':
							$msg .= format_music($fromusername,$touser,$val['addtime'],$val['msgtype'],$val['title'],$val['description'],strstr($val['link'],'http') ? $val['link'] : "http://".$_SERVER['HTTP_HOST'].$val['link'],$license.strstr($val['hqlink'],'http') ? $val['hqlink'] : "http://".$_SERVER['HTTP_HOST'].$val['hqlink'],$val['thumbmediaid']);
							
							break;
							
						case 'news':
							
							$item = explode(':::',$val['detail']);
							
							$article = "";
							
							for($i=0;$i< 10 - $count; $i++){
								
								$news = json_decode($item[$i],true);
								
								$url = str_replace("{id}",$val['id'],$news['url']);
								
								$url = strstr($url,'http://') || strstr($url,"https://") ? $url : "http://".$_SERVER['HTTP_HOST'].$url;
								
								$picurl = strstr($news['picurl'],'http://') || strstr($news['picurl'],"https://") ? $news['picurl'] : "http://".$_SERVER['HTTP_HOST'].$news['picurl'];
								
								$article .= "<item><Title><![CDATA[{$news['title']}]]></Title> 
											<Description><![CDATA[{$news['description']}]]></Description>
											<PicUrl><![CDATA[{$picurl}]]></PicUrl>
											<Url><![CDATA[{$url}]]></Url>
											</item>\r\n";
											
							}
							
							$msg .= format_news($fromusername,$touser,$val['addtime'],$val['msgtype'],count($item),$article);
							
						break;
						
					}
					
				}
				
			}
		
		}
		
		return $msg;
	}