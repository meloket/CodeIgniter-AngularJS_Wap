<?php

defined('BASEPATH') or exit('No direct script access allowed');

class WebBase_Controller extends Object_Controller
{
	public $controller;
	public $action;
	public $user;
	public $headers;
	public $page = 1;
	public $title = 'Maleo';
	public $params = array();	
	public $types;			
	public $playeds;	
	public $playeds2;
	public $playedGroup;
	public $urlPasswordKey = '2u392!3ur92uf93@2r23#fe';

	public $gameFanDian;

    public function __construct()
    {
        parent::__construct();

        try{
			if($this->session->userdata($this->memberSessionName)) {
				$this->user = unserialize($this->session->userdata($this->memberSessionName));
				$this->updateSessionTime();
			}
			else if(isset($_POST['x-session-token']))
			{
				$token = $_POST['x-session-token'];
				$sql = "select * from {$this->prename}member_session where token='{$token}' and isOnLine=1 limit 0,1";
				if($session = $this->getRow($sql, $token))
				{
					$sql = "select * from {$this->prename}members where isDelete=0 and admin=0 and username='{$session['username']}' limit 0,1";
					$this->user = $this->getRow($sql, $session['username']);
					$this->user['sessionId'] = $session['id'];
					$this->user['token'] = $token;
					$this->user['session_key'] = $session['session_key'];
					$this->session->set_userdata($this->memberSessionName, serialize($this->user));
				}
			}

			if(isset($this->user) && $this->user['uid'])
			{
				if(!$this->input->cookie('token'))
				{
					$token = base64_encode(crypt($this->user['session_key'], $this->user['username']).md5($this->user['updateTime']));
					$cookie = array(
						'name'   => 'token',
						'value'  => $token,
						'expire' => 0,
						'path' => '/'
					);
					$this->input->set_cookie($cookie);
				}
			}
			else	
			{	
				if($this->input->cookie('token'))	
				{
					$cookie = array(	
                        'name'   => 'token',	
                        'value'  => NULL,                            	
                        'expire' => 0,	
                        'path' => '/'	
                    );	
					$this->input->set_cookie($cookie);	
				}
			}
			
		}
		catch(Exception $e)
		{
			log_message('error', '[Class->CRM_Controller, Method->Construct] : '.$e->getMessage() );
		}
    }
    
