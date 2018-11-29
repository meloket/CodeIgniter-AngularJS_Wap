<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends WebBase_Controller {

	public $title = 'BOECP';
	private $vcodeSessionName = 'ssc_vcode_session_name';

	public function __construct()
    {
        parent::__construct();
    }

    /**
	 * 用户登录页面
	 */
	public final function login(){
		$this->load->view('layout/common');
		$this->load->view('layout/navbar/navbar2');
		$this->load->view('user/login');
		$this->load->view('layout/footer');
	}

	public final function index()
	{
		redirect(site_url('/home'));
	}

	/**
	 * 用户登出操作
	 */
	public final function logout(){

		$this->unset_all_session();
		if($this->user['uid']){
			$this->update("update {$this->prename}member_session set isOnLine=0 where uid={$this->user['uid']} and session_key='".$this->user['session_key']."'", $this->user['session_key']);
		}
		redirect(site_url('/landing'));
		exit;
	}

	public final function logout_ionic(){
		$this->unset_all_session();
		if($this->user['uid']){
			$this->update("update {$this->prename}member_session set isOnLine=0 where uid={$this->user['uid']} and session_key='".$this->user['session_key']."'", $this->user['session_key']);
		}
		echo json_encode("logouted!");
		exit;
	}

	/**
	 * 用户登录检查 DAVID 
	 */
	public final function loginedto(){

	    $username = wjStrFilter($this->input->post('txt_login_user'));
        $password = wjStrFilter($this->input->post('txt_login_password'));
        $vcode = wjStrFilter($this->input->post('vcode'));

		if(!ctype_alnum($username)) { 
			$res['msg'] = '用户名包含非法字符,请重新登陆';
        	echo json_encode($res); return;
        }
		
		if(!$username){
			$res['msg'] = '请输入用户名';
        	echo json_encode($res); return;
		}
		if(!$password){
			$res['msg'] = '不允许空密码登录';
        	echo json_encode($res); return;
		}

		$sql="select * from {$this->prename}members where isDelete=0 and admin=0 and username='{$username}' limit 0,1";
		if(!$user=$this->getRow($sql, $username)){
			$res['msg'] = '用户名或密码不正确';
        	echo json_encode($res); return;
		}
		if(md5($password)!=$user['password']){
			$res['msg'] = '密码不正确';
        	echo json_encode($res); return;
		}
		if(!$user['enable']){
			$res['msg'] = '您的帐号系统检测涉嫌违规操作已被暂时冻结，如有疑问请联系在线客服！';
        	echo json_encode($res); return;
		}

		if($this->getRows("select * from ssc_member_session A where A.isOnLine=1 and A.uid={$user['uid']} and A.id >= (select max(id) from ssc_member_session B where B.uid={$user['uid']}) "))
		{
			$res['msg'] = '已经登录了!';
        	echo json_encode($res); return;
		}

		$data = $this->reset_session($user);

		$res['msg'] = 'success';
		$res['data'] = $data;

		echo json_encode($res);
		return;
	}


	public final function loginedtowithqr(){

	    $username = wjStrFilter($this->input->post('txt_login_user'));

		if(!ctype_alnum($username)) { 
			$res['msg'] = '用户名包含非法字符,请重新登陆';
        	echo json_encode($res); return;
        }
		
		if(!$username){
			$res['msg'] = '请输入用户名';
        	echo json_encode($res); return;
		}

		$sql="select * from {$this->prename}members where isDelete=0 and admin=0 and username='{$username}' limit 0,1";
		if(!$user=$this->getRow($sql, $username)){
			$res['msg'] = '用户名或密码不正确';
        	echo json_encode($res); return;
		}
		
		if(!$user['enable']){
			$res['msg'] = '您的帐号系统检测涉嫌违规操作已被暂时冻结，如有疑问请联系在线客服！';
        	echo json_encode($res); return;
		}

		// if($this->getRows("select * from ssc_member_session A where A.isOnLine=1 and A.uid={$user['uid']} and A.id >= (select max(id) from ssc_member_session B where B.uid={$user['uid']}) "))
		// {
		// 	$res['msg'] = '已经登录了!';
        // 	echo json_encode($res); return;
		// }

		$data = $this->reset_session($user);

		$res['msg'] = 'success';
		$res['data'] = $data;

		echo json_encode($res);
		return;
	}

	/**
	 * 用户注册页面
	 */
	public final function regist(){
		$uid=intval(isset($_GET['uid']) ? $_GET['uid'] : 0);
		$view_data['daliusername'] = $this->getValue("select username from {$this->prename}members where uid={$uid}");

		$this->load->view('layout/common');
		$this->load->view('layout/navbar/navbar2');
		$this->load->view('user/regist', $view_data);
		$this->load->view('layout/footer');
	}

	public final function registered(){
		if ($this->input->server('REQUEST_METHOD') != 'POST'){
			echo json_encode('提交数据出错，请重新操作');
			return;
		}

		//表单过滤
		$lid=intval($this->input->post('lid'));
		$parentId=intval($this->input->post('parentId'));
		$user=wjStrFilter($this->input->post('txt_regist_user'));
		$qq=wjStrFilter($this->input->post('qq'));
		$daliuser=$this->input->post('daliuser');
		$vcode=wjStrFilter($this->input->post('vcode'));
		$password=md5($this->input->post('txt_regist_password'));

		if($vcode!=$this->session->userdata($this->vcodeSessionName)) {
			echo json_encode('验证码不正确。');
			return;
		}

		//清空验证码session
		$this->session->set_userdata($this->vcodeSessionName, "");

		if(!ctype_alnum($user)){ echo json_encode('用户名包含非法字符'); return; }
		if(strlen($this->input->post('txt_regist_password'))<6){ echo json_encode('密码不能小于6位'); return; }
		if(strlen($this->input->post('txt_regist_password'))>20){ echo json_encode('密码不能大于20位'); return; }
		if(!ctype_digit($qq)){ echo json_encode('QQ包含非法字符'); return; }
		if($daliuser){
			//$sql2="select * from {$this->prename}members where type>=1 and username=?";
			$sql2="select * from {$this->prename}members where username='{$daliuser}'";
			$parentinfo=$this->getRow($sql2, $daliuser);
			if(!$parentinfo) { echo json_encode('您输入的推荐人不存在。'); return; }
			$dali=10;
		}	
		if($lid && $parentId){
			$sql="select * from {$this->prename}links where lid={$lid}";
			$linkData=$this->getRow($sql, $lid);
			if(!$_POST['lid']) $para['lid']=$lid;
			if(!$linkData){ echo json_encode('不存在此注册链接。'); return; }
			if(!$parentId){ echo json_encode('链接错误'); return; }
			$parentinfo=$this->getRow("select * from {$this->prename}members where uid={$parentId}", $parentId);
			if($linkData['type'] >= $parentinfo['type']){ echo json_encode('链接错误'); return; }
		}
		else{
			$linkData['type']=0;
			$linkData['fanDian']=0;
		}
		$para=array(
			'username'=>$user,
			'type'=>$linkData['type'],
			'password'=>$password,
			'fanDian'=>$linkData['fanDian'],
			'coin'=>0,
			'qq'=>$qq,
			'regIP'=>$this->ip(true),
			'regTime'=>$this->time
			);
			
		if ((isset($dali) ? $dali : NULL) == 10){
			//推荐人
			$para['parentId']=$parentinfo['uid'];
			if ($parentinfo['zparentId']) {
				$para['zparentId']=$parentinfo['zparentId'];
			}else {
			    $para['zparentId']=$parentinfo['parentId'];
			}
			$para['gudongId']=$parentinfo['parentId'];
		}elseif($linkData['type']==0 && (isset($parentinfo['type']) ? $parentinfo['type'] : NULL) == 1){
			//添加会员
			$para['parentId']=$parentId;
			$para['zparentId']=$parentinfo['zparentId'];
			$para['gudongId']=$parentinfo['gudongId'];
		}elseif((isset($parentinfo['type']) ? $parentinfo['type'] : NULL) == 2){
			$para['zparentId']=$parentId;
			$para['gudongId']=$parentinfo['gudongId'];
		}elseif((isset($parentinfo['type']) ? $parentinfo['type'] : NULL) == 3){
			$para['gudongId']=$parentId;
		}
		$lasttime=$this->time-24*3600;
		$iip = ip2long($this->ip(true));
        $regcount=$this->getValue("select count(*) from {$this->prename}members where regIP='{$iip}' and regTime>{$lasttime}", ip2long($this->ip(true)));
		//if($regcount>=3){ echo json_encode('同一IP 24小时内只能注册三次'); return; }

		if(!(isset($para['nickname']) ? $para['nickname'] : NULL)) $para['nickname']='未设昵称';
		if(!(isset($para['name']) ? $para['name'] : NULL)) $para['name']='';
		if(!(isset($para['email']) ? $para['email'] : NULL)) $para['email']='';
		if(!(isset($para['phone']) ? $para['phone'] : NULL)) $para['phone']='';
		if(!(isset($para['conCommStatus']) ? $para['conCommStatus'] : NULL)) $para['conCommStatus']=0;
		if(!(isset($para['lossCommStatus']) ? $para['lossCommStatus'] : NULL)) $para['lossCommStatus']=0;
		if(!(isset($para['care']) ? $para['care'] : NULL)) $para['care']='';
		$this->beginTransaction();
		try{
			$sql="select username from {$this->prename}members where username='{$para['username']}'";
			if($this->getValue($sql, $para['username'])){ 
				echo json_encode('用户"'.$para['username'].'"已经存在'); return; 
			}
			if($id=$this->insertRow($this->prename .'members', $para)){
				$this->commit();
				$sql="select * from {$this->prename}members where uid={$id} limit 0,1";
				$newuser=$this->getRow($sql, $id);
				$this->reset_session($newuser);

				echo json_encode('success'); return;
			}else{
				echo json_encode('注册失败'); return;
			}	
		}catch(Exception $e){
			$this->rollBack();
			echo json_encode($e);
			return;
		}
	}
	
	public final function setFullNamedo(){
		$para=$_POST;
		$fullName=$para['fullName'];
		if($this->user['uid'] && $fullName){
			if(!$this->getValue("select `name` from {$this->prename}members where uid={$this->user['uid']}", $this->user['uid'])){
				if($this->update("update {$this->prename}members set name='{$fullName}' where uid={$this->user['uid']}", $this->user['uid'])){
						echo 'ok';
						exit;
				}else{
						echo '操作失败';
						exit;
				}
			}else{
						echo '您已添加过真实姓名,如需修改请联系客服';
						exit;
			}
		}
	}
	
	public final function bindBankdo(){
		$para=$_POST;
		$username = isset($para['fullName']) ? $para['fullName'] : NULL;
		$bankId = isset($para['bankId']) ? $para['bankId'] : NULL;
		$cardNo = isset($para['cardNo']) ? $para['cardNo'] : NULL;
		$subAddress = isset($para['subAddress']) ? $para['subAddress'] : NULL;
		if($this->user['uid']){
			
			if($this->getValue("select uid from {$this->prename}member_bank where uid={$this->user['uid']}", $this->user['uid'])){
					echo '您已绑定银行卡,如需修改请联系客服';
					exit;
			}
			
			if(!$username){
				$username=$this->getValue("select `name` from {$this->prename}members where uid={$this->user['uid']}", $this->user['uid']);
			}
			$userbank=array(
				'uid'=>$this->user['uid'],
				'username'=>$username,
				'bankId'=>$bankId,
				'account'=>$cardNo,
				'countname'=>$subAddress
			);
						
			if(!$username || !$bankId || !$cardNo || !$subAddress){
				echo '填写错误';
				exit;
			}
			try{
				if($this->insertRow($this->prename.'member_bank', $userbank)){
					$this->update("update {$this->prename}members set `name`='{$username}' where uid={$this->user['uid']}", $this->user['uid']);
					echo 'ok';
					exit;
				}else{
					echo '绑定失败';
					exit;
				}
		
			}catch(Exception $e){
				$this->rollBack();
				throw $e;
			}

		}
	}

	public final function setFundPwddo(){
		if($this->user['uid']){
			$loginpwd=$_POST['loginpwd'];
			$coinpwd=$_POST['coinpwd'];
			if($loginpwd != $this->user['password']){
				echo '登陆密码输入错误';
				exit;
			}
			if(strlen($coinpwd) != 32){
				echo '提款密码输入错误';
				exit;
			}
			if($loginpwd == $coinpwd){
				echo '登陆密码和提款密码不能相同';
				exit;
			}
			if($this->update("update {$this->prename}members set coinPassword='{$coinpwd}' where uid={$this->user['uid']}", $this->user['uid'])){
				echo 'ok';
				exit;
			}
		}
	}

	public final function bulletin(){
		$this->display('user/bulletin.php');
	}
	
	

	public final function tanchu(){
		echo $this->session->userdata('tanchu');
	}
	public final function tanchugb(){
		$this->session->set_userdata("tanchu", "0");
	}
	/**
	 * 验证码产生器
	 */
	public final function vcode($rmt=null){
		$lib_path=$_SERVER['DOCUMENT_ROOT'].'/lib/';
		include_once $lib_path .'classes/CImage.class';
		$width=130;
		$height=40;
		$img=new CImage($width, $height);
		$img->sessionName=$this->vcodeSessionName;
		$img->printimg('png');
	}
	
	/**
	 * 推广注册
	 */
	public final function r($userxxx){
		if(!$userxxx){
			//throw new Exception('链接错误！');
			$this->display('team/register.php');
		}else{
			include_once $_SERVER['DOCUMENT_ROOT'].'/lib/classes/Xxtea.class';
			$userxxx=str_replace(array('-','*',''), array('+','/','='), $userxxx);
			$userxxx=base64_decode($userxxx);
			$LArry=Xxtea::decrypt($userxxx, $this->urlPasswordKey);
			$LArry=explode(",",$LArry);
			$lid=$LArry[0];
			$uid=$LArry[1];

			if(!$this->getRow("select uid from {$this->prename}members where uid={$this->user['uid']}", $uid)){
				//throw new Exception('链接失效！');
				$this->display('team/register.php');
			}else{
				$this->display('team/register.php',0,$uid,$lid);
			}
		}
	}
	
	
}

?>