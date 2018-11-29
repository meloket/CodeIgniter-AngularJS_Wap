<?php

defined('BASEPATH') or exit('No direct script access allowed');

class WebLoginBase_Controller extends WebBase_Controller
{
	public $type;		// 彩票种类ID
	public $groupId;	// 玩法组ID
	public $played;		// 玩法ID
	public $NO;			// 期号
	
	public $actionTemplate;

    public function __construct()
    {
        parent::__construct();

        if(!$this->session->userdata($this->memberSessionName)) {
        	redirect(site_url('/user/logout'));
			exit('您没有登录');
		}

		try{
			if(!$this->getValue("select isOnLine from ssc_member_session where uid={$this->user['uid']} and session_key='".$this->user['session_key']."' order by id desc limit 1", $this->user['session_key'])){
				$this->session->unset_userdata($this->memberSessionName);
				redirect(site_url('/user/logout'));
				exit('您已经退出登录，请重新登录');
			}
		}catch(Exception $e){
			log_message('error', '[Class->WebLoginBase_Controller, Method->construct] : '.$e->getMessage() );
		}
    }

	/* aaron-nnn */
	/*public function getSystemSettings($expire=null){
		if($expire===null) $expire=$this->expire;
		$file=$this->cacheDir . 'systemSettings';
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
	}*/
	
/*	public function delete_file($str){
		$dir=$this->cacheDir;
		$list = scandir($dir); // 得到该文件下的所有文件和文件夹
		foreach($list as $file){//遍历
			$file_location=$dir."/".$file;//生成路径
			if(is_dir($file_location) && $file!="." &&$file!=".."){ //判断是不是文件夹
				//echo "------------------------sign in $file_location------------------";
				//delete_file($file_location); //继续遍历
			}else if($file!="."&&$file!=".."){
				if(substr_count($file,$str)>0){//如果文件名包含该字符串
					unlink($dir."/".$file);
				}
			}
		}
	}
	public function setcachefile($cacheFile, $getvalue){		
		$file=$this->cacheDir. '/'.md5($getvalue.$cacheFile);
		$actionTime=$this->getGameCachetime($getvalue);
		$cachefiletime=strtotime($actionTime);
		$file=$file.'_'.$cachefiletime;				
		if(is_file($file)) {  
		echo file_get_contents($file);
		}else{    	
		//删除过期缓存
		$this->delete_file(md5($getvalue.$cacheFile));	 
		//将结果集缓存
		ob_start();
		$this->display($cacheFile);
		file_put_contents($file,ob_get_contents()); 
		ob_end_flush();
		
		}  
	}*/

	/**
	 * 用户资金变动
	 *
	 * 请在一个事务里使用
	 */
	public function addCoin($log){
		if(!isset($log['uid'])) $log['uid']=$this->user['uid'];
		if(!isset($log['info'])) $log['info']='';
		if(!isset($log['coin'])) $log['coin']=0;
		if(!isset($log['type'])) $log['type']=0;
		if(!isset($log['fcoin'])) $log['fcoin']=0;
		if(!isset($log['extfield0'])) $log['extfield0']=0;
		if(!isset($log['extfield1'])) $log['extfield1']='';
		if(!isset($log['extfield2'])) $log['extfield2']='';
		
		$sql="call setCoin({$log['coin']}, {$log['fcoin']}, {$log['uid']}, {$log['liqType']}, {$log['type']}, '{$log['info']}', {$log['extfield0']}, '{$log['extfield1']}', '{$log['extfield2']}')";
		
		//echo $sql;exit;
		$this->insert($sql);
	}
	
	public function guestaddCoin($log){
		if(!isset($log['uid'])) $log['uid']=$this->user['uid'];
		if(!isset($log['info'])) $log['info']='';
		if(!isset($log['coin'])) $log['coin']=0;
		if(!isset($log['type'])) $log['type']=0;
		if(!isset($log['fcoin'])) $log['fcoin']=0;
		if(!isset($log['extfield0'])) $log['extfield0']=0;
		if(!isset($log['extfield1'])) $log['extfield1']='';
		if(!isset($log['extfield2'])) $log['extfield2']='';
		
		$sql="call guestsetCoin({$log['coin']}, {$log['fcoin']}, {$log['uid']}, {$log['liqType']}, {$log['type']}, '{$log['info']}', {$log['extfield0']}, '{$log['extfield1']}', '{$log['extfield2']}')";
		
		//echo $sql;exit;
		$this->insert($sql);
	}	
	/**
	 * 读取可用返点
	 */
	public function getFanDian($uid=null){
		if($uid===null){
			if(!$uid=$this->user['parentId']){
				return $this->params['basePl'];
			}
		}
		return $this->getValue("select fanDian from {$this->prename}members where parentId=?", intval($uid));
	}

    
}