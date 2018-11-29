<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends WebBase_Controller {

	public function __construct()
    {
        parent::__construct();
    }
	
	public final function initdo(){
		$this->freshSession();
		$checklogin=array();
		
		$checklogin['token']= $this->user['token'];

		$checklogin['serverTime']=date('Y-m-d H:i:s',time());
		$checklogin['userId']=intval($this->user['uid']);
		$checklogin['username']=$this->user['username'];
		$checklogin['nickname']=$this->user['nickname'];
		$checklogin['fullName']=$this->user['name'];
		$checklogin['loginTime']=$this->user['updateTime'];
		$checklogin['lastLoginTime']=$this->user['updateTime'];
		$checklogin['money']=floatval($this->user['coin']);
		$checklogin['email']=$this->user['email'];
		if($this->user['coinPassword']){
		$checklogin['hasFundPwd']=true;
		}else{
		$checklogin['hasFundPwd']=false;	
		}
		//$checklogin['loginDomain']=$_SERVER['HTTP_HOST']; 
		//$checklogin['ext']=null;
		//$checklogin['menu']=null;
		//$checklogin['filter']=null;
		$checklogin['testFlag']=intval($this->user['testFlag']);  //测试用户为1
		$checklogin['updatePw']=intval($this->user['updatePw']); //为1需要修改密码
		$checklogin['updatePayPw']=0;
		$checklogin['enable']=intval($this->user['enable']); //为0账号被封停
		$checklogin['updateTime'] = $this->user['updateTime'];
		echo json_encode($checklogin);

		//{"token":"","serverTime":"2016-12-14 16:33:05","userId":67473,"userName":"","fullName":"","loginTime":"2016-12-14 16:30:36","lastLoginTime":"2016-12-14 16:30:36","money":0.0,"email":"123456@qq.com","hasFundPwd":true,"testFlag":0,"updatePw":0,"updatePayPw":0}

	}
	public final function getServerDatado(){
		$this->display('Api/getServerData.php');
	}

	public final function logoutdo(){
		redirect(site_url('/user/logout'));
	}
	/**
	 * 用户登录检查 DAVID 
	 */
	public final function guestlogindo(){
		if($this->user['uid']){
			echo '您已登陆';
			exit;
		}
	    $username=wjStrFilter($_POST['username']);
        $password=wjStrFilter($_POST['password']);
		if($username==$password && $username=='!guest!'){
			$password=md5($password);
		}else{
			echo '登陆错误';
			exit;
		}
		$username='guest_'.$this->time;
		$para=array(
		'username'=>$username,
		'nickname'=>$username,
		'name'=>$username,
		'password'=>$password,
		'regTime'=>$this->time,
		'updateTime'=>date('Y-m-d H:i:s',$this->time),
		'regIP'=>self::ip(true),
		'coin'=>2000,
		'testFlag'=>1,
		);
		if($this->insertRow($this->prename .'guestmembers', $para)){
			$id=$this->lastInsertId();
			//return '登陆成功';
		}else{
			echo '登陆失败';
			exit;
		}	
		$sql="select * from {$this->prename}guestmembers where isDelete=0 and admin=0 and username=? limit 0,1";
		if(!$user=$this->getRow($sql, $username)){
			echo '登陆失败';
			exit;
		}
		
		$updatetime=date('Y-m-d H:i:s', $this->time);
		$token = base64_encode(crypt(session_id(), $username).md5($updatetime));
		$session=array(
			'uid'=>$user['uid'],
			'username'=>$user['username'],
			'session_key'=>session_id(),
			'loginTime'=>$this->time,
			'accessTime'=>$this->time,
			'loginIP'=>self::ip(true),
			'token'=>$token
		);
		
		$session=array_merge($session, $this->getBrowser());
		
		if($this->insertRow($this->prename.'member_session', $session)){
			$user['sessionId']=$this->lastInsertId();
		}
		$user['session_key'] = $session['session_key'];
		$user['token'] = $token;
		
		$this->session->set_userdata($this->memberSessionName, serialize($user));
		
		echo 'ok';
	}
}

?>