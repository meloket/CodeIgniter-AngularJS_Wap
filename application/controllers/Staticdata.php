<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staticdata extends WebLoginBase_Controller {

	public function __construct()
    {
        parent::__construct();
    }

    public final function dataversionjs(){
    	echo 'var dataVersion=345;';
	}
	
	public final function messagesjs(){
		$dataarr = $this->getRows("select * from {$this->prename}content where enable=1 order by addtime desc, id desc");
		if($dataarr){
			$data = array();
			$data['type_1'] = array();
			foreach($dataarr as $var){
				$list=array();
				$list['id']=$var['id'];
				$list['userId']=$var['userId'];
				$list['type']=intval($var['type']);
				$list['message']=$var['content'];
				$list['channel']=$var['channel'];
				$list['title']=$var['title'];
				$list['addTime']=date('Y-m-d H:i:s',$var['addTime']);
				$list['updateTime']=date('Y-m-d H:i:s',$var['addTime']);
				array_push($data['type_1'], $list);
			}
			echo 'var MESSAGES = '.json_encode($data);	
		}
		/*var MESSAGES = {"type_1":[],"type_0":[]};*/
	}	
	
	public final function paramcfgjs(){
		echo 'var PARAM_CFG = {"rech_levels":[{"id":1,"param":"rech_levels","name":"默认层","value":"0","remark":null,"sort":1,"extInfo":null,"open":0,"rebate":null},{"id":2,"param":"rech_levels","name":"第一层","value":"1","remark":null,"sort":2,"extInfo":null,"open":0,"rebate":null},{"id":3,"param":"rech_levels","name":"第二层","value":"2","remark":null,"sort":3,"extInfo":null,"open":0,"rebate":null},{"id":4,"param":"rech_levels","name":"第三层","value":"3","remark":null,"sort":4,"extInfo":null,"open":0,"rebate":null},{"id":5,"param":"rech_levels","name":"第四层","value":"4","remark":null,"sort":5,"extInfo":null,"open":0,"rebate":null},{"id":20,"param":"rech_levels","name":"第五层","value":"5","remark":null,"sort":6,"extInfo":null,"open":0,"rebate":null},{"id":21,"param":"rech_levels","name":"第六层","value":"6","remark":null,"sort":7,"extInfo":null,"open":0,"rebate":null}],"rech_type":[{"id":8,"param":"rech_type","name":"在线支付","value":"onlinePayment","remark":"支持国内16家银行的借记卡个人网银支付，0手续费，免提交【<font color=\"#FF0000\"><strong>直接到账</strong></font>】，方便快捷！","sort":1,"extInfo":"{url:\'/pay/online.html\'}","open":0,"rebate":0.0},{"id":9,"param":"rech_type","name":"银行汇款","value":"bankTransfer","remark":"请每次入款前登陆会员核对银行账号是否使用！ 温馨提示：为确保财务第一时间为您添加游戏额度,请您尽量不要转账整数(例如：欲如￥5000,请转￥5000.68)谢谢！ 操作备注：银行汇款步骤->点击【银行汇款】,点选您所要使用的银行,复制公司的银行账号来完成转账。 然后 提交您存款的相关资料,工作人员将在5分钟之内把您的金额存到您的会员账号上,感谢您的支持和配合！","sort":2,"extInfo":"{url:\'/pay/bank.html\'}","open":0,"rebate":0.0},{"id":10,"param":"rech_type","name":"支付宝支付","value":"alipay","remark":null,"sort":3,"extInfo":"{url:\'/pay/alipay.html\'}","open":0,"rebate":0.0},{"id":11,"param":"rech_type","name":"微信支付","value":"weixin","remark":null,"sort":4,"extInfo":"{url:\'/pay/weixin.html\'}","open":0,"rebate":0.0},{"id":24,"param":"rech_type","name":"财付通","value":"cft","remark":null,"sort":null,"extInfo":"{url:\'/pay/cft.html\'}","open":0,"rebate":0.0},{"id":36,"param":"rech_type","name":"后台加钱","value":"adminAddMoney","remark":null,"sort":6,"extInfo":null,"open":0,"rebate":null}],"rech_bank":[{"id":12,"param":"rech_bank","name":"农业银行","value":"ABC","remark":null,"sort":1,"extInfo":"{imgurl:\'/images/data/nongye.gif\'}","open":0,"rebate":null},{"id":13,"param":"rech_bank","name":"建设银行","value":"CCB","remark":null,"sort":2,"extInfo":"{imgurl:\'/images/data/jianshe.gif\'}","open":0,"rebate":null},{"id":14,"param":"rech_bank","name":"工商银行","value":"ICBC","remark":null,"sort":3,"extInfo":"{imgurl:\'/images/data/gongshang.gif\'}","open":0,"rebate":null},{"id":15,"param":"rech_bank","name":"招商银行","value":"CMB","remark":null,"sort":4,"extInfo":"{imgurl:\'/images/data/zhaohang.gif\'}","open":0,"rebate":null},{"id":16,"param":"rech_bank","name":"交通银行","value":"BOCO","remark":null,"sort":5,"extInfo":"{imgurl:\'/images/data/jiaotong.gif\'}","open":0,"rebate":null},{"id":17,"param":"rech_bank","name":"民生银行","value":"CMBC","remark":null,"sort":6,"extInfo":"{imgurl:\'/images/data/minsheng.gif\'}","open":0,"rebate":null},{"id":18,"param":"rech_bank","name":"兴业银行","value":"CIB","remark":null,"sort":7,"extInfo":"{imgurl:\'/images/data/xingye.gif\'}","open":0,"rebate":null},{"id":19,"param":"rech_bank","name":"中国银行","value":"BOC","remark":null,"sort":8,"extInfo":"{imgurl:\'/images/data/zhongguo.gif\'}","open":0,"rebate":null},{"id":25,"param":"rech_bank","name":"邮政银行","value":"POST","remark":null,"sort":9,"extInfo":null,"open":0,"rebate":null},{"id":26,"param":"rech_bank","name":"光大银行","value":"CEBBANK","remark":null,"sort":10,"extInfo":null,"open":0,"rebate":null},{"id":27,"param":"rech_bank","name":"中信银行","value":"ECITIC","remark":null,"sort":11,"extInfo":null,"open":0,"rebate":null},{"id":28,"param":"rech_bank","name":"广发银行","value":"CGB","remark":null,"sort":12,"extInfo":null,"open":0,"rebate":null},{"id":29,"param":"rech_bank","name":"浦发银行","value":"SPDB","remark":null,"sort":13,"extInfo":null,"open":0,"rebate":null},{"id":30,"param":"rech_bank","name":"华夏银行","value":"HXB","remark":null,"sort":14,"extInfo":null,"open":0,"rebate":null},{"id":31,"param":"rech_bank","name":"平安银行","value":"PINGAN","remark":null,"sort":15,"extInfo":null,"open":0,"rebate":null},{"id":32,"param":"rech_bank","name":"北京银行","value":"BCCB","remark":null,"sort":16,"extInfo":null,"open":0,"rebate":null},{"id":33,"param":"rech_bank","name":"上海银行","value":"BOS","remark":null,"sort":17,"extInfo":null,"open":0,"rebate":null},{"id":34,"param":"rech_bank","name":"北京农商","value":"BRCB","remark":null,"sort":18,"extInfo":null,"open":0,"rebate":null}]};';
	}	
	
	public final function configjsjs(){
		
		$this->getSystemSettings();
		$config=array();
		$config['trialGamePro']="0";
		$config['regFilterName']="测试";
		$config['lhcWxJin']="0";
		$config['lhcWxMu']="0";
		$config['lhcWxShui']="0";
		$config['lhcWxHuo']="0";
		$config['lhcWxTu']="0";
		$config['zxkfUrl']="0";
		$config['defaultSkin']="0";
		$config['mainQQUrl']="0";
		$config['mainWxUrl']="0";
		$config['mainPhone']="0";
		$config['mainCustomerQQ']="0";
		$config['mainAgentQQ']="0";
		$config['mainEmail']="0";
		$config['withdrawNumTotal']="7";
		$config['showKjzb']='/';
		$config['regUqFullName']="0";
		echo 'var CONFIG_MAP = '.json_encode($config);
		/*var CONFIG_MAP = {"trialGamePro":"0","regFilterName":"毛泽东;周恩来;潘春锋;潘春晖;潘金水;潘文海;章燕;秦明;周安;李银龙","lhcWxJin":"02,03,16,17,24,25,32,33,46,47","lhcWxMu":"06,07,14,15,28,29,36,37,44,45","lhcWxShui":"04,05,12,13,20,21,34,35,42,43","lhcWxHuo":"01,08,09,22,23,30,31,38,39","lhcWxTu":"10,11,18,19,26,27,40,41,48,49","zxkfUrl":"","defaultSkin":"blue","mainQQUrl":"http://wpa.qq.com/msgrd?v=3&uin=&site=web&menu=yes","mainWxUrl":"http://wpa.qq.com/msgrd?v=3&uin=&site=web&menu=yes","mainPhone":"0063-947-8788888","mainCustomerQQ":"","mainAgentQQ":"","mainEmail":"","withdrawNumTotal":"7","showKjzb":"/","regUqFullName":"0"};*/
	}	
	
	public final function gameCommonjs(){
		echo '//在线客服
			function onlineService(){
				var url="";
				if(parent && parent.CONFIG_MAP&& parent.CONFIG_MAP.zxkfUrl){
					url=parent.CONFIG_MAP.zxkfUrl
				}else{
					url=CONFIG_MAP.zxkfUrl;
				}
				window.open(url);
			}

			//打开QQ
			function openQQWin(){
				var url=CONFIG_MAP.mainQQUrl;
				if(!url){
					alert("未设置QQ联系方式请联系客服");
					return;
				}
				window.open(url);
			}

			//打开微信
			function openWxWin(){
				var url=CONFIG_MAP.mainWxUrl;
				if(!url){
					alert("未设置微信联系方式请联系客服");
					return;
				}
				window.open(url);
			}

			function showOtherTips(objId) {
				$(objId).next("ul").show();
			}

			function hideOtherTips(objId) {
				$(objId).next("ul").hide();
			}
			function getGameDomain(pageUrl){
				var trialGamePro = user.testFlag;
				var webDomain ="";
				if(trialGamePro=="1") {//试玩
					webDomain=getTrialWebDomain();
				}else{
					webDomain=getWebDomain();
				}
				if(!webDomain) {
					alert("无法进入游戏，请联系客服");
					return;
				}
				if(pageUrl){
					webDomain+=webDomain;
				}
				return webDomain;
			}

			function formatConfigHtml(dcm,cfgId){
				var value = CONFIG_MAP[cfgId];
				if(value){
					$(dcm).html(value);
				}
			}

			/**
			 * 进入游戏页面
			 */
			function gotoGamePage(){
				var webDomain=getGameDomain();
				window.location.href=webDomain+"/agreement.html"
			}
			/**
			 * 进入推广页面
			 */
			function gotoMainPage() {
				var mainDomain = getMainDomain();
				if(mainDomain) {
					window.location.href = mainDomain + "/";
				}
				
				return true;
			}

			/**
			 * 初始化下拉框
			 */
			function initGameSelect(obj){
				var optionFormatStr=\'<option value="{gameId}">{gameName}</option>\';
				var optionStr="";
				for(var g in games){
					var game=games[g];
					if(game.open==0){
						optionStr+=optionFormatStr.format({
							"gameId":game.id,
							"gameName":game.name
						});
					}
				}
				$(obj).html(optionStr);
			}';
	}	

	public final function gamedatasjs(){
		$cacheFile = 'staticdata/gamedatas';
		$expire = null;
		$getvalue = $this->user['panid'];
		//getSystemCache($this->display('staticdata/gamedatas.php'),$this->cacheDir,$this->expire);
		if($expire < 30) $expire=$this->expire;
		$file=$this->cacheDir. '/systemplayed'.$getvalue.'_'.md5($cacheFile);
		//缓存文件存在且时间不超过10小时，则直接使用缓存的结果集，不在进行任何的MySQL查询了  
		if($expire && is_file($file) && time()-filemtime($file) < $expire) 
		{  
			//使用缓存中的结果
			echo file_get_contents($file);
		}
		else
		{    		 
			//将结果集缓存
			ob_start();
			//require_once('game1.php');
			echo $this->game1();
			//require_once('game3.php');  //玩法
			echo $this->game2();
			//require_once('game4.php'); //赔率
			echo $this->game3();

			file_put_contents($file, ob_get_contents()); 
			ob_end_flush();
		}  
	}

	public function game1()
	{
		$gametype=$this->getRows("select * from {$this->prename}type order by sort asc");
		if($gametype){
			$games=array();
			$allgames=array();
			$idkey2=array();

			foreach($gametype as $key => $var){
				$games['id']=intval($var['id']);
				$games['name']=$var['title'];
				$games['sort'] = intval($var['sort']);
				$games['cate'] = intval($var['type']);
				$games['maxReward'] = 0;
				$games['open'] = abs($var['enable']-1); //彩种开启关闭
				$games['iconUrl'] = '';
				$games['pageUrl'] = "/game/".$var['name']."/index.html";
				$games['restStartDate'] = null;
				$games['restEndDate'] = null;
				
				$games['turnFormat'] = 'yyyyMMdd'; //备用参数
				$games['curTurnNum'] = ''; //备用参数
				
				$games['amount'] = intval($var['num']);
				$games['enable'] = $var['enable']; //玩法禁用
			/*if(max(array_keys($gametype)) != $key){
			$gametype2=$gametype2.json_encode($games).',';
			$gametype22=$gametype22.'"'.$var['id'].'":'.json_encode($games).',';

			}else{
			$gametype2=$gametype2.json_encode($games);
			$gametype22=$gametype22.'"'.$var['id'].'":'.json_encode($games);

			}*/

				array_push($allgames,$games);	
				array_push($idkey2, $var['id']);
			
			}

		}
		$gameMap=array_combine($idkey2, $allgames);
		$result = 'var games = '.json_encode($allgames).';';
		$result .= 'var gameMap = '.json_encode($gameMap).';';

		return $result;
	}
	public function game2()
	{
		$result = 'var gameMap = {
			"1": {
				"id": 1,
				"name": "重庆时时彩",
				"mode": 0,
				"sort": 2,
				"cate": 1,
				"maxReward": 0,
				"open": 0,
				"iconUrl": "",
				"pageUrl": "/game/cqssc/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": "yyyyMMdd",
				"curTurnNum": "",
				"amount": 120,
				"isBan": 0
			},
			"65": {
				"id": 65,
				"name": "北京快乐8",
				"mode": 1,
				"sort": 5,
				"cate": 1,
				"maxReward": 0,
				"open": 0,
				"iconUrl": null,
				"pageUrl": "/game/bjkl8/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": "",
				"curTurnNum": "796830",
				"amount": 179,
				"isBan": 0
			},
			"66": {
				"id": 66,
				"name": "PC蛋蛋",
				"mode": 1,
				"sort": 4,
				"cate": 1,
				"maxReward": 0,
				"open": 0,
				"iconUrl": "icon-new",
				"pageUrl": "/game/pcdd/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": null,
				"curTurnNum": "796830",
				"amount": 179,
				"isBan": 0
			},
			"50": {
				"id": 50,
				"name": "北京赛车(PK10)",
				"mode": 0,
				"sort": 1,
				"cate": 4,
				"maxReward": 0,
				"open": 0,
				"iconUrl": "",
				"pageUrl": "/game/pk10/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": null,
				"curTurnNum": "591402",
				"amount": 179,
				"isBan": 0
			},
			"21": {
				"id": 21,
				"name": "广东11选5",
				"mode": 1,
				"sort": 6,
				"cate": 1,
				"maxReward": 0,
				"open": 0,
				"iconUrl": null,
				"pageUrl": "/game/gd11x5/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": "yyMMdd",
				"curTurnNum": "",
				"amount": 84,
				"isBan": 0
			},
			"70": {
				"id": 70,
				"name": "香港六合彩",
				"mode": 1,
				"sort": 9,
				"cate": 1,
				"maxReward": 0,
				"open": 0,
				"iconUrl": null,
				"pageUrl": "/game/lhc/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": "",
				"curTurnNum": "2016060",
				"amount": 1,
				"isBan": 0
			},
			"55": {
				"id": 55,
				"name": "幸运飞艇",
				"mode": 1,
				"sort": 8,
				"cate": 1,
				"maxReward": 0,
				"open": 0,
				"iconUrl": "",
				"pageUrl": "/game/xyft/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": "yyyyMMdd",
				"curTurnNum": " ",
				"amount": 180,
				"isBan": 0
			},
			"10": {
				"id": 10,
				"name": "江苏骰宝(快3)",
				"mode": 0,
				"sort": 7,
				"cate": 5,
				"maxReward": 0,
				"open": 0,
				"iconUrl": "",
				"pageUrl": "/game/jsk3/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": "yyMMdd",
				"curTurnNum": "",
				"amount": 82,
				"isBan": 0
			},
			"60": {
				"id": 60,
				"name": "广东快乐十分",
				"mode": 1,
				"sort": 3,
				"cate": 1,
				"maxReward": 0,
				"open": 0,
				"iconUrl": null,
				"pageUrl": "/game/gdkl10/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": "yyyyMMdd",
				"curTurnNum": "",
				"amount": 84,
				"isBan": 0
			},
			"61": {
				"id": 61,
				"name": "重庆幸运农场",
				"mode": 1,
				"sort": 4,
				"cate": 1,
				"maxReward": 0,
				"open": 0,
				"iconUrl": null,
				"pageUrl": "/game/xync/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": "yyMMdd",
				"curTurnNum": "",
				"amount": 97,
				"isBan": 0
			}
		};';
		$result .= 'var gameMap = {
			"1": {
				"id": 1,
				"name": "重庆时时彩",
				"mode": 0,
				"sort": 2,
				"cate": 1,
				"maxReward": 0,
				"open": 0,
				"iconUrl": "",
				"pageUrl": "/game/cqssc/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": "yyyyMMdd",
				"curTurnNum": "",
				"amount": 120,
				"isBan": 0
			},
			"65": {
				"id": 65,
				"name": "北京快乐8",
				"mode": 1,
				"sort": 5,
				"cate": 1,
				"maxReward": 0,
				"open": 0,
				"iconUrl": null,
				"pageUrl": "/game/bjkl8/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": "",
				"curTurnNum": "796830",
				"amount": 179,
				"isBan": 0
			},
			"66": {
				"id": 66,
				"name": "PC蛋蛋",
				"mode": 1,
				"sort": 4,
				"cate": 1,
				"maxReward": 0,
				"open": 0,
				"iconUrl": "icon-new",
				"pageUrl": "/game/pcdd/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": null,
				"curTurnNum": "796830",
				"amount": 179,
				"isBan": 0
			},
			"50": {
				"id": 50,
				"name": "北京赛车(PK10)",
				"mode": 0,
				"sort": 1,
				"cate": 4,
				"maxReward": 0,
				"open": 0,
				"iconUrl": "",
				"pageUrl": "/game/pk10/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": null,
				"curTurnNum": "591402",
				"amount": 179,
				"isBan": 0
			},
			"21": {
				"id": 21,
				"name": "广东11选5",
				"mode": 1,
				"sort": 6,
				"cate": 1,
				"maxReward": 0,
				"open": 0,
				"iconUrl": null,
				"pageUrl": "/game/gd11x5/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": "yyMMdd",
				"curTurnNum": "",
				"amount": 84,
				"isBan": 0
			},
			"70": {
				"id": 70,
				"name": "香港六合彩",
				"mode": 1,
				"sort": 9,
				"cate": 1,
				"maxReward": 0,
				"open": 0,
				"iconUrl": null,
				"pageUrl": "/game/lhc/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": "",
				"curTurnNum": "2016060",
				"amount": 1,
				"isBan": 0
			},
			"55": {
				"id": 55,
				"name": "幸运飞艇",
				"mode": 1,
				"sort": 8,
				"cate": 1,
				"maxReward": 0,
				"open": 0,
				"iconUrl": "",
				"pageUrl": "/game/xyft/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": "yyyyMMdd",
				"curTurnNum": " ",
				"amount": 180,
				"isBan": 0
			},
			"10": {
				"id": 10,
				"name": "江苏骰宝(快3)",
				"mode": 0,
				"sort": 7,
				"cate": 5,
				"maxReward": 0,
				"open": 0,
				"iconUrl": "",
				"pageUrl": "/game/jsk3/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": "yyMMdd",
				"curTurnNum": "",
				"amount": 82,
				"isBan": 0
			},
			"60": {
				"id": 60,
				"name": "广东快乐十分",
				"mode": 1,
				"sort": 3,
				"cate": 1,
				"maxReward": 0,
				"open": 0,
				"iconUrl": null,
				"pageUrl": "/game/gdkl10/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": "yyyyMMdd",
				"curTurnNum": "",
				"amount": 84,
				"isBan": 0
			},
			"61": {
				"id": 61,
				"name": "重庆幸运农场",
				"mode": 1,
				"sort": 4,
				"cate": 1,
				"maxReward": 0,
				"open": 0,
				"iconUrl": null,
				"pageUrl": "/game/xync/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": "yyMMdd",
				"curTurnNum": "",
				"amount": 97,
				"isBan": 0
			}
		};';
		$result .= 'var gameMap = {
			"1": {
				"id": 1,
				"name": "重庆时时彩",
				"mode": 0,
				"sort": 2,
				"cate": 1,
				"maxReward": 0,
				"open": 0,
				"iconUrl": "",
				"pageUrl": "/game/cqssc/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": "yyyyMMdd",
				"curTurnNum": "",
				"amount": 120,
				"isBan": 0
			},
			"65": {
				"id": 65,
				"name": "北京快乐8",
				"mode": 1,
				"sort": 5,
				"cate": 1,
				"maxReward": 0,
				"open": 0,
				"iconUrl": null,
				"pageUrl": "/game/bjkl8/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": "",
				"curTurnNum": "796830",
				"amount": 179,
				"isBan": 0
			},
			"66": {
				"id": 66,
				"name": "PC蛋蛋",
				"mode": 1,
				"sort": 4,
				"cate": 1,
				"maxReward": 0,
				"open": 0,
				"iconUrl": "icon-new",
				"pageUrl": "/game/pcdd/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": null,
				"curTurnNum": "796830",
				"amount": 179,
				"isBan": 0
			},
			"50": {
				"id": 50,
				"name": "北京赛车(PK10)",
				"mode": 0,
				"sort": 1,
				"cate": 4,
				"maxReward": 0,
				"open": 0,
				"iconUrl": "",
				"pageUrl": "/game/pk10/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": null,
				"curTurnNum": "591402",
				"amount": 179,
				"isBan": 0
			},
			"21": {
				"id": 21,
				"name": "广东11选5",
				"mode": 1,
				"sort": 6,
				"cate": 1,
				"maxReward": 0,
				"open": 0,
				"iconUrl": null,
				"pageUrl": "/game/gd11x5/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": "yyMMdd",
				"curTurnNum": "",
				"amount": 84,
				"isBan": 0
			},
			"70": {
				"id": 70,
				"name": "香港六合彩",
				"mode": 1,
				"sort": 9,
				"cate": 1,
				"maxReward": 0,
				"open": 0,
				"iconUrl": null,
				"pageUrl": "/game/lhc/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": "",
				"curTurnNum": "2016060",
				"amount": 1,
				"isBan": 0
			},
			"55": {
				"id": 55,
				"name": "幸运飞艇",
				"mode": 1,
				"sort": 8,
				"cate": 1,
				"maxReward": 0,
				"open": 0,
				"iconUrl": "",
				"pageUrl": "/game/xyft/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": "yyyyMMdd",
				"curTurnNum": " ",
				"amount": 180,
				"isBan": 0
			},
			"10": {
				"id": 10,
				"name": "江苏骰宝(快3)",
				"mode": 0,
				"sort": 7,
				"cate": 5,
				"maxReward": 0,
				"open": 0,
				"iconUrl": "",
				"pageUrl": "/game/jsk3/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": "yyMMdd",
				"curTurnNum": "",
				"amount": 82,
				"isBan": 0
			},
			"60": {
				"id": 60,
				"name": "广东快乐十分",
				"mode": 1,
				"sort": 3,
				"cate": 1,
				"maxReward": 0,
				"open": 0,
				"iconUrl": null,
				"pageUrl": "/game/gdkl10/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": "yyyyMMdd",
				"curTurnNum": "",
				"amount": 84,
				"isBan": 0
			},
			"61": {
				"id": 61,
				"name": "重庆幸运农场",
				"mode": 1,
				"sort": 4,
				"cate": 1,
				"maxReward": 0,
				"open": 0,
				"iconUrl": null,
				"pageUrl": "/game/xync/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": "yyMMdd",
				"curTurnNum": "",
				"amount": 97,
				"isBan": 0
			}
		};';
		$result .= 'var gameMap = {
			"1": {
				"id": 1,
				"name": "重庆时时彩",
				"mode": 0,
				"sort": 2,
				"cate": 1,
				"maxReward": 0,
				"open": 0,
				"iconUrl": "",
				"pageUrl": "/game/cqssc/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": "yyyyMMdd",
				"curTurnNum": "",
				"amount": 120,
				"isBan": 0
			},
			"65": {
				"id": 65,
				"name": "北京快乐8",
				"mode": 1,
				"sort": 5,
				"cate": 1,
				"maxReward": 0,
				"open": 0,
				"iconUrl": null,
				"pageUrl": "/game/bjkl8/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": "",
				"curTurnNum": "796830",
				"amount": 179,
				"isBan": 0
			},
			"66": {
				"id": 66,
				"name": "PC蛋蛋",
				"mode": 1,
				"sort": 4,
				"cate": 1,
				"maxReward": 0,
				"open": 0,
				"iconUrl": "icon-new",
				"pageUrl": "/game/pcdd/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": null,
				"curTurnNum": "796830",
				"amount": 179,
				"isBan": 0
			},
			"50": {
				"id": 50,
				"name": "北京赛车(PK10)",
				"mode": 0,
				"sort": 1,
				"cate": 4,
				"maxReward": 0,
				"open": 0,
				"iconUrl": "",
				"pageUrl": "/game/pk10/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": null,
				"curTurnNum": "591402",
				"amount": 179,
				"isBan": 0
			},
			"21": {
				"id": 21,
				"name": "广东11选5",
				"mode": 1,
				"sort": 6,
				"cate": 1,
				"maxReward": 0,
				"open": 0,
				"iconUrl": null,
				"pageUrl": "/game/gd11x5/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": "yyMMdd",
				"curTurnNum": "",
				"amount": 84,
				"isBan": 0
			},
			"70": {
				"id": 70,
				"name": "香港六合彩",
				"mode": 1,
				"sort": 9,
				"cate": 1,
				"maxReward": 0,
				"open": 0,
				"iconUrl": null,
				"pageUrl": "/game/lhc/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": "",
				"curTurnNum": "2016060",
				"amount": 1,
				"isBan": 0
			},
			"55": {
				"id": 55,
				"name": "幸运飞艇",
				"mode": 1,
				"sort": 8,
				"cate": 1,
				"maxReward": 0,
				"open": 0,
				"iconUrl": "",
				"pageUrl": "/game/xyft/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": "yyyyMMdd",
				"curTurnNum": " ",
				"amount": 180,
				"isBan": 0
			},
			"10": {
				"id": 10,
				"name": "江苏骰宝(快3)",
				"mode": 0,
				"sort": 7,
				"cate": 5,
				"maxReward": 0,
				"open": 0,
				"iconUrl": "",
				"pageUrl": "/game/jsk3/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": "yyMMdd",
				"curTurnNum": "",
				"amount": 82,
				"isBan": 0
			},
			"60": {
				"id": 60,
				"name": "广东快乐十分",
				"mode": 1,
				"sort": 3,
				"cate": 1,
				"maxReward": 0,
				"open": 0,
				"iconUrl": null,
				"pageUrl": "/game/gdkl10/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": "yyyyMMdd",
				"curTurnNum": "",
				"amount": 84,
				"isBan": 0
			},
			"61": {
				"id": 61,
				"name": "重庆幸运农场",
				"mode": 1,
				"sort": 4,
				"cate": 1,
				"maxReward": 0,
				"open": 0,
				"iconUrl": null,
				"pageUrl": "/game/xync/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": "yyMMdd",
				"curTurnNum": "",
				"amount": 97,
				"isBan": 0
			}
		};';
		$result .= 'var gameMap = {
			"1": {
				"id": 1,
				"name": "重庆时时彩",
				"mode": 0,
				"sort": 2,
				"cate": 1,
				"maxReward": 0,
				"open": 0,
				"iconUrl": "",
				"pageUrl": "/game/cqssc/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": "yyyyMMdd",
				"curTurnNum": "",
				"amount": 120,
				"isBan": 0
			},
			"65": {
				"id": 65,
				"name": "北京快乐8",
				"mode": 1,
				"sort": 5,
				"cate": 1,
				"maxReward": 0,
				"open": 0,
				"iconUrl": null,
				"pageUrl": "/game/bjkl8/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": "",
				"curTurnNum": "796830",
				"amount": 179,
				"isBan": 0
			},
			"66": {
				"id": 66,
				"name": "PC蛋蛋",
				"mode": 1,
				"sort": 4,
				"cate": 1,
				"maxReward": 0,
				"open": 0,
				"iconUrl": "icon-new",
				"pageUrl": "/game/pcdd/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": null,
				"curTurnNum": "796830",
				"amount": 179,
				"isBan": 0
			},
			"50": {
				"id": 50,
				"name": "北京赛车(PK10)",
				"mode": 0,
				"sort": 1,
				"cate": 4,
				"maxReward": 0,
				"open": 0,
				"iconUrl": "",
				"pageUrl": "/game/pk10/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": null,
				"curTurnNum": "591402",
				"amount": 179,
				"isBan": 0
			},
			"21": {
				"id": 21,
				"name": "广东11选5",
				"mode": 1,
				"sort": 6,
				"cate": 1,
				"maxReward": 0,
				"open": 0,
				"iconUrl": null,
				"pageUrl": "/game/gd11x5/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": "yyMMdd",
				"curTurnNum": "",
				"amount": 84,
				"isBan": 0
			},
			"70": {
				"id": 70,
				"name": "香港六合彩",
				"mode": 1,
				"sort": 9,
				"cate": 1,
				"maxReward": 0,
				"open": 0,
				"iconUrl": null,
				"pageUrl": "/game/lhc/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": "",
				"curTurnNum": "2016060",
				"amount": 1,
				"isBan": 0
			},
			"55": {
				"id": 55,
				"name": "幸运飞艇",
				"mode": 1,
				"sort": 8,
				"cate": 1,
				"maxReward": 0,
				"open": 0,
				"iconUrl": "",
				"pageUrl": "/game/xyft/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": "yyyyMMdd",
				"curTurnNum": " ",
				"amount": 180,
				"isBan": 0
			},
			"10": {
				"id": 10,
				"name": "江苏骰宝(快3)",
				"mode": 0,
				"sort": 7,
				"cate": 5,
				"maxReward": 0,
				"open": 0,
				"iconUrl": "",
				"pageUrl": "/game/jsk3/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": "yyMMdd",
				"curTurnNum": "",
				"amount": 82,
				"isBan": 0
			},
			"60": {
				"id": 60,
				"name": "广东快乐十分",
				"mode": 1,
				"sort": 3,
				"cate": 1,
				"maxReward": 0,
				"open": 0,
				"iconUrl": null,
				"pageUrl": "/game/gdkl10/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": "yyyyMMdd",
				"curTurnNum": "",
				"amount": 84,
				"isBan": 0
			},
			"61": {
				"id": 61,
				"name": "重庆幸运农场",
				"mode": 1,
				"sort": 4,
				"cate": 1,
				"maxReward": 0,
				"open": 0,
				"iconUrl": null,
				"pageUrl": "/game/xync/index.html",
				"restStartDate": null,
				"restEndDate": null,
				"turnFormat": "yyMMdd",
				"curTurnNum": "",
				"amount": 97,
				"isBan": 0
			}
		};';
		return $result;
	}
	public function game3()
	{
		$game3=$this->getRows("select * from {$this->prename}played_group order by id asc");
		$allplayCat=array();
		$playCates=array();
		$idkey3=array();
		foreach($game3 as $key => $var){
			$playCates['id']=intval($var['id']);
			$playCates['name']=$var['name'];

			$playCates['gameId'] = intval($var['type']);
			$playCates['code'] = $var['code'];
			$playCates['isShow'] = intval($var['isShow']);
			$playCates['enable'] = intval($var['enable']);//玩法禁用开关
			array_push($idkey3,$var['id']);
			array_push($allplayCat, $playCates);
		}
		$allplayCat2= array_combine($idkey3,$allplayCat);
		return 'var playCates = '.json_encode($allplayCat2).';';
	}


	public final function CurIssuejs(){
		$this->type=$gameId=intval($_GET['gameId']);
		$kjHao=$this->getRow("select * from {$this->prename}data where type={$this->type} and data!='null' and number!='null' order by number desc limit 1");
		$curIssueData=array();
		$curIssueData['gameId']=$this->type;
		$curIssueData['issue']=$kjHao['number'];
		$curIssueData['opentime']=date("Y-m-d H:i:s",$kjHao['time']);
		$curIssueData['nums']=$kjHao['data'];

		/*'var curIssueData = {"gameId":1,"issue":"20161209085","opentime":"2016-12-09 20:10:00","nums":"8,9,4,5,2"};
		jsonpCallback(curIssueData)'*/
		echo 'var curIssueData = '.json_encode($curIssueData).'; jsonpCallback(curIssueData)';
	}
	public final function NextIssuejs(){
		$gameId=intval($_GET['gameId']);
		$lastNo=$this->getGameLastNo($gameId);
		$kjHao=$this->getRow("select * from {$this->prename}data where type={$gameId} and data!='null' and number!='null' order by number desc limit 1");
		//if($kjHao) $kjHao=explode(',', $kjHao);
		$actionNo=$this->getGamenextNo($gameId);
		//var_dump($actionNo);
		$types=$this->getTypes();
		$kjdTime=$types[$gameId]['data_ftime'];
		$diffTime=strtotime($actionNo['actionTime'])-$kjdTime;
		//$kjDiffTime=strtotime($lastNo['actionTime'])-$this->time;
		$nextIssueData=array();
		$nextIssueData['issue']=$actionNo['actionNo'];
		$nextIssueData['endtime']=date("Y-m-d H:i:s", $diffTime);
		$nextIssueData['nums']=null;
		$nextIssueData['lotteryTime']=date("Y-m-d H:i:s",strtotime($actionNo['actionTime']));

		$nextIssueData['preIssue']=$kjHao['number'];
		$nextIssueData['preLotteryTime']=date("Y-m-d H:i:s",$kjHao['time']);
		$nextIssueData['preNum']=$kjHao['data'];
		$nextIssueData['preIsOpen']=true;
		$nextIssueData['serverTime']=date("Y-m-d H:i:s",time());
		$nextIssueData['gameId']=$gameId;

		/*var nextIssueData = {"issue":"20161210073","endtime":"2016-12-10 18:09:00","nums":null,"lotteryTime":"2016-12-10 18:10:00",
		"preIssue":"20161210072","preLotteryTime":"2016-12-10 18:00:00","preNum":"6,4,4,2,4","preIsOpen":true,"serverTime":"2016-12-10 18:03:00","gameId":1};
		jsonpNextIssueCallback(nextIssueData);*/
		echo 'var nextIssueData = '.json_encode($nextIssueData).';
		jsonpNextIssueCallback(nextIssueData);';
	}

	public final function allnextissuejs(){
		$gametype=$this->getRows("select * from {$this->prename}type where enable=1 order by sort asc");
		if($gametype){
		$allgames=array();
		$idkey2=array();
			foreach($gametype as $key => $var){
				$gameId=$var['id'];
				$lastNo=$this->getGameLastNo($gameId);
				$kjHao=$this->getRow("select * from {$this->prename}data where type={$gameId} order by number desc limit 1");
				//if($kjHao) $kjHao=explode(',', $kjHao);
				$actionNo=$this->getGamenextNo($gameId);
				//var_dump($actionNo);
				$types=$this->getTypes();
				$kjdTime=$types[$gameId]['data_ftime'];
				$diffTime=strtotime($actionNo['actionTime'])-$kjdTime;
				//$kjDiffTime=strtotime($lastNo['actionTime'])-$this->time;
				$nextIssueData=array();
				$nextIssueData['issue']=$actionNo['actionNo'];
				$nextIssueData['endtime']=date("Y-m-d H:i:s",$diffTime);
				$nextIssueData['nums']=null;
				$nextIssueData['lotteryTime']=date("Y-m-d H:i:s",strtotime($actionNo['actionTime']));
				
				$nextIssueData['preIssue']=$kjHao['number'];
				$nextIssueData['preLotteryTime']=date("Y-m-d H:i:s",$kjHao['time']);
				$nextIssueData['preNum']=$kjHao['data'];
				$nextIssueData['preIsOpen']=true;
				$nextIssueData['serverTime']=date("Y-m-d H:i:s",time());
				$nextIssueData['gameId']=$gameId;
				array_push($allgames,$nextIssueData);
				array_push($idkey2, $var['id']);

			}
		}
		$allnextIssueData=array_combine($idkey2, $allgames);

		/*var nextIssueData = {"issue":"20161210073","endtime":"2016-12-10 18:09:00","nums":null,"lotteryTime":"2016-12-10 18:10:00",
		"preIssue":"20161210072","preLotteryTime":"2016-12-10 18:00:00","preNum":"6,4,4,2,4","preIsOpen":true,"serverTime":"2016-12-10 18:03:00","gameId":1};
		jsonpNextIssueCallback(nextIssueData);*/
		echo 'var allNextIssueData = '.json_encode($allnextIssueData);
	}

	public final function stat_gamejs(){
		//所有长龙算法函数参数(游戏id, 号码, 大小单双拼音简称)
		//firstsd为判断单双,size为判断大小gy_size为冠亚大小gy_firstsd为冠亚单双	
		function allcl($gameId, $num, $bet){
			if($gameId==50 || $gameId==55){
				return pk10sddx($num, $bet);
			}elseif($gameId==1){
				return cqsscsddx($num, $bet);
			}elseif($gameId==60 || $gameId==61){
				return gdklsf_zhonghe($num, $bet);
			}elseif($gameId==65){
				return bjkl8sddx($num, $bet);
			}elseif($gameId==21){
				return GD11X5ZH($num, $bet);
			}
			
		}	
		require_once("stat_gamefunction.php");
		$gameId=intval($_GET['gameId']);
		if($gameId==50 || $gameId==55){
		require_once("50stat_game.php");
		}elseif($gameId==1){
		require_once("1stat_game.php");
		}elseif($gameId==60 || $gameId==61){
		require_once("60stat_game.php");
		}elseif($gameId==65){
		require_once("65stat_game.php");
		}elseif($gameId==21){
		require_once("21stat_game.php");
		}
		$luzhudata=str_replace('\"', '"', json_encode($tdcount));
		$luzhudata=str_replace('"[', '[', $luzhudata);
		$luzhudata=str_replace(']"', ']', $luzhudata);
		echo 'var luZhuData='.$luzhudata;
		/*var luZhuData={"firstsd_9":[["单"],["双"],["单"],["双"],["单","单"],["双","双","双","双","双"],["单","单","单"],["双","双"],["单","单","单"],["双","双","双","双","双"],["单","单"],["双","双","双"],["单","单","单","单"],["双","双","双"],["单","单"],["双","双","双","双"],["单","单","单"],["双","双","双"],["单"],["双","双"],["单"],["双"],["单"],["双"],["单"],["双"]],"firstsd_8":[["双","双","双"],["单","单"],["双"],["单","单"],["双","双"],["单"],["双"],["单"],["双"],["单"],["双"],["单"],["双","双"],["单","单","单"],["双"],["单"],["双"],["单"],["双"],["单"],["双"],["单","单","单","单","单","单","单"],["双"],["单"],["双"],["单"]]}*/

	}

	public final function statjs(){
		$gameId=intval($_GET['gameId']);
		$datetime=time()-24*3600;
		if($gameId==1){
			$sql=" and (name='大' or name='小' or name='单' or name='双' or name='龙' or name='虎' or name like '总和%' or name like '尾%' or name like '合数%' )";	
		}elseif($gameId==50 || $gameId==55){
			$sql=" and (name='大' or name='小' or name='单' or name='双' or name='龙' or name='虎' or name like '冠亚%')";	
		}elseif($gameId==60 || $gameId==61){
			$sql=" and (name='大' or name='小' or name='单' or name='双' or name='龙' or name='虎' or name like '冠亚%')";	
		}elseif($gameId==66){
			$sql=" and (name='大' or name='小' or name='单' or name='双' or name='豹子' or name like '极%' or name like '%波')";	
		}elseif($gameId==65){
			$sql=" and (name like '总%')";	
		}elseif($gameId==21){
			$sql=" and (name='大' or name='小' or name='单' or name='双' or name='龙' or name='虎' or name like '总和%')";	
		}
		$clong=$this->getRows("select id, name, played_groupid from {$this->prename}played where type={$gameId} {$sql} order by id asc");
		//var_dump($clong);
		$curStatList=array();
		$statarr=array();
		if($clong){
			foreach($clong as $key => $var){
				$playedGroup=$this->playedGroup[$var['played_groupid']];
				if($gameId==1){
					$count=$this->cqssccl($gameId, $var['name'],$playedGroup['name']);
				}elseif($gameId==50 || $gameId==55){
					$count=$this->pk10cl($gameId, $var['name'],$playedGroup['name']);
				}elseif($gameId==60 || $gameId==61){
					$count=$this->klsfcl($gameId, $var['name'],$playedGroup['name']);
				}elseif($gameId==66){
					$count=$this->pcddcl($gameId, $var['name'],$playedGroup['name']);
				}elseif($gameId==65){
					$count=$this->bjkl8cl($gameId, $var['name'],$playedGroup['name']);
				}elseif($gameId==21){
					$count=$this->gd11x5cl($gameId, $var['name'],$playedGroup['name']);
				}
				if($count>2){
				$statarr['playId']=$var['id'];
				$statarr['playName']=$var['name'];
				$statarr['gameId']=$gameId;
				$statarr['playCateId']=$var['played_groupid'];
				$statarr['playCateName']=$playedGroup['name'];
				$statarr['count']=$count;
				array_push($curStatList,$statarr);
				}
				//echo $this->pk10cl($gameId, $var['name'],$playedGroup['name']);
			}
			foreach($curStatList as $arr2){
			$curStatList2[]=$arr2["count"];
			}
			array_multisort($curStatList2, SORT_DESC, $curStatList);	
			//var_dump($curStatList);
			echo 'curStatList='.json_encode($curStatList).';jsonpStatCallback(curStatList)';
		}

		/*curStatList=[{"playId":501902,"playName":"小","gameId":50,"playCateId":19,"playCateName":"第九名","$count":8},{"playId":502002,"playName":"小","gameId":50,"playCateId":20,"playCateName":"第十名","$count":4},{"playId":501002,"playName":"冠亚小","gameId":50,"playCateId":10,"playCateName":"冠、亚军和","$count":3},{"playId":501102,"playName":"小","gameId":50,"playCateId":11,"playCateName":"冠军","$count":3},{"playId":501204,"playName":"双","gameId":50,"playCateId":12,"playCateName":"亚军","$count":3},{"playId":501406,"playName":"虎","gameId":50,"playCateId":14,"playCateName":"第四名","$count":3},{"playId":501501,"playName":"大","gameId":50,"playCateId":15,"playCateName":"第五名","$count":3},{"playId":501603,"playName":"单","gameId":50,"playCateId":16,"playCateName":"第六名","$count":3},{"playId":501701,"playName":"大","gameId":50,"playCateId":17,"playCateName":"第七名","$count":3}];
		jsonpStatCallback(curStatList)*/
	}

	public final function HistoryLotteryjs(){
		
		$this->type=$gameId=intval($_GET['gameId']);
		if(intval($_GET['dateStr'])){
		$datenum=intval($_GET['dateStr']);
		$dateStr=strtotime(date('Y-m-d 00:00:00',strtotime(intval($_GET['dateStr']))));
		$dateStr2=strtotime(date('Y-m-d 23:59:59',strtotime(intval($_GET['dateStr']))));

		}else{
		$datenum=date('Ymd',time());
		$dateStr=strtotime(date('Y-m-d 00:00:00',time()));	
		$dateStr2=strtotime(date('Y-m-d 23:59:59',time()));

		}
		if($this->type==70){
		$data=$this->getRows("select * from {$this->prename}data where type={$this->type} order by number desc,time desc limit 50");
		}elseif($this->type==1 || $this->type==55){
		$data=$this->getRows("select * from {$this->prename}data where type={$this->type} and number like '{$datenum}%' order by number desc,time desc");	
		}else{
		$data=$this->getRows("select * from {$this->prename}data where type={$this->type} and time >= '{$dateStr}' and time <= '{$dateStr2}' order by number desc,time desc");	
		}
			$types=$this->getTypes();
			$kjdTime=$types[$gameId]['data_ftime'];
		$alldata=array();
		$historyData=array();
		$historyData['id']=null;
		$historyData['betEndTime']=null;
		$historyData['turnNum']=null;
		$historyData['openNum']=null;
		$historyData['openTime']=null;
		$historyData['gameId']=$this->type;
		$historyData['status']=2;
		$historyData['remark']=null;
		/*$historyData['n1']=null;
		$historyData['n2']=null;
		$historyData['n3']=null;
		$historyData['n4']=null;
		$historyData['n5']=null;
		$historyData['n6']=null;
		$historyData['n7']=null;
		$historyData['n8']=null;
		$historyData['n9']=null;
		$historyData['n10']=null;
		$historyData['n11']=null;
		$historyData['n12']=null;
		$historyData['n13']=null;
		$historyData['n14']=null;
		$historyData['n15']=null;
		$historyData['n16']=null;
		$historyData['n17']=null;
		$historyData['n18']=null;
		$historyData['n19']=null;
		$historyData['n20']=null;*/
		$historyData['statDate']=date("Y-m-d H:i:s",time());
		/*for($i = 1; $i <= 20; $i++){
			echo '$n'.$i.'=';
		}*/
		$historyData2='';
		foreach ($data as $key=>$value){
			//echo $value['number'];
			$lastNo=$this->getGameLastNo($gameId,$value['time']);
			$diffTime=strtotime($lastNo['actionTime'])-$kjdTime;
			//echo $lastNo['actionNo'].'_'.$lastNo['actionTime'].'<br>';

		$historyData['id']=intval($value['id']);
		$historyData['betEndTime']=date("Y-m-d H:i:s",$diffTime);
		$historyData['turnNum']=$value['number'];
		$historyData['openNum']=$value['data'];
		$historyData['openTime']=date("Y-m-d H:i:s",strtotime($lastNo['actionTime']));
			$nums = explode(',', $value['data']);
			foreach ($nums as $keynum=>$n){
				$historyData['n'.($keynum+1)]=intval($n);
			}
		array_push($alldata,$historyData);

		}

		echo 'var historyData = '.json_encode($alldata).';
		jsonpCallback(historyData);';
		 /*var historyData = [{"id":402262,"betEndTime":"2016-12-08 21:30:00","turnNum":"2016142","openNum":"39,37,24,09,26,28,29","openTime":"2016-12-08 21:35:00","gameId":70,"status":2,"remark":"","n1":39,"n2":37,"n3":24,"n4":9,"n5":26,"n6":28,"n7":29,"n8":null,"n9":null,"n10":null,"n11":null,"n12":null,"n13":null,"n14":null,"n15":null,"n16":null,"n17":null,"n18":null,"n19":null,"n20":null,"statDate":"2016-12-08 00:00:00"}];
		jsonpCallback(historyData);*/
	}

	public final function cqssccl($gameId, $bet, $Groupname=null){
		$count=0;
		$clong=$this->getRows("select data from {$this->prename}data where type={$gameId} order by number desc limit 20");
		//var_dump($clong);
		foreach($clong as $key => $var){
		$kj=explode(',',$var['data']);
		if($Groupname=='第一球'){
			$val=intval($kj[0]);
		}elseif($Groupname=='第二球'){
			$val=intval($kj[1]);
		}elseif($Groupname=='第三球'){
			$val=intval($kj[2]);
		}elseif($Groupname=='第四球'){	
			$val=intval($kj[3]);
		}elseif($Groupname=='第五球'){	
			$val=intval($kj[4]);
		}else{	
		$val=intval($kj[0])+intval($kj[1])+intval($kj[2])+intval($kj[3])+intval($kj[4]);
		$vala=intval($kj[0]);
		$val5=intval($kj[4]);
		}
		
	        if($bet=='大'){
	            //号码为0到9
	            if($val>=5 && $val<=9){
	            $tempcount+=1;	
	            if($tempcount > 2) $count=$tempcount;	
	            }else{return $count;}
	        }elseif($bet=='小'){
	            //号码为0到9
	            if($val>=0 && $val<=4){
	            $tempcount+=1;	
	            if($tempcount > 2) $count=$tempcount;	
	            }else{return $count;}
	        }elseif($bet=='单'){
	            if($val%2!=0){
	            $tempcount+=1;	
	            if($tempcount > 2) $count=$tempcount;	
	            }else{return $count;}
	        }elseif($bet=='双'){
				if($val%2==0){
					$tempcount+=1;	
					if($tempcount > 2) $count=$tempcount;	
				}else{return $count;}
			}elseif($bet=='总和大'){
				if($val>22){
					$tempcount+=1;	
					if($tempcount > 2) $count=$tempcount;	
				}else{return $count;}
				
			}elseif($bet=='总和小'){
				if($val>=0 && $val<23){
					$tempcount+=1;	
					if($tempcount > 2) $count=$tempcount;	
				}else{return $count;}
				
			}elseif($bet=='总和单'){
				if($val%2!=0){
					$tempcount+=1;	
					if($tempcount > 2) $count=$tempcount;	
				}else{return $count;}
				
			}elseif($bet=='总和双'){
				if($val%2==0){
					$tempcount+=1;	
					if($tempcount > 2) $count=$tempcount;	
				}else{return $count;}
				
			}elseif($bet=='龙'){
				if($vala>$val5){
					$tempcount+=1;	
					if($tempcount > 2) $count=$tempcount;	
				}else{return $count;}
				
			}elseif($bet=='虎'){
				if($val5>$vala){
					$tempcount+=1;	
					if($tempcount > 2) $count=$tempcount;	
				}else{return $count;}
				
			}elseif($bet=='和'){
				if($vala==$val5){
					$tempcount+=1;	
					if($tempcount > 2) $count=$tempcount;	
				}else{return $count;}
				
			}
		}
		return $count;
	}
		
	public final function pk10cl($gameId, $bet, $Groupname=null){
		$count=0;
		$clong=$this->getRows("select data from {$this->prename}data where type={$gameId} order by number desc limit 20");
		//var_dump($clong);
		foreach($clong as $key => $var){
		$kj=explode(',',$var['data']);
		if($Groupname=='冠军'){
			$val=intval($kj[0]);
			$val2=intval($kj[9]);
		}elseif($Groupname=='亚军'){
			$val=intval($kj[1]);
			$val2=intval($kj[8]); //8为第9个数	
		}elseif($Groupname=='第三名'){
			$val=intval($kj[2]);
			$val2=intval($kj[7]);
		}elseif($Groupname=='第四名'){	
			$val=intval($kj[3]);
			$val2=intval($kj[6]);
		}elseif($Groupname=='第五名'){	
			$val=intval($kj[4]);
			$val2=intval($kj[5]);
		}elseif($Groupname=='第六名'){	
			$val=intval($kj[5]);
		}elseif($Groupname=='第七名'){	
			$val=intval($kj[6]);
		}elseif($Groupname=='第八名'){	
			$val=intval($kj[7]);
		}elseif($Groupname=='第九名'){	
			$val=intval($kj[8]);
		}elseif($Groupname=='第十名'){	
			$val=intval($kj[9]);
		}else{
			$val=intval($kj[0])+intval($kj[1]);		
		}
			if($bet=='大'){
				if($val>=6 && $val<11){
					$tempcount+=1;	
					if($tempcount > 2) $count=$tempcount;	
				}else{return $count;}
				//return $count;
			}elseif($bet=='小'){
				if($val>0 && $val<=5){
					$tempcount+=1;	
					if($tempcount > 2) $count=$tempcount;	
				}else{return $count;}
				//return $count;
			}elseif($bet=='单'){
				if($val%2!=0){
					$tempcount+=1;	
					if($tempcount > 2) $count=$tempcount;	
				}else{return $count;}
				//return $count;
			}elseif($bet=='双'){
				if($val%2==0){
					$tempcount+=1;	
					if($tempcount > 2) $count=$tempcount;	
				}else{return $count;}
				//return $count;
			}elseif($bet=='龙'){
				if($val>$val2 && $val2){
					$tempcount+=1;	
					if($tempcount > 2) $count=$tempcount;	
				}else{return $count;}
				//return $count;
			}elseif($bet=='虎'){
				if($val2>$val && $val2){
					$tempcount+=1;	
					if($tempcount > 2) $count=$tempcount;	
				}else{return $count;}
				//return $count;
			}elseif($bet=='冠亚大'){
				if($val>11 && $val<20){
					$tempcount+=1;	
					if($tempcount > 2) $count=$tempcount;	
				}else{return $count;}
				//return $count;
			}elseif($bet=='冠亚小'){
				if($val>2 && $val<12){
					$tempcount+=1;	
					if($tempcount > 2) $count=$tempcount;	
				}else{return $count;}
				//return $count;
			}elseif($bet=='冠亚单'){
				if($val%2!=0){
					$tempcount+=1;	
					if($tempcount > 2) $count=$tempcount;	
				}else{return $count;}
				//return $count;
			}elseif($bet=='冠亚双'){
				if($val%2==0){
					$tempcount+=1;	
					if($tempcount > 2) $count=$tempcount;	
				}else{return $count;}
				//return $count;
			}
		}
		return $count;
	}
		
	public final function klsfcl($gameId, $bet, $Groupname=null){
		$count=0;
		$clong=$this->getRows("select data from {$this->prename}data where type={$gameId} order by number desc limit 20");
		//var_dump($clong);
		foreach($clong as $key => $var){
			$kj=explode(',',$var['data']);
			if($Groupname=='第一球'){
				$val=intval($kj[0]);
				$val3=intval($kj[7]);
			}elseif($Groupname=='第二球'){
				$val=intval($kj[1]);
				$val3=intval($kj[6]);
			}elseif($Groupname=='第三球'){
				$val=intval($kj[2]);
				$val3=intval($kj[5]);
			}elseif($Groupname=='第四球'){	
				$val=intval($kj[3]);
				$val3=intval($kj[4]);
			}elseif($Groupname=='第五球'){	
				$val=intval($kj[4]);
			}elseif($Groupname=='第六球'){	
				$val=intval($kj[5]);
			}elseif($Groupname=='第七球'){	
				$val=intval($kj[6]);
			}elseif($Groupname=='第八球'){	
				$val=intval($kj[7]);
			}else{
				$val=intval($kj[0])+intval($kj[1])+intval($kj[2])+intval($kj[3])+intval($kj[4])+intval($kj[5])+intval($kj[6])+intval($kj[7])+intval($kj[8]);
				$str=strval($val);
				$val2=intval(substr($str,-1));
			}
			
			if($bet=='总和大'){
				if($val>84 && $val<133){
	            $tempcount+=1;	
	            if($tempcount > 2) $count=$tempcount;	
	            }else{return $count;}
			}elseif($bet=='总和小'){
				if($val>35 && $val<84){
	            $tempcount+=1;	
	            if($tempcount > 2) $count=$tempcount;	
	            }else{return $count;}
			}elseif($bet=='总和单'){
				if($val%2!=0){
	            $tempcount+=1;	
	            if($tempcount > 2) $count=$tempcount;	
	            }else{return $count;}
			}elseif($bet=='总和双'){
				if($val%2==0){
	            $tempcount+=1;	
	            if($tempcount > 2) $count=$tempcount;	
	            }else{return $count;}
			}elseif($bet=='总和尾大'){
				if($val2>4){
	            $tempcount+=1;	
	            if($tempcount > 2) $count=$tempcount;	
	            }else{return $count;}
			}elseif($bet=='总和尾小'){
				if($val2<5){
	            $tempcount+=1;	
	            if($tempcount > 2) $count=$tempcount;	
	            }else{return $count;}
			}elseif($bet=='大'){
				if($val>10 && $val<21){
	            $tempcount+=1;	
	            if($tempcount > 2) $count=$tempcount;	
	            }else{return $count;}
			}elseif($bet=='小'){
				if($val>0 && $val<11){
	            $tempcount+=1;	
			if($tempcount > 2) $count=$tempcount;	
				}else{return $count;}
			}elseif($bet=='单'){
				if($val%2!=0){
		            $tempcount+=1;	
				if($tempcount > 2) $count=$tempcount;	
				}else{return $count;}
			}elseif($bet=='双'){
				if($val%2==0){
	            $tempcount+=1;	
				if($tempcount > 2) $count=$tempcount;	
				}else{return $count;}
			}elseif($bet=='尾大'){
				$str=strval($val);
				$val2=intval(substr($str,-1));
				if($val2>4){
	            $tempcount+=1;	
				if($tempcount > 2) $count=$tempcount;	
				}else{return $count;}
			}elseif($bet=='尾小'){
				$str=strval($val);
				$val2=intval(substr($str,-1));
				if($val2<5){
	            $tempcount+=1;	
				if($tempcount > 2) $count=$tempcount;	
				}else{return $count;}
			}elseif($bet=='合数单'){
				if($val>0 && $val<10){
					if($val%2!=0)  $tempcount+=1;
				}elseif($val>9 && $val<21){
				$str=strval($val);
				$val2=intval(substr($str,-1)) + intval(substr($str,0,1));
				if($val%2!=0)  $tempcount+=1;	
				}
				if($tempcount > 2){
					$count=$tempcount;
				}else{return $count;}
			}elseif($bet=='合数双'){
				if($val>0 && $val<10){
				if($val%2==0) $tempcount+=1;
				
				}elseif($val>9 && $val<21){
				$str=strval($val);
				$val2=intval(substr($str,-1)) + intval(substr($str,0,1));		
				if($val%2==0) $tempcount+=1;
				}
				if($tempcount > 2){
					$count=$tempcount;
				}else{return $count;}
			}elseif($bet=='龙'){
				if($val>$val3 && $val3){
	            $tempcount+=1;	
				if($tempcount > 2) $count=$tempcount;	
				}else{return $count;}
			}elseif($bet=='虎'){
				if($val3>$val && $val3){
	            $tempcount+=1;	
				if($tempcount > 2) $count=$tempcount;	
				}else{return $count;}
			}	
		}
		return $count;
	}
		
	public final function pcddcl($gameId, $bet, $Groupname=null){
		$count=0;
		$clong=$this->getRows("select data from {$this->prename}data where type={$gameId} order by number desc limit 20");
		//var_dump($clong);
		foreach($clong as $key => $var){
			$kj=explode(',',$var['data']);
			$kjhe=intval($kj[0]) + intval($kj[1]) + intval($kj[2]);
			//var_dump($kjhe);
			if($bet=='大'){
				if($kjhe>=14){
					$tempcount+=1;	
					if($tempcount > 2) $count=$tempcount;	
				}else{return $count;}
			}elseif($bet=='小'){
				if($kjhe<=13){
					$tempcount+=1;	
					if($tempcount > 2) $count=$tempcount;	
				}else{return $count;}
			}elseif($bet=='单'){
				if($kjhe%2!=0){
					$tempcount+=1;	
					if($tempcount > 2) $count=$tempcount;	
				}else{return $count;}
			}elseif($bet=='双'){
				if($kjhe%2==0){
					$tempcount+=1;	
					if($tempcount > 2) $count=$tempcount;	
				}else{return $count;}
			}elseif($bet=='极大'){
				if($kjhe>=23){
					$tempcount+=1;	
					if($tempcount > 2) $count=$tempcount;	
				}else{return $count;}
			}elseif($bet=='极小'){
				if($kjhe<=4){
					$tempcount+=1;	
					if($tempcount > 2) $count=$tempcount;	
				}else{return $count;}
			}elseif($bet=='豹子'){
				$kja=intval($kj[0]);
				$kjb=intval($kj[1]);
				$kjc=intval($kj[2]);
				if($kja==$kjb && $kja==$kjc){
					$tempcount+=1;	
					if($tempcount > 2) $count=$tempcount;	
				}else{return $count;}
			}elseif($bet=='红波'){
				if($kjhe !=0 && $kjhe !=13 && $kjhe !=14 && $kjhe !=27){		
					if($kjhe%3==0){
					$tempcount+=1;	
					if($tempcount > 2) $count=$tempcount;	
					}else{return $count;}
				}else{return $count;}
			}elseif($bet=='绿波'){
				//0,13,14,27
				if($kjhe !=0 && $kjhe !=13 && $kjhe !=14 && $kjhe !=27){
					if($kjhe%3==1 || $kjhe==1){
					$tempcount+=1;	
					if($tempcount > 2) $count=$tempcount;	
					}else{return $count;}
				}else{return $count;}
			}elseif($bet=='蓝波'){
				if($kjhe !=0 && $kjhe !=13 && $kjhe !=14 && $kjhe !=27){	
					if($kjhe%3==2 || $kjhe==2){
					$tempcount+=1;	
					if($tempcount > 2) $count=$tempcount;	
					}else{return $count;}
				}else{return $count;}
			}
		
		}
		return $count;
	}	
		
	public final function bjkl8cl($gameId, $bet, $Groupname=null){
		$count=0;
		$clong=$this->getRows("select data from {$this->prename}data where type={$gameId} order by number desc limit 20");
		//var_dump($clong);
		foreach($clong as $key => $var){
			$kj=explode(',',$var['data']);
			$kjhe=0;
			foreach($kj as $k=>$kjdata){
				$kjhe+=$kjdata;
			}
			//var_dump($kjhe);
			if($bet=='总和大'){
				if($kjhe>810){
					$tempcount+=1;	
					if($tempcount > 2) $count=$tempcount;	
				}else{return $count;}
			}elseif($bet=='总和小'){
				if($kjhe<810){
					$tempcount+=1;	
					if($tempcount > 2) $count=$tempcount;	
				}else{return $count;}
			}elseif($bet=='总和单'){
				if($kjhe%2!=0){
					$tempcount+=1;	
					if($tempcount > 2) $count=$tempcount;	
				}else{return $count;}
			}elseif($bet=='总和双'){
				if($kjhe%2==0 && $kjhe){
					$tempcount+=1;	
					if($tempcount > 2) $count=$tempcount;	
				}else{return $count;}
			}elseif($bet=='总大单'){
				if($kjhe>810 && $kjhe%2!=0){
					$tempcount+=1;	
					if($tempcount > 2) $count=$tempcount;	
				}else{return $count;}
			}elseif($bet=='总大双'){
				if($kjhe>810 && $kjhe%2==0){
					$tempcount+=1;	
					if($tempcount > 2) $count=$tempcount;	
				}else{return $count;}
			}elseif($bet=='总小单'){
				if($kjhe<810 && $kjhe%2!=0){
					$tempcount+=1;	
					if($tempcount > 2) $count=$tempcount;	
				}else{return $count;}
			}elseif($bet=='总小双'){
				if($kjhe<810 && $kjhe%2==0){
					$tempcount+=1;	
					if($tempcount > 2) $count=$tempcount;	
				}else{return $count;}
			}			
		}
		return $count;
	}

	public final function gd11x5cl($gameId, $bet, $Groupname=null){
		$count=0;
		$clong=$this->getRows("select data from {$this->prename}data where type={$gameId} order by number desc limit 20");
		//var_dump($clong);
		foreach($clong as $key => $var){
			$kj=explode(',',$var['data']);
			$kjhe=0;
			foreach($kj as $k=>$kjdata){
				$kjhe+=$kjdata;
			}
			if($Groupname=='第一球'){
				$val=intval($kj[0]);	
			}elseif($Groupname=='第二球'){
				$val=intval($kj[1]);	
			}elseif($Groupname=='第三球'){
				$val=intval($kj[2]);	
			}elseif($Groupname=='第四球'){
				$val=intval($kj[3]);	
			}elseif($Groupname=='第五球'){
				$val=intval($kj[4]);	
			}
				if($bet=='大'){
					if($val>=6 && $val<11){
						$tempcount+=1;	
						if($tempcount > 2) $count=$tempcount;	
					}else{return $count;}
				}elseif($bet=='小'){
					if($val>0 && $val<=5){
						$tempcount+=1;	
						if($tempcount > 2) $count=$tempcount;	
					}else{return $count;}
				}elseif($bet=='单'){
					if($val%2!=0 && $val != 11){
						$tempcount+=1;	
						if($tempcount > 2) $count=$tempcount;	
					}else{return $count;}
				}elseif($bet=='双'){
					if($val%2==0 && $val != 11){
						$tempcount+=1;	
						if($tempcount > 2) $count=$tempcount;	
					}else{return $count;}
				}elseif($bet=='总和大'){
					if($kjhe>30){
						$tempcount+=1;	
						if($tempcount > 2) $count=$tempcount;	
					}else{return $count;}
				}elseif($bet=='总和小'){
					if($kjhe<30){
						$tempcount+=1;	
						if($tempcount > 2) $count=$tempcount;	
					}else{return $count;}
				}elseif($bet=='总和单'){
					if($kjhe%2!=0){
						$tempcount+=1;	
						if($tempcount > 2) $count=$tempcount;	
					}else{return $count;}
				}elseif($bet=='总和双'){
					if($kjhe%2==0){
						$tempcount+=1;	
						if($tempcount > 2) $count=$tempcount;	
					}else{return $count;}
				}elseif($bet=='总和尾大'){
					$str=strval($kjhe);
					$val2=intval(substr($str, -1));
					if($val2>4){
						$tempcount+=1;	
						if($tempcount > 2) $count=$tempcount;	
					}else{return $count;}
				}elseif($bet=='总和尾小'){
					$str=strval($kjhe);
					$val2=intval(substr($str, -1));
					if($val2<5){
						$tempcount+=1;	
						if($tempcount > 2) $count=$tempcount;	
					}else{return $count;}
				}elseif($bet=='龙'){
					if(intval($kj[0]) > intval($kj[4])){
						$tempcount+=1;	
						if($tempcount > 2) $count=$tempcount;	
					}else{return $count;}
				}elseif($bet=='虎'){
					if(intval($kj[0]) < intval($kj[4])){
						$tempcount+=1;	
						if($tempcount > 2) $count=$tempcount;	
					}else{return $count;}
				}
		}
		return $count;

	}

}

?>