    /* aaron-add */
    public function freshSession(){
		if(!$this->user) 
			return false;
		
		$sessionId = $this->user['sessionId'];

		if($this->user['testFlag'] == 1){
			$sql = "select * from {$this->prename}guestmembers where uid={$this->user['uid']}";
		}
		else{
			$sql = "select * from {$this->prename}members where uid={$this->user['uid']}";
		}
		$user = $this->getRow($sql, $this->user['uid']);
		$user['sessionId'] = $sessionId;
		$user['token'] = $this->user['token'];
		$user['session_key'] = $this->user['session_key'];

		$user['_gameFanDian'] = $this->getGameFanDian();
		$this->session->set_userdata($this->memberSessionName, serialize($user));
		$this->user = $user;
		return true;
	}
	/* aaron-add */
	public function getGameFanDian(){
		if($this->gameFanDian) return $this->gameFanDian;
		$this->getSystemSettings();
		return $this->gameFanDian=$this->settings['fanDianMax'];
	}
	/* aaron-add */
	public function getSystemSettings($expire = null)
    {
		if($expire === null) 
			$expire=$this->expire;

		$file = $this->cacheDir . 'systemSettings';
		if($expire && is_file($file) && filemtime($file)+$expire>$this->time){
			return $this->settings=unserialize(file_get_contents($file));
		}
		$sql="select * from {$this->prename}params";
		$this->settings=array();
		if($data=$this->getRows($sql)){
			foreach($data as $var){
				$this->settings[$var['name']]=$var['value'];
			}
		}
		file_put_contents($file, serialize($this->settings));
		return $this->settings;
	}
	/* aaron-add */
	public function getSystemCache($cacheFile, $getvalue='', $expire=null){	
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
			$this->display($cacheFile);
			file_put_contents($file, ob_get_contents()); 
			ob_end_flush();
		}  
	}
	
    /* aaron-add */
    public function getBrowser(){
    	
		$flag=$_SERVER['HTTP_USER_AGENT'];
		$para=array();
		
		// 检查操作系统
		if(preg_match('/Windows[\d\. \w]*/',$flag, $match)) $para['os']=$match[0];
		
		if(preg_match('/Chrome\/[\d\.\w]*/',$flag, $match)){
			// 检查Chrome
			$para['browser']=$match[0];
		}elseif(preg_match('/Safari\/[\d\.\w]*/',$flag, $match)){
			// 检查Safari
			$para['browser']=$match[0];
		}elseif(preg_match('/MSIE [\d\.\w]*/',$flag, $match)){
			// IE
			$para['browser']=$match[0];
		}elseif(preg_match('/Opera\/[\d\.\w]*/',$flag, $match)){
			// opera
			$para['browser']=$match[0];
		}elseif(preg_match('/Firefox\/[\d\.\w]*/',$flag, $match)){
			// Firefox
			$para['browser']=$match[0];
		}elseif(preg_match('/OmniWeb\/(v*)([^\s|;]+)/i',$flag, $match)){
			//OmniWeb
			$para['browser']=$match[2];
		}elseif(preg_match('/Netscape([\d]*)\/([^\s]+)/i',$flag, $match)){
			//Netscape
			$para['browser']=$match[2];
		}elseif(preg_match('/Lynx\/([^\s]+)/i',$flag, $match)){
			//Lynx
			$para['browser']=$match[1];
		}elseif(preg_match('/360SE/i',$flag, $match)){
			//360SE
			$para['browser']='360安全浏览器';
		}elseif(preg_match('/SE 2.x/i',$flag, $match)) {
			//搜狗
			$para['browser']='搜狗浏览器';
		}else{
			$para['browser']='unkown';
		}
		//print_r($para);exit;
		return $para;
	}

	public function getTypes(){
		if($this->types) return $this->types;
		$sql="select * from {$this->prename}type where isDelete=0 order by sort asc";
		return $this->types=$this->getObject($sql, 'id');
	}
	
	public function getPlayeds(){
		if($this->playeds) return $this->playeds;
		$sql="select * from {$this->prename}played ";
		return $this->playeds=$this->getObject($sql, 'id');
	}
	
	public function getPlayeds2(){
		if($this->playeds2) return $this->playeds2;
		$sql="select * from {$this->prename}played2 ";
		return $this->playeds2=$this->getObject($sql, 'id');
	}
	
	public function getplayedGroup(){
		if($this->playedGroup) return $this->playedGroup;
		$sql="select * from {$this->prename}played_group ";
		return $this->playedGroup=$this->getObject($sql, 'id');
	}

	
	public function getSystemConfig(){
		$file=$this->cacheDir .'FDJSALKFJSIDFJSKLJFFSJDafkljdasa5235465723';
		if(is_file($file) && filemtime($file)+$this->expire>$this->time){
			$this->params=unserialize(file_get_contents($file));
		}else{
			$sql="select name, value from {$this->prename}params";
			if($data=$this->getRows($sql)) foreach($data as $var){
				$this->params[$var['name']]=$var['value'];
			}
			//print_r($data);
			file_put_contents($file, serialize($this->params));
		}
	}
	
	public function getGameNo($type, $time=null){
		$type=intval($type);
		if($time===null) $time=$this->time;
		$kjTime=$this->getTypeFtime($type);
		$atime=date('H:i:s', $time+$kjTime);
		
		$sql="select actionNo, actionTime from {$this->prename}data_time where type=$type and actionTime>'{$atime}' order by actionTime limit 1";
		if($type==70){
		$atime=date('y-m-d H:i:s', $time+$kjTime);
		 $sql="select actionNo, actionTime from {$this->prename}data_time where type=$type and lhcTime>'{$atime}' order by actionNo limit 1";}
		$return = $this->getRow($sql, $atime);
		if(!$return){
			$sql="select actionNo, actionTime from {$this->prename}data_time where type=$type order by actionTime limit 1";
			$return =$this->getRow($sql, $atime);
			$time=$time+24*3600;
		}
		
		$types=$this->getTypes();
		if(($fun=$types[$type]['onGetNoed']) && method_exists($this, $fun)){
			$this->$fun($return['actionNo'], $return['actionTime'], $time);
		}
		
		return $return;
	}

	public function getGameLastNo($type, $time=null){
		$type=intval($type);
		if($time===null) $time=$this->time;
		$kjTime=$this->getTypeFtime($type);
		$atime=date('H:i:s', $time);
		$sql="select actionNo, actionTime from {$this->prename}data_time where type=$type and actionTime<='{$atime}' order by actionTime desc limit 1";
		$return = $this->getRow($sql, $atime);
		if(!$return){
			$sql="select actionNo, actionTime from {$this->prename}data_time where type=$type order by actionNo desc limit 1";
			$return =$this->getRow($sql, $atime);
			$time=$time-24*3600;
		}
		$types=$this->getTypes();
		if(($fun=$types[$type]['onGetNoed']) && method_exists($this, $fun)){
			$this->$fun($return['actionNo'], $return['actionTime'], $time);
		}
		return $return;
	}

	public function getGamenextNo($type, $time=null){
		$type=intval($type);
		if($time===null) $time=$this->time;
		$kjTime=$this->getTypeFtime($type);
		$atime=date('H:i:s', $time);
		$sql="select actionNo, actionTime from {$this->prename}data_time where type=$type and actionTime>'{$atime}' order by actionTime limit 1";
		if($type==70) {
			$atime=date('y-m-d H:i:s', $time);
			$sql="select actionNo, actionTime from {$this->prename}data_time where type=$type and lhcTime>'{$atime}' order by actionNo limit 1";
		}
		$return = $this->getRow($sql, $atime);
		if(!$return){
			$sql="select actionNo, actionTime from {$this->prename}data_time where type=$type order by actionTime limit 1";
			$return =$this->getRow($sql, $atime);
			$time=$time+24*3600;
		}
		$types=$this->getTypes();
		if(($fun=$types[$type]['onGetNoed']) && method_exists($this, $fun)){
			$this->$fun($return['actionNo'], $return['actionTime'], $time);
		}
		return $return;
	}
	
	public function getGameNos($type, $num=0, $time=null){
		$type=intval($type);
		if($time===null) $time=$this->time;
		$ptime=date('H:i:s', $time);
		
		$sql="select actionNo, actionTime from {$this->prename}data_time where type=$type and actionTime>'{$ptime}' order by actionTime";
		if($num) $sql.=" limit $num";
		$return = $this->getRows($sql, $ptime);
		$types=$this->getTypes();
		if(($fun=$types[$type]['onGetNoed']) && method_exists($this, $fun)){
			if($return) foreach($return as $i=>$var){
				$this->$fun($return[$i]['actionNo'], $return[$i]['actionTime'], $time);
				
				$return[$i]['actionTime']=strtotime($return[$i]['actionTime']);
			}
		}
		
		if(count($return)<$num){
			$sql="select actionNo, actionTime from {$this->prename}data_time where type=$type order by actionTime limit " . ($num-count($return));
			$return1=$this->getRows($sql);

			if(($fun=$types[$type]['onGetNoed']) && method_exists($this, $fun)){
				if($return1) foreach($return1 as $i=>$var){
					$this->$fun($return1[$i]['actionNo'], $return1[$i]['actionTime'], $time+24*3600);
					
					$return1[$i]['actionTime']=strtotime($return1[$i]['actionTime']);
				}
			}
			$return=array_merge($return, $return1);
		}
		
		return $return;
	}
	
	private function setTimeNo(&$actionTime, &$time=null){
		$actionTime=wjStrFilter($actionTime);
		//if(preg_match('/^\d{4}/', $actionTime)) return;
		if(!$time) $time=$this->time;
		$actionTime=date('Y-m-d ', $time).$actionTime;
	}
	
	public function noHdCQSSC(&$actionNo, &$actionTime, $time=null){
		$actionNo=wjStrFilter($actionNo);
		$this->setTimeNo($actionTime, $time);
		if($actionNo==0||$actionNo==120){
			$actionNo=date('Ymd120', $time - 24*3600);
			$actionTime=date('Y-m-d 00:00', $time);
			//echo $actionTime;
		}else{
			$actionNo=date('Ymd', $time).substr(1000+$actionNo,1);
		}
		//var_dump($actionNo);exit;
	}
	
	public function onHdXjSsc(&$actionNo, &$actionTime, $time=null){
		$this->setTimeNo($actionTime, $time);
		if($actionNo>=84){
			$actionNo=date('Ymd-'.$actionNo, $time - 24*3600);
		}else{
			$actionNo=date('Ymd-', $time).substr(1000+$actionNo,1);
		}
	}
	
	public function noHd(&$actionNo, &$actionTime, $time=null){
		//echo $actionNo;
		$this->setTimeNo($actionTime, $time);
		$actionNo=date('Ymd', $time).substr(100+$actionNo,1);
	}
	
	public function noxHd(&$actionNo, &$actionTime, $time=null){
		$this->setTimeNo($actionTime, $time);
		/*if($actionNo>180){
			$time-=24*3600;
		}*/
		$timea=intval(date('Hi',time()));
		if($timea>=0 && $timea <= 404){
			$time-=24*3600;
			$actionNo=date('Ymd', $time).substr(1000+$actionNo,1);
		}else{
			$actionNo=date('Ymd', $time).substr(1000+$actionNo,1);
		}
	}
	public function noxHdgd11x5(&$actionNo, &$actionTime, $time=null){
		$this->setTimeNo($actionTime, $time);
		if($actionNo>84){
			$time-=24*3600;
		}
		
		$actionNo=date('ymd', $time).substr(100+$actionNo,1);
	}

	public function noxHdgdklsf(&$actionNo, &$actionTime, $time = null)
    {
        $this->setTimeNo($actionTime, $time);
        if ($actionNo > 84) {
            $time -= 24 * 3600;
        }
        $actionNo = date('Ymd', $time) . substr(100 + $actionNo, 1);
    }

	public function noxHdk3(&$actionNo, &$actionTime, $time=null){
		$this->setTimeNo($actionTime, $time);
		$actionNo=date('ymd', $time).substr(1000+$actionNo,1);
	}
	public function no0Hdnc(&$actionNo, &$actionTime, $time=null){
		$this->setTimeNo($actionTime, $time);
		$actionNo=date('ymd', $time).substr(1000+$actionNo,1);
	}
	public function no0Hdjc(&$actionNo, &$actionTime, $time=null){
		$this->setTimeNo($actionTime, $time);
		$actionNo=date('Ymd', $time).substr(1000+$actionNo,1);
	}
