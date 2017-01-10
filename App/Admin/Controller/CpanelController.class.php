<?php
namespace Admin\Controller;
class CpanelController extends BaseController {
	
	public function index(){
		$this->display();
	}
	
	public function info(){
		if(IS_POST){
			extract(I(''));
			$data['_sql'] = "站点信息";
			$up = D("Setting")->update($data);
			$this->checkBoolean($up);
		}else{
			$this->display();
		}
	}
	
	public function log(){
		$this->log = D("Logrecord")->read();
		$this->display();
	}
	
	public function runtimeshow(){
		extract(I(''));
		header("Content-Type:text/plain;charset=utf-8");
		$log = D("operationLog")->where(array("id"=>$id))->find();
		$this->show( '
<link href="//cdn.bootcss.com/highlight.js/8.0/styles/monokai_sublime.min.css" rel="stylesheet">
<pre>
    <code style="word-break:break-all;overflow:auto">
'. implode("\r\n",unserialize($log['sql'])) .'
    </code>
</pre>
<script src="//cdn.bootcss.com/highlight.js/8.0/highlight.min.js"></script>
<script>hljs.initHighlightingOnLoad();</script>');
	}
	
	public function logshow(){
		extract(I(''));
		header("Content-Type:text/plain;charset=utf-8");
		$log = D("logrecord")->where(array("logtags"=>$tags))->find();
		$this->show( '
<link href="//cdn.bootcss.com/highlight.js/8.0/styles/monokai_sublime.min.css" rel="stylesheet">
<pre>
    <code style="word-break:break-all;overflow:auto">
'. $log['logtext'] .'
    </code>
</pre>
<script src="//cdn.bootcss.com/highlight.js/8.0/highlight.min.js"></script>
<script>hljs.initHighlightingOnLoad();</script>');
	}
	
	public function profile(){
		extract(I(''));
		$this->cate = $cate;
		$this->display();
	}
	
	public function ec(){
		if(IS_POST){
			extract(I(''));
			$data['_sql'] = "站点信息";
			$up = D("Setting")->update($data);
			$this->checkBoolean($up);
		}else{
			$this->display();
		}
	}
	
	public function recharge(){
		$this->pay = D("PayConfig")->read();
		$this->display();
	}
	
	public function recharge_add(){
		if(IS_POST){
			extract(I(''));
			$data['__hash__'] = $__hash__;
			$data['_type'] = "add";
			$map = array(
				"tags"	=> $data['tags'],
			);
			$up = D("PayConfig")->update($data,$map);
			$this->checkBoolean($up);
		}else{
			$this->display();
		}
	}
	
	public function recharge_log(){
		$this->recharge = D("Recharge")->read();
		$payconfig = D("PayConfig")->read();
		foreach($payconfig['list'] as $key=>$val){
			$list[$val['tags']] = $val['name'];
		}
		$this->rechargestatus = array("未到账","已到账","已取消");
		$this->payconfig = $list;
		$this->display();
	}
	
	public function rechargestatus(){
		extract(I(''));
		$up = D("Recharge")->update($id);
		$this->checkBoolean($up);
	}
	
	public function pay_config(){
		extract(I(''));
		if(IS_POST){
			$data['_sql'] = "$tags 支付配置";
			$up = D("Setting")->update($data);
			$this->checkBoolean($up);
		}else{
			$this->tags = $tags;
			$this->display();
		}
	}
	
	public function oempay(){
		if(IS_POST){
			extract(I(''));
			$up = D("PayConfig")->where(array("id"=>array("in",$id)))->setField("status",1);
			$this->checkBoolean($up);
		}
	}
	public function denypay(){
		if(IS_POST){
			extract(I(''));
			$up = D("PayConfig")->where(array("id"=>array("in",$id)))->setField("status",0);
			$this->checkBoolean($up);
		}
	}
	
	public function pay_del(){
		extract(I(''));
		$up = D("PayConfig")->remove($id);
		$this->checkBoolean($up);
	}
	
	public function map(){
		$this->display();
	}
	
	public function intro(){
		$this->display();
	}
	
	public function sign(){
		if(IS_POST){
			extract(I(''));
			$data['_sql'] = "注册与访问控制";
			$up = D("Setting")->update($data);
			$this->checkBoolean($up);
		}else{
			$this->display();
		}
	}
	
	public function visitor(){
		$m = D("visitor");
		$this->countsum = $m->count();
		$this->color = array(
			'#0ae','#e33','#000','#f60','#999999',"#3f51b5","#673ab7","#9c27b0","#03a9f4","#00bcd4","#009688","#4caf50","#8bc34a","#cddc39","#ffeb3b","#ffc107","#ff9800","#ff5722","#795548","#9e9e9e","#607d8b"
		);
		$this->country = explode(",","阿富汗,安哥拉,阿尔巴尼亚,阿联酋,阿根廷,亚美尼亚,法属南半球和南极领地,澳大利亚,奥地利,阿塞拜疆,布隆迪,比利时,贝宁,布基纳法索,孟加拉国,保加利亚,巴哈马,波斯尼亚和黑塞哥维那,白俄罗斯,伯利兹,百慕大,玻利维亚,巴西,文莱,不丹,博茨瓦纳,中非共和国,加拿大,瑞士,智利,中国,象牙海岸,喀麦隆,刚果民主共和国,刚果共和国,哥伦比亚,哥斯达黎加,古巴,北塞浦路斯,塞浦路斯,捷克共和国,德国,吉布提,丹麦,多明尼加共和国,阿尔及利亚,厄瓜多尔,埃及,厄立特里亚,西班牙,爱沙尼亚,埃塞俄比亚,芬兰,斐济,福克兰群岛,法国,加蓬,英国,格鲁吉亚,加纳,几内亚,冈比亚,几内亚比绍,赤道几内亚,希腊,格陵兰,危地马拉,法属圭亚那,圭亚那,洪都拉斯,克罗地亚,海地,匈牙利,印尼,印度,爱尔兰,伊朗,伊拉克,冰岛,以色列,意大利,牙买加,约旦,日本,哈萨克斯坦,肯尼亚,吉尔吉斯斯坦,柬埔寨,韩国,科索沃,科威特,老挝,黎巴嫩,利比里亚,利比亚,斯里兰卡,莱索托,立陶宛,卢森堡,拉脱维亚,摩洛哥,摩尔多瓦,马达加斯加,墨西哥,马其顿,马里,缅甸,黑山,蒙古,莫桑比克,毛里塔尼亚,马拉维,马来西亚,纳米比亚,新喀里多尼亚,尼日尔,尼日利亚,尼加拉瓜,荷兰,挪威,尼泊尔,新西兰,阿曼,巴基斯坦,巴拿马,秘鲁,菲律宾,巴布新几内亚,波兰,波多黎各,北朝鲜	,葡萄牙	,巴拉圭	,卡塔尔	,罗马尼亚,俄罗斯,卢旺达,西撒哈拉,沙特阿拉伯,苏丹,南苏丹,塞内加尔,所罗门群岛,塞拉利昂,萨尔瓦多,索马里兰,索马里,塞尔威亚共和国,苏里南,斯洛伐克,斯洛文尼亚,瑞典,斯威士兰,叙利亚,乍得,多哥,泰国,塔吉克斯坦,土库曼斯坦,东帝汶,特立尼达和多巴哥,突尼斯,土耳其,坦桑尼亚联合共和国,乌干达3,乌克兰,乌拉圭,美国,乌兹别克斯坦,委内瑞拉,越南,瓦努阿图,西岸,也门,南非,赞比亚,津巴布韦");
		$this->city = explode(",","北京,天津,上海,重庆,河北,河南,云南,辽宁,黑龙江,湖南,安徽,山东,新疆,江苏,浙江,江西,湖北,广西,甘肃,山西,内蒙古,陕西,吉林,福建,贵州,广东,青海,西藏,四川,宁夏,海南,台湾,香港,澳门");
		$this->explorer = $m->field("*,count(`explorer`) as explorer_sum")->group("explorer")->order("explorer_sum desc")->select();
		$this->system = $m->field("*,count(`system`) as system_sum")->group("`system`")->order("system_sum desc")->select();
		$this->countrysum = $m->field("*,count(`country`) as country_sum")->group("`country`")->order("country_sum desc")->select();
		$this->citysum = $m->field("*,count(`state`) as city_sum")->group("`state`")->order("city_sum desc")->select();
		$this->display();
	}
	
	public function visitorList(){
		extract(I(''));
		$m = D("visitor");
		$cx = array("id"=>array("neq",0));
		if($sSearch !=''){
			$cx = array(
				"ip"		=> array("like","%". $sSearch ."%"),
				"method"	=> array("eq",$sSearch),
				"path"		=> array("like","%".$sSearch."%"),
				"protocol"	=> array("like","%".$sSearch."%"),
				"status"	=> array("eq",$sSearch),
				"explorer"	=> array("eq",$sSearch),
				"system"	=> array("eq",$sSearch),
				"core"		=> array("eq",$sSearch),
				"version"	=> array("eq",$sSearch),
				"country"	=> array("eq",$sSearch),
				"state"		=> array("eq",$sSearch),
				"area"		=> array("eq",$sSearch),
				"_logic"	=> "or",
			);
		}
		$columns = "mDataProp_".$iSortCol_0;
		$order = $iSortCol_0=="" ? "id desc" : $$columns ." ".$sSortDir_0;
		$count = $m->where($cx)->count();
		$page = new \Think\Page($count,$iDisplayLength);
		$show = $page->show();
		$country = $m->where($cx)->order($order)->limit($iDisplayStart.','.$page->listRows)->select();
        $output['sEcho'] = $sEcho;
        $output['iTotalDisplayRecords'] = $count;
        $output['iTotalRecords'] = $count; //总共有几条数据

		$data = array();
		foreach($country as $key=>$val){
			$val['path'] = "<a href='#' title='{$val['path']}'>". msubstr($val['path'],0,20,"utf-8",true) ."</a>";
			$val['url'] = "<a href='{$val['url']}' title='{$val['url']}' target='_url'>". msubstr($val['url'],0,20,"utf-8",true) ."</a>";
			$data[$key] = $val;
		}
        $output['aaData'] = $data;
		$this->ajaxReturn($output);
	}
	
	public function func(){
		extract(I(''));
		if(IS_POST){
			$data['_sql'] = "站点功能";
			$up = D("Setting")->update($data);
			$this->checkBoolean($up);
		}else{
			$this->model = $model ? $model : 1;
			$this->display();
		}
	}
	
	public function nature(){
		extract(I(''));
		if(IS_POST){
			$data['_sql'] = "性能优化";
			$up = D("Setting")->update($data);
			$this->checkBoolean($up);
		}else{
			$this->model = $model ? $model : 1;
			$this->display();
		}
	}
	
	public function seo(){
		extract(I(''));
		if(IS_POST){
			$data['_sql'] = "SEO设置";
			$up = D("Setting")->update($data);
			$this->checkBoolean($up);
		}else{
			$this->model = $model ? $model : 1;
			$this->display();
		}
	}
	
	public function point(){
		if(IS_POST){
			extract(I(''));
			if(!empty($data)){
				$data['_sql'] = "积分类型";
				$up[] = D("Point")->update($data);
			}
			if(!empty($setting)){
				$setting['_sql'] = "积分参数";
				$up[] = D("Setting")->update($setting);
			}
			if(!empty($policy)){
				$policy['_sql'] = "积分策略";
				$up[] = D("Setting")->update($policy);
			}
			$this->checkBoolean($up);
		}else{
			$this->policy = D("Policy")->read();
			$this->display();
		}
	}
	
	public function point_credits(){
		extract(I(''));
		if(IS_POST){
			if(!empty($data)){
				$data["_type"] = 0;
				$data['_sql'] = "积分规则";
				$up[] = D("Policy")->update($data);
			}
			if(!empty($policy)){
				$policy['_sql'] = "积分策略";
				$up[] = D("Setting")->update($policy);
			}
			$this->checkBoolean($up);
		}else{
			$this->policy = D("Policy")->read($id);
			$this->display();
		}
	}
	
	public function pointd(){
		if(IS_POST){
			extract(I(''));
			$del = D("Point")->remove($variable);
			$this->checkBoolean($del);
		}else{
			die("Access deny");
		}
	}
	
	public function time(){
		if(IS_POST){
			extract(I(''));
			$data['_sql'] = "时间设置";
			$up = D("Setting")->update($data);
			$this->checkBoolean($up);
		}else{
			$this->globalTimeoffset = D("GlobalTimeoffset")->read();
			$this->display();
		}
	}
	
	public function upload(){
		if(IS_POST){
			extract(I(''));
			$data['_sql'] = "上传设置";
			$up = D("Setting")->update($data);
			$this->checkBoolean($up);
		}else{
			$this->display();
		}
	}
	
	public function mark(){
		if(IS_POST){
			extract(I(''));
			$data['_sql'] = "水印设置";
			$up = D("Setting")->update($data);
			$this->checkBoolean($up);
		}else{
			$this->fontpath = getfiles("fonts");
			$this->display();
		}
	}
	
	public function search(){
		if(IS_POST){
			extract(I(''));
			$data['_sql'] = "搜索设置";
			$up = D("Setting")->update($data);
			$this->checkBoolean($up);
		}else{
			$this->display();
		}
	}
	
	public function pass(){
		if(IS_POST){
			extract(I(''));
			$user = D("admin");
			$adata = array(
				"pwd"		=> md5($data['pwd']),
				"secrand"	=> $data['secrand'],
			);
			$data['__hash__'] = $__hash__;
			if($adata['secrand'] == 0 && $adata['secrand'] != 1){
				unset($adata['secrand']);
			}
			$nowpwd = D("Admin")->read();
			md5($data['pass']) != $nowpwd ? $this->error("当前登录密码错误") : '';
			if($user->create($data)){
				$up[] = $user->where(array("id"=>session("uid")))->save($adata);
				$sql[] = $user->getlastsql();
				$sql['remark'] = "管理员编辑 (密码修改)";
				$sql['_group'] = "Admin";
				$up[] = D("OperationLog")->update($sql);
			}else{
				$this->error($user->getError());
			};
			$this->checkBoolean($up);
		}else{
			$this->display();
		}
	}
	
	public function nav(){
		if(IS_POST){
			extract(I(''));
			$data = array(
				"order"				=> $displayordernew,
				"name"				=> $newname,
				"subtype"			=> $subtypenew,
				"urlnew"			=> $newurl,
				"cate"				=> $cate,
				"delete"			=> $delete,
				"availablenew"		=> $availablenew,
			);
			$up = D("Nav")->update($data);
			$this->checkBoolean($up);
		}else{
			$this->nav = D("Nav")->read();
			$this->display();
		}
	}
	
	public function ui(){
		$this->display();
	}
	
	public function themes(){
		$this->display();
	}
	
	public function news(){
		$this->news = D("Sort")->read();
		$this->article = D("Article")->read();
		$this->display();
	}
	
	public function add_news(){
		if(IS_POST){
			extract(I(""));
			$data['__hash__'] = $__hash__;
			$up = D("Article")->update($data);
			$this->checkBoolean($up);
		}else{
			$this->display();
		}
	}
	
	public function cate(){
		if(IS_POST){
			extract(I(''));
			$data['__hash__'] = $__hash__;
			$up = D("Sort")->update($data);
			$this->checkBoolean($up);
		}else{
			$this->display();
		}
	}
	
	public function getcate(){
		extract(I(''));
		$sort = D("sort")->where(array("pid"=>$pid))->select();
		$this->ajaxReturn($sort);
	}
	
	public function menu(){
		$menu = D("menu");
		$count = $menu->count();
		$page = new \Think\Page($count,8,'',"_self");
		$list = $menu->limit($page->firstRow.','.$page->listRows)->select();
		$this->menu = $list;
		$this->page = $page->show();
		$this->display();
	}
	
	public function menu_add(){
		if(IS_POST){
			extract(I(''));
			$data["__hash__"] = $__hash__;
			$up = D("Menu")->update($data);
			$this->checkBoolean($up);
		}else{
			$menu = D("menu");
			$list = $menu->where("pid=0")->select();
			$this->menu = $list;
			$this->display();
		}
	}
	
	public function upused(){
		if(IS_POST){
			extract(I(''));
			C('TOKEN_ON',false);
			$data = array(
				"id"	=> $id,
				"used"	=> $used,
			);
			$up = D("Menu")->update($data,array("id"=>$id));
			$this->checkBoolean($up);
		}
	}
	
	public function menu_del(){
		extract(I(''));
		$up = D("Menu")->remove($id);
		$this->checkBoolean($up);
	}
	
	public function menu_update(){
		if(IS_POST){
			extract(I(""));
			C("TOKEN_ON",false);
			$order["_all"] = true;
			$up = D("Menu")->update($order);
			$this->checkBoolean($up);
		}
	}
	
	public function menu_edit(){
		extract(I(''));
		if(IS_POST){
			$map = array(
				"id"	=> $id,
			);
			$data['__hash__'] = $__hash__;
			$up = D("Menu")->update($data,$map);
			$this->checkBoolean($up);
		}else{
			$menu = D("menu");
			$list = $menu->where("pid=0")->select();
			$this->menu = $list;
			$this->menuitem = D("Menu")->read($id);
			$this->display("Cpanel/menu_add");
		}
	}
	
	public function cache(){
		extract(I(''));
		if(IS_POST){
			C("TOKEN_ON",false);
			empty($type) ? $this->error("请选择需要清除的缓存类型") : '';
			foreach($type as $key=>$val){
				switch($val){
					case 'data':
						$name = "数据";
					break;
					case "tpl":
						$name = "模板";
					break;
					case "log":
						$name = "日志";
					break;
				};
				$catetype[] = array(
					"cate"	=> $val,
					"name"	=> $name,
				);
			}
			$this->type = json_encode($catetype);
		}
		$this->step = I("get.step");
		$this->display();
	}
	
	public function cleancache(){
		extract(I(''));
			switch($type){
				case 'data':
					if($index==0){
						$catename = "数据《网站全局配置》";
						$status = 1;
					}
					if($index==1){
						$catename = "数据《登录缓存》";
						$status = 1;
					}
					if($index==2){
						$catename = "数据《注册与访问》";
						$status = 1;
					}
					if($index==3){
						$catename = "数据《站点功能》";
						$status = 1;
					}
					if($index==4){
						$catename = "数据《性能优化》";
						$status = 1;
					}
					if($index==5){
						$catename = "数据《SEO设置》";
						$status = 2;
					}
					break;
				case "tpl":
					if($index==0){
						$catename = "模板《积分设置》";
						$status = 1;
					}
					if($index==1){
						$catename = "模板《时间设置》";
						$status = 1;
					}
					if($index==2){
						$catename = "模板《上传设置》";
						$status = 1;
					}
					if($index==3){
						$catename = "模板《水印设置》";
						$status = 1;
					}
					if($index==4){
						$catename = "模板《搜索设置》";
						$status = 2;
					}
					break;
				case "log":
					
					if($index==0){
						$catename = "日志《程序创建文件》";
						$status = 1;
					}
					if($index==1){
						$catename = "日志《配置文件》";
						$status = 1;
					}
					if($index==2){
						$catename = "日志《定时任务》";
						$status = 1;
					}
					if($index==3){
						$catename = "日志《备份数据库》";
						$status = 1;
					}
					if($index==4){
						$catename = "日志《充值日志》";
						$status = 2;
					}
				break;	
			}
		$msg = array(
			"info"	=> "正在更新{$catename}缓存,请稍后",
			"status"=> $status,
			"index"	=> $index+1
		);
		$this->ajaxReturn($msg);
	}
	
	public function statis(){
		$this->display();
	}
	
	public function runtime(){
		$log = D("OperationLog")->read();
		$this->operairlog = $log['list'];
		$this->page = $log['page'];
		$this->display();
	}
	
	public function planTask(){
		$this->display();
	}
	
	public function rewrite(){
		$this->display();
	}
	
	public function dbbak(){
		$Db = \Think\Db::getInstance();
		$list = $Db->query('SHOW TABLE STATUS');
		$list = array_map('array_change_key_case', $list);
		$this->dbtab = $list;
		$this->display();
	}
	
	public function optimize($tables = NULL)
	{
		if ($tables) {
			$Db = \Think\Db::getInstance();

			if (is_array($tables)) {
				$tables = implode('`,`', $tables);
				$list = $Db->query('OPTIMIZE TABLE `' . $tables . '`');

				if ($list) {
					$this->success('数据表优化完成！');
				}
				else {
					$this->error('数据表优化出错请重试！');
				}
			}
			else {
				$list = $Db->query('OPTIMIZE TABLE `' . $tables . '`');

				if ($list) {
					$this->success('数据表\'' . $tables . '\'优化完成！');
				}
				else {
					$this->error('数据表\'' . $tables . '\'优化出错请重试！');
				}
			}
		}
		else {
			$this->error('请指定要优化的表！');
		}
	}

	public function repair($tables = NULL)
	{
		if ($tables) {
			$Db = \Think\Db::getInstance();

			if (is_array($tables)) {
				$tables = implode('`,`', $tables);
				$list = $Db->query('REPAIR TABLE `' . $tables . '`');

				if ($list) {
					$this->success('数据表修复完成！');
				}
				else {
					$this->error('数据表修复出错请重试！');
				}
			}
			else {
				$list = $Db->query('REPAIR TABLE `' . $tables . '`');

				if ($list) {
					$this->success('数据表\'' . $tables . '\'修复完成！');
				}
				else {
					$this->error('数据表\'' . $tables . '\'修复出错请重试！');
				}
			}
		}
		else {
			$this->error('请指定要修复的表！');
		}
	}
	
	public function dbreset(){
		$path = realpath(DATABASE_PATH);
		$flag = \FilesystemIterator::KEY_AS_FILENAME;
		$glob = new \FilesystemIterator($path, $flag);
		$list = array();

		foreach ($glob as $name => $file) {
			if (preg_match('/^\\d{8,8}-\\d{6,6}-\\d+\\.sql(?:\\.gz)?$/', $name)) {
				$name = sscanf($name, '%4s%2s%2s-%2s%2s%2s-%d');
				$date = $name[0] . '-' . $name[1] . '-' . $name[2];
				$time = $name[3] . ':' . $name[4] . ':' . $name[5];
				$part = $name[6];

				if (isset($list[$date . ' ' . $time])) {
					$info = $list[$date . ' ' . $time];
					$info['part'] = max($info['part'], $part);
					$info['size'] = $info['size'] + $file->getSize();
				}
				else {
					$info['part'] = $part;
					$info['size'] = $file->getSize();
				}

				$extension = strtoupper(pathinfo($file->getFilename(), PATHINFO_EXTENSION));
				$info['compress'] = $extension === 'SQL' ? '-' : $extension;
				$info['time'] = strtotime($date . ' ' . $time);
				$list[$date . ' ' . $time] = $info;
			}
		}
		$this->dbreset = $list;
		$this->display();
	}
	
	public function import($time = 0, $part = NULL, $start = NULL)
	{
		if (is_numeric($time) && is_null($part) && is_null($start)) {
			$name = date('Ymd-His', $time) . '-*.sql*';
			$path = realpath(DATABASE_PATH) . DIRECTORY_SEPARATOR . $name;
			$files = glob($path);
			$list = array();

			foreach ($files as $name) {
				$basename = basename($name);
				$match = sscanf($basename, '%4s%2s%2s-%2s%2s%2s-%d');
				$gz = preg_match('/^\\d{8,8}-\\d{6,6}-\\d+\\.sql.gz$/', $basename);
				$list[$match[6]] = array($match[6], $name, $gz);
			}

			ksort($list);
			$last = end($list);

			if (count($list) === $last[0]) {
				session('backup_list', $list);
				$this->success('初始化完成！', '', array('part' => 1, 'start' => 0));
			}
			else {
				$this->error('备份文件可能已经损坏，请检查！');
			}
		}
		else {
			if (is_numeric($part) && is_numeric($start)) {
				$list = session('backup_list');
				$db = new \OT\Database($list[$part], array('path' => realpath(DATABASE_PATH) . DIRECTORY_SEPARATOR, 'compress' => 1, 'level' => 9));
				$start = $db->import($start);

				if (false === $start) {
					$this->error('还原数据出错！');
				}
				else if (0 === $start) {
					if (isset($list[++$part])) {
						$data = array('part' => $part, 'start' => 0);
						$this->success('正在还原...#' . $part, '', $data);
					}
					else {
						session('backup_list', null);
						$this->success('还原完成！');
					}
				}
				else {
					$data = array('part' => $part, 'start' => $start[0]);

					if ($start[1]) {
						$rate = floor(100 * ($start[0] / $start[1]));
						$this->success('正在还原...#' . $part . ' (' . $rate . '%)', '', $data);
					}
					else {
						$data['gz'] = 1;
						$this->success('正在还原...#' . $part, '', $data);
					}
				}
			}
			else {
				$this->error('参数错误！');
			}
		}
	}
	
	public function dbdel($time = 0)
	{
		if ($time) {
			$name = date('Ymd-His', $time) . '-*.sql*';
			$path = realpath(DATABASE_PATH) . DIRECTORY_SEPARATOR . $name;
			array_map('unlink', glob($path));

			if (count(glob($path))) {
				$this->success('备份文件删除失败，请检查权限！');
			}
			else {
				$this->success('备份文件删除成功！');
			}
		}
		else {
			$this->error('参数错误！');
		}
	}
	public function export($tables = NULL, $id = NULL, $start = NULL)
	{
		if (IS_POST && !empty($tables) && is_array($tables)) {
			$config = array('path' => realpath(DATABASE_PATH) . DIRECTORY_SEPARATOR, 'part' => 20971520, 'compress' => 1, 'level' => 9);
			$lock = $config['path'] . 'backup.lock';

			if (is_file($lock)) {
				$this->error('检测到有一个备份任务正在执行，请稍后再试！');
			}
			else {
				file_put_contents($lock, NOW_TIME);
			}
			is_writeable($config['path']) || $this->error('备份目录不存在或不可写，请检查后重试！');
			session('backup_config', $config);
			$file = array('name' => date('Ymd-His', NOW_TIME), 'part' => 1);
			session('backup_file', $file);
			session('backup_tables', $tables);
			$Database = new \OT\Database($file, $config);

			if (false !== $Database->create()) {
				$tab = array('id' => 0, 'start' => 0);
				$this->success('初始化成功！', '', array('tables' => $tables, 'tab' => $tab));
			}
			else {
				$this->error('初始化失败，备份文件创建失败！');
			}
		}
		else {
			if (IS_GET && is_numeric($id) && is_numeric($start)) {
				$tables = session('backup_tables');
				$Database = new \OT\Database(session('backup_file'), session('backup_config'));
				$start = $Database->backup($tables[$id], $start);

				if (false === $start) {
					$this->error('备份出错！');
				}
				else if (0 === $start) {
					if (isset($tables[++$id])) {
						$tab = array('id' => $id, 'start' => 0);
						$this->success('备份完成！', '', array('tab' => $tab));
					}
					else {
						unlink(session('backup_config.path') . 'backup.lock');
						session('backup_tables', null);
						session('backup_file', null);
						session('backup_config', null);
						$this->success('备份完成！');
					}
				}
				else {
					$tab = array('id' => $id, 'start' => $start[0]);
					$rate = floor(100 * ($start[0] / $start[1]));
					$this->success('正在备份...(' . $rate . '%)', '', array('tab' => $tab));
				}
			}
			else {
				$this->error('参数错误！');
			}
		}
	}
	
	public function excel($tables = NULL)
	{
		if ($tables) {
			$mo = M();
			$mo->execute('set autocommit=0');
			$mo->execute('lock tables ' . $tables . ' write');
			$rs = $mo->table($tables)->select();
			$zd = $mo->table($tables)->getDbFields();

			if ($rs) {
				$mo->execute('commit');
				$mo->execute('unlock tables');
			}
			else {
				$mo->execute('rollback');
			}

			$xlsName = $tables;
			$xls = array();

			foreach ($zd as $k => $v) {
				$xls[$k][0] = $v;
				$xls[$k][1] = $v;
			}

			$this->exportExcel($xlsName, $xls, $rs);
		}
		else {
			$this->error('请指定要导出的表！');
		}
	}

	public function exportExcel($expTitle, $expCellName, $expTableData)
	{
		Vendor("PHPExcel.PHPExcel");
		Vendor("PHPExcel.PHPExcel.Writer.Excel5");
		Vendor("PHPExcel.PHPExcel.IOFactory");
		$xlsTitle = iconv('utf-8', 'gb2312', $expTitle);
		$fileName = $_SESSION['loginAccount'] . date('_YmdHis');
		$cellNum = count($expCellName);
		$dataNum = count($expTableData);
		$objPHPExcel = new \PHPExcel();
		$cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');
		$objPHPExcel->getActiveSheet(0)->mergeCells('A1:' . $cellName[$cellNum - 1] . '1');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle . '  Export time:' . date('Y-m-d H:i:s'));

		for ($i = 0; $i < $cellNum; $i++) {
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i] . '2', $expCellName[$i][1]);
		}

