<?php
/*
 +-------------------------------------------
 | 消息格式化
 | @Author journey<admin@libaoka.com>
 | @Date 11:08 2015-10-24
 +-------------------------------------------
 */
	function format_image($to,$from,$time,$type,$mid,$id){
						 
		 $format = "<xml>
			 <ToUserName><![CDATA[{$to}]]></ToUserName>
			 <FromUserName><![CDATA[{$from}]]></FromUserName> 
			 <CreateTime>{$time}</CreateTime>
			 <MsgType><![CDATA[{$type}]]></MsgType>
			 <Image>
			<MediaId><![CDATA[{$mid}]]></MediaId>
			</Image>
			 <MsgId>{$id}</MsgId>
		 </xml>";
		 
		return $format;
		
	 }
 /*
  +-----------------------------
  | 文本格式
  | @Author journey<admin@libaoka.com>
  | @Date 10:47 2015-9-4
  +-----------------------------
  */
	function format_text($to,$from,$time,$type,$detail,$id){
		  
		$format = "<xml>
			 <ToUserName><![CDATA[{$to}]]></ToUserName>
			 <FromUserName><![CDATA[{$from}]]></FromUserName> 
			 <CreateTime>{$time}</CreateTime>
			 <MsgType><![CDATA[{$type}]]></MsgType>
			 <Content><![CDATA[{$detail}]]></Content>
			 <MsgId>{$id}</MsgId>
		 </xml>";
		 
		return $format;
		
	 }
 /*
  +-----------------------------
  | 链接格式
  | @Author journey<admin@libaoka.com>
  | @Date 10:47 2015-9-4
  +-----------------------------
  */
	function format_link($to,$from,$time,$type,$title,$desc,$url,$id){
		  
		$format = "<xml>
					<ToUserName><![CDATA[{$to}]]></ToUserName>
					<FromUserName><![CDATA[{$from}]]></FromUserName>
					<CreateTime>{$time}</CreateTime>
					<MsgType><![CDATA[{$type}]]></MsgType>
					<Title><![CDATA[{$title}]]></Title>
					<Description><![CDATA[{$desc}]]></Description>
					<Url><![CDATA[{$url}]]></Url>
					<MsgId>{$id}</MsgId>
					</xml>"; 
		 
		return $format;
		
	 }
 /*
  +-----------------------------
  | 地理位置格式
  | @Author journey<admin@libaoka.com>
  | @Date 10:47 2015-9-4
  +-----------------------------
  */
	function format_location($to,$from,$time,$type,$latitude,$loongitude,$scale,$label,$id){
		  
		$format = "<xml>
					<ToUserName><![CDATA[{$to}]]></ToUserName>
					<FromUserName><![CDATA[{$from}]]></FromUserName>
					<CreateTime>{$time}</CreateTime>
					<MsgType><![CDATA[{$type}]]></MsgType>
					<Location_X>{$latitude}</Location_X>
					<Location_Y>{$longitude}</Location_Y>
					<Scale>{$scale}</Scale>
					<Label><![CDATA[{$label}]]></Label>
					<MsgId>{$id}</MsgId>
					</xml>";  
		 
		return $format;
		
	 }
 /*
  +-------------------------
  | 语音模式
  | @Author journey<admin@libaoka.com>
  | @Date 10:50 2015-9-4
  +-------------------------
  */
	function format_voice($to,$from,$time,$type,$mid,$id){
		
		$format = "<xml>
			 <ToUserName><![CDATA[{$to}]]></ToUserName>
			 <FromUserName><![CDATA[{$from}]]></FromUserName> 
			 <CreateTime>{$time}</CreateTime>
			 <MsgType><![CDATA[{$type}]]></MsgType>
			 <Voice>
			<MediaId><![CDATA[{$mid}]]></MediaId>
			</Voice>
			 <MsgId>{$id}</MsgId>
		 </xml>";
		 
		 return $format;
		 
	}
/*
 +-------------------------
 | 视频格式
 | @Author journey<admin@libaoka.com>
 | @Date 10:54 2015-9-4
 +-------------------------
 */
	function format_video($to,$from,$time,$type,$mid,$title,$desc,$id){
						
		$format = "<xml>
			 <ToUserName><![CDATA[{$to}]]></ToUserName>
			 <FromUserName><![CDATA[{$from}]]></FromUserName> 
			 <CreateTime>{$time}</CreateTime>
			 <MsgType><![CDATA[{$type}]]></MsgType>
			 <Video>
			<MediaId><![CDATA[{$mid}]]></MediaId>
			<Title><![CDATA[{$title}]]></Title>
			<Description><![CDATA[{$desc}]]></Description>
			</Video>
			 <MsgId>{$id}</MsgId>
		 </xml>";
		 
		 return $format;
		 
	}
/*
 +--------------------------
 | 音乐格式
 | @Author journey<admin@libaoka.com>
 | @Date 10:57 2015-9-4
 +--------------------------
 */
	function format_music($to,$from,$time,$type,$title,$desc,$url,$hqurl,$mid){
							
		$format = "<xml>
			 <ToUserName><![CDATA[{$to}]]></ToUserName>
			 <FromUserName><![CDATA[{$from}]]></FromUserName> 
			 <CreateTime>{$time}</CreateTime>
			 <MsgType><![CDATA[{$type}]]></MsgType>
			 <Music>
			 <Title><![CDATA[{$title}]]></Title>
			<Description><![CDATA[{$desc}]]></Description>
			<MusicUrl><![CDATA[{$url}]]></MusicUrl>
			<HQMusicUrl><![CDATA[{$hqurl}]]></HQMusicUrl>";
			
		$format .=	$mid != '' ? "<ThumbMediaId><![CDATA[{$mid}]]></ThumbMediaId>" : "";
		$format .= "
		</Music>
		 </xml>";
	 
		return  $format;
		
	}
/*
 +-----------------------
 | 新闻格式
 | @Author journey<admin@libaoka.com>
 | @Date 11:01 2015-9-4
 +-----------------------
 */
	function format_news($to,$from,$time,$type,$number,$article){
							
		$format = "<xml>
				<ToUserName><![CDATA[{$to}]]></ToUserName>
				<FromUserName><![CDATA[{$from}]]></FromUserName>
				<CreateTime>{$time}</CreateTime>
				<MsgType><![CDATA[{$type}]]></MsgType>
				<ArticleCount>{$number}</ArticleCount>
				<Articles>
				{$article}
				</Articles>
			</xml> ";
		
		return $format;
		
	}