/**
     * 新增 1.5 赛车
     */
	public function sy_JS_pk10(&$actionNo, &$actionTime, $time=null){
        $this->setTimeNo($actionTime, $time);
		$actionNo = 960*(strtotime(date('Y-m-d', $time))-strtotime('2004-09-19'))/3600/24+$actionNo+24902865+890919;
    }
    /**
     * 新增 1.5 时时彩
     */
    public function sy_JS_ssc(&$actionNo, &$actionTime, $time=null){
        
   $this->setTimeNo($actionTime, $time);
		$actionNo = 960*(strtotime(date('Y-m-d', $time))-strtotime('2004-09-19'))/3600/24+$actionNo+24902865+875871;

    }
	
	/**
     * 新增 澳洲5
     */
    public function sy_JS_ao5(&$actionNo, &$actionTime, $time=null){
        $this->setTimeNo($actionTime, $time);
        $actionNo=date('Ymd', $time).str_pad($actionNo,3,"0",STR_PAD_LEFT);

    }

    /**
     * 新增 5 六合彩
     */
    public function sy_JS_lhc(&$actionNo, &$actionTime, $time=null){
        $this->setTimeNo($actionTime, $time);
        $actionNo=date('Ymd', $time).str_pad($actionNo,3,"0",STR_PAD_LEFT);
    }
	/**
	* 六合彩
	*/
	/**
	* 六合彩
	*/
	
	public function no6Hd(&$actionNo,&$actionTime,$time=null){	
		$actionNo=null;
		$actionTime=null;
		if($time===null) $time=$this->time;
		$atime=date('Y-m-d 00:00:00', $time);
		$sql="select actionNo, lhcTime from {$this->prename}data_time where type=70 and lhcTime>'{$atime}' order by id asc";
		$data = $this->getRow($sql, $atime);
		$actionNo=$data['actionNo'];
		$actionTime=$data['lhcTime'];
    }

	public function no0Hdk3(&$actionNo, &$actionTime, $time=null){
		$this->setTimeNo($actionTime, $time);
		$actionNo=date('md', $time).substr(100+$actionNo,1);
	}

	public function no0Hdf(&$actionNo, &$actionTime, $time=null){
		$this->setTimeNo($actionTime, $time);
		$actionNo=date('Ymd-', $time).substr(10000+$actionNo,1);
	}
	
	public function pai3(&$actionNo, &$actionTime, $time=null){
		$this->setTimeNo($actionTime, $time);
		//echo $actionTime,' ',date('Y-m-d H:i:s', $time);
		$actionNo=date('Yz', $time)-6;
		$actionNo=substr($actionNo,0,4).substr(substr($actionNo,4)+1000,1);
		if($actionTime >= date('Y-m-d H:i:s', $time)){
			
		}else{
			$actionTime=date('Y-m-d 18:30', $time);
		}
	}
	
	public function GXklsf(&$actionNo, &$actionTime, $time=null){
		$this->setTimeNo($actionTime, $time);
		$actionNo=date('Yz', $time).substr(100+$actionNo,1)+100;
		$actionNo=substr($actionNo,0,4).substr(substr($actionNo,4)+100000,1);
	}
	
	public function BJpk10(&$actionNo, &$actionTime, $time=null){
		$this->setTimeNo($actionTime, $time);
		$actionNo = 179*(strtotime(date('Y-m-d', $time))-strtotime('2007-11-18'))/3600/24+$actionNo-1267-1273-1253;
	}
	public function Kuai8(&$actionNo, &$actionTime, $time=null){
		$this->setTimeNo($actionTime, $time);
		$actionNo = 179*(strtotime(date('Y-m-d', $time))-strtotime('2004-09-19'))/3600/24+$actionNo-1292*2-1274-702;
	}

	public function updateSessionTime(){
		$sql="update ssc_member_session set accessTime={$this->time} where id={$this->user['sessionId']}";
		$this->update($sql, $this->user['sessionId'], $this->user['sessionId']);
	}

	public function checkLogin(){
		if($user=unserialize($this->session->userdata($this->memberSessionName))) return $user;
		redirect(site_url('/landing'));
		exit('您没有登录');
	}

	private function setClientMessage($message, $type='Info', $showTime=3000){
		$message=trim(rawurlencode($message), '"');
		header("X-$type-Message: $message");
		header("X-$type-Message-Times: $showTime");
	}
	
	protected function info($message, $showTime=3000){
		$this->setClientMessage($message, 'Info', $showTime);
	}
	protected function success($message, $showTime=3000){
		$this->setClientMessage($message, 'Success', $showTime);
	}
	protected function warning($message, $showTime=3000){
		$this->setClientMessage($message, 'Warning', $showTime);
	}
	public function error($message, $showTime=5000){
		$this->setClientMessage($message, 'Error', $showTime);
		exit;
	}
	//获取延迟时间
	public function getTypeFtime($type){
		
		if($type){
			$Ftime=$this->getValue("select data_ftime from {$this->prename}type where id = {$type} ", $type);
		}
		if(!$Ftime) $Ftime=0;
		return intval($Ftime);
	}
	//获取该玩法最高投注金额
	public function getmaxcount($playedid){
		if($playedid){
				$maxcount=$this->getRow("select minMoney, maxMoney, maxTurnMoney from {$this->prename}played where id = {$playedid} ", $playedid);
			}
			return $maxcount;
	 }

	 public function getmaxcount2($playedid){
		if($playedid){
				$maxcount2=$this->getRow("select minMoney, maxMoney, maxTurnMoney from {$this->prename}played2 where id = {$playedid} ", $playedid);
			}
			return $maxcount2;
	 }
	 
	//获取当期时间
	public function getGameActionTime($type,$old=0){
		$actionNo=$this->getGameNo($type);
		
		if($type==1 && $actionNo['actionTime']=='00:00'){
			$actionTime=strtotime($actionNo['actionTime'])+24*3600;
		}else{
			$actionTime=strtotime($actionNo['actionTime']);
		}
		if(!$actionTime) $actionTime=$old;
		return $actionTime;
	}
	
	//获取当期期数
	public function getGameActionNo($type){
		$actionNo=$this->getGameNo($type);
		return $actionNo['actionNo'];
	}
	
	//随机函数
	public function randomkeys($length)
	{
	 $key = "";
	 $pattern='ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	 $pattern1='ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	 $pattern2='0123456789';
	 for($i=0;$i<$length;$i++)
	 {
	   $key .= $pattern{mt_rand(0,35)};
	 }

	 return $key;
	}

	function createRandomStr($length){ 
	$str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';//62个字符 
	$strlen = 62; 
	while($length > $strlen){ 
	$str .= $str; 
	$strlen += 62; 
	} 
	$str = str_shuffle($str); 
	return substr($str,0,$length); 
	} 
	//输出单号
	function formatwords($str){
		
	if($str){
		$len=strlen($str);  
		for($i=0;$i<$len;$i++){
			echo "<i>".substr($str, $i, 1)."</i>";
			
		}
	 }
	}

    
}