		for ($i = 0; $i < $dataNum; $i++) {
			for ($j = 0; $j < $cellNum; $j++) {
				$objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j] . ($i + 3), $expTableData[$i][$expCellName[$j][0]]);
			}
		}

		ob_end_clean();
		header('pragma:public');
		header('Content-type:application/vnd.ms-excel;charset=utf-8;name="' . $xlsTitle . '.xls"');
		header('Content-Disposition:attachment;filename=' . $fileName . '.xls');
		$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit();
	}

	public function importExecl($file)
	{
		Vendor("PHPExcel.PHPExcel");
		Vendor("PHPExcel.PHPExcel.Writer.Excel5");
		Vendor("PHPExcel.PHPExcel.IOFactory");
		if (!file_exists($file)) {
			return array('error' => 0, 'message' => 'file not found!');
		}

		$objReader = PHPExcel_IOFactory::createReader('Excel5');

		try {
			$PHPReader = $objReader->load($file);
		}
		catch (Exception $e) {
		}

		if (!isset($PHPReader)) {
			return array('error' => 0, 'message' => 'read error!');
		}

		$allWorksheets = $PHPReader->getAllSheets();
		$i = 0;

		foreach ($allWorksheets as $objWorksheet) {
			$sheetname = $objWorksheet->getTitle();
			$allRow = $objWorksheet->getHighestRow();
			$highestColumn = $objWorksheet->getHighestColumn();
			$allColumn = PHPExcel_Cell::columnIndexFromString($highestColumn);
			$array[$i]['Title'] = $sheetname;
			$array[$i]['Cols'] = $allColumn;
			$array[$i]['Rows'] = $allRow;
			$arr = array();
			$isMergeCell = array();

			foreach ($objWorksheet->getMergeCells() as $cells) {
				foreach (PHPExcel_Cell::extractAllCellReferencesInRange($cells) as $cellReference) {
					$isMergeCell[$cellReference] = true;
				}
			}

			for ($currentRow = 1; $currentRow <= $allRow; $currentRow++) {
				$row = array();

				for ($currentColumn = 0; $currentColumn < $allColumn; $currentColumn++) {
					$cell = $objWorksheet->getCellByColumnAndRow($currentColumn, $currentRow);
					$afCol = PHPExcel_Cell::stringFromColumnIndex($currentColumn + 1);
					$bfCol = PHPExcel_Cell::stringFromColumnIndex($currentColumn - 1);
					$col = PHPExcel_Cell::stringFromColumnIndex($currentColumn);
					$address = $col . $currentRow;
					$value = $objWorksheet->getCell($address)->getValue();

					if (substr($value, 0, 1) == '=') {
						return array('error' => 0, 'message' => 'can not use the formula!');
						exit();
					}

					if ($cell->getDataType() == PHPExcel_Cell_DataType::TYPE_NUMERIC) {
						$cellstyleformat = $cell->getParent()->getStyle($cell->getCoordinate())->getNumberFormat();
						$formatcode = $cellstyleformat->getFormatCode();

						if (preg_match('/^([$[A-Z]*-[0-9A-F]*])*[hmsdy]/i', $formatcode)) {
							$value = gmdate('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($value));
						}
						else {
							$value = PHPExcel_Style_NumberFormat::toFormattedString($value, $formatcode);
						}
					}

					if ($isMergeCell[$col . $currentRow] && $isMergeCell[$afCol . $currentRow] && !empty($value)) {
						$temp = $value;
					}
					else {
						if ($isMergeCell[$col . $currentRow] && $isMergeCell[$col . ($currentRow - 1)] && empty($value)) {
							$value = $arr[$currentRow - 1][$currentColumn];
						}
						else {
							if ($isMergeCell[$col . $currentRow] && $isMergeCell[$bfCol . $currentRow] && empty($value)) {
								$value = $temp;
							}
						}
					}

					$row[$currentColumn] = $value;
				}

				$arr[$currentRow] = $row;
			}

			$array[$i]['Content'] = $arr;
			$i++;
		}

		spl_autoload_register(array('Think', 'autoload'));
		unset($objWorksheet);
		unset($PHPReader);
		unset($PHPExcel);
		unlink($file);
		return array('error' => 1, 'data' => $array);
	}
}