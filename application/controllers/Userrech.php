<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Userrech extends WebLoginBase_Controller {

	public function __construct()
    {
        parent::__construct();
    }

    public final function getUserRechCfgdo(){

		$list=$this->getRows("select account as payee, payeeName, address, qrCode, onlineType, domain, name as rechName, id, rechType from {$this->prename}sysadmin_bank where enable=1");
		echo json_encode($list);
		/*[{"payee":"","payeeName":"在线支付","address":"","qrCode":null,"onlineType":4,"domain":null,"rechName":"在线支付","id":56,"rechType":"onlinePayment"},{"payee":"123456@163.com","payeeName":"有限公司","address":"转账成功在提交入款订单","qrCode":"/images/148067647052.png","onlineType":null,"domain":null,"rechName":"支付宝支付","id":62,"rechType":"alipay"},{"payee":"","payeeName":"闪付1","address":"","qrCode":null,"onlineType":2,"domain":null,"rechName":"在线支付","id":40,"rechType":"onlinePayment"}]*/
	}
	
	public final function getRechListdo(){
		$pagenum=intval($_GET['page']);
		$pagesize=intval($_GET['rows']);
		$startDate = isset($_GET['startDate']) ? $_GET['startDate'] : NULL;
		$endDate = isset($_GET['endDate']) ? $_GET['endDate'] : NULL;
		$state = intval(isset($_GET['status']) ? $_GET['status'] : NULL);

		
		$sql = "";
		if($startDate){
			$startDate=strtotime($_GET['startDate']);
			$sql=" and actionTime >={$startDate} ";
		}
		if($endDate){
			$endDate=strtotime($endDate.' 23:59:59');
			$sql.=" and actionTime <= {$endDate} ";
		}
		//充值订单状态：0申请，1手动到账,2自动到账,3充值失败,9管理员充值
		if($state == 0 && !is_null(isset($_GET['status']) ? $_GET['status'] : NULL)){
			$sql.=" and state=0 ";
		}elseif($state==1){
			$sql.=" and state in(1,2,9) ";
		}elseif($state==3){
			$sql.=" and state=3 ";
		}
		$sql=$sql.' order by id desc';
		$list=$this->getPage("select * from {$this->prename}member_recharge where isDelete=0 and amount>0 and uid={$this->user['uid']} {$sql}",$pagenum,$pagesize);
		$allarr=array();
		$allarr['data']=array();
		$allarr['totalCount']=0;
		$allarr['otherData']=null;
		if($list){
			$listarr=array();
			foreach($list['data'] as $var){
					$listarr['id']=intval($var['id']);
					$listarr['userId']=intval($var['uid']);
					$listarr['userName']=$var['username'];
					/*$listarr['dlId']=null; //代理
					$listarr['zdlId']=null;//总代理*/
					$listarr['accountMoney']=0;
					$listarr['rechMoney']=floatval($var['amount']);
					$listarr['orderNo']=$this->ifs($var['rechargeId'], '管理员充值');
					$listarr['addTime']=date("Y-m-d H:i:s",$var['actionTime']);
					$listarr['status']=$var['state'];
					$listarr['rechTime']=date("Y-m-d H:i:s",$var['actionTime']);
					$listarr['remark']=$var['info'];
					$listarr['rechName']=$var['info'];
					if($var['rechType']){
						$listarr['rechType']=$var['rechType'];
					}elseif($var['info']=='系统充值'){
						$listarr['rechType']='adminAddMoney';
					}else{
						$listarr['rechType']='onlinePayment';
					}
					array_push($allarr['data'], $listarr);
			}
			$allarr['totalCount']=$list['total'];
		}
		echo json_encode($allarr);

		/*{"data":[{"id":288658,"userId":67473,"account":"","userName":"","dlId":3,"dlName":"dl01","accountMoney":0.0,"rechMoney":20.0,"orderNo":"10161220222206972992","addTime":"2016-12-20 22:22:07","status":2,"rechTime":"2016-12-20 22:22:07","remark":"通过闪付充值20.0元","channel":55,"operator":null,"operatorTime":null,"rechType":"onlinePayment","rechName":"在线支付","payeeName":null,"payee":"610208","payeeInfo":null,"payeeBankName":null,"actualMoney":20.0,"updateTime":"2016-12-20 22:24:34","thirdOrderNo":null,"rechLevel":"0","rebateMoney":0.0,"thirdChannel":"57","statDate":"2016-12-20 22:24:34","onlineType":7}],"totalCount":2,"otherData":null}*/
	}
	
	public final function getRechDetaildo(){
		$this->display('Userrech/getRechDetail.php');
	}

	public final function detaildo(){
		$this->freshSession();
		$toTime=strtotime('00:00:00');
		$list=$this->getRow("select * from {$this->prename}members where uid={$this->user['uid']}");
		if($list){
			$bank=$this->getRow("select * from {$this->prename}member_bank where uid={$this->user['uid']}",$this->user['uid']);
			$data=array();
			$data['userId']=$this->user['uid'];
			$data['fullName']=$bank['countname'];
			$data['money']=$list['coin'];
			$data['panid']=$list['panid'];
			$data['superName']=$list['nickname'];
			$data['rebate']=$list['rebate'];
			$data['loginTime']=$list['updateTime'];
			$data['updateTime']=$list['updateTime'];
			$data['fundPwd']=null;
			$data['userType']=$list['type'];
			$data['enable']=$list['enable'];
			$data['regIp']=$list['regIP'];
			$data['userName']=$list['username'];
			$data['phone']=$list['phone'];
			$data['email']=$list['email'];
			if($list['coinPassword']){
				$data['isSetFundPwd']=1;
				$data['oldPaypasswd']=1;
			}

			if($bank['account']){
				$data['bankName']=$this->getValue("select name from {$this->prename}bank_list where id={$bank['bankId']}", $bank['bankId']);
				$data['cardNo']=$bank['account'];	
			}
			echo json_encode($data);
		}
	}
	
	public final function getStatBetsdo(){
		$pagenum = intval(isset($_GET['page']) ? $_GET['page'] : NULL);
		$pagesize = intval(isset($_GET['rows']) ? $_GET['rows'] : NULL);
		$elemet = isset($_GET['elemet']) ? $_GET['elemet'] : NULL;
		$settled = isset($_GET['settled']) ? $_GET['settled'] : NULL;
		$startDate=$_GET['startDate'];
		$endDate=$_GET['endDate'];
		if(!$pagenum){$pagenum=1;}
		if(!$pagesize){$pagesize=7;}
		if($startDate && $endDate){
			$startDate=date("Y-m-d",strtotime($startDate));
			$endDate=date("Y-m-d",strtotime($endDate));
			$sql=" and date >='{$startDate}' and date <= '{$endDate}' ";
		}
		/*$datestr=time()-24*3600;
		if($endDate>$datestr){
			exit;
		}*/
		$sql=$sql.' order by id desc';
		$list=$this->getPage("select * from {$this->prename}report where uid={$this->user['uid']} {$sql}",$pagenum,$pagesize);

		$allarr=array();
		$allarr['data']=array();
		$allarr['totalCount']=0;
		$allarr['otherData']=null;

		$dataarr=array();
		$dataarr['id']=null;
		$dataarr['gameId']=null;
		$dataarr['userId']=null;
		$dataarr['userName']=null;
		$dataarr['statDate']=null;
		$dataarr['betCount']=null;
		$dataarr['betMoney']=null;
		$dataarr['reward']=null;
		$dataarr['rewardRebate']=null;
		$dataarr['rebateMoney']=null;
		$dataarr['rewardDouble']=null;
		$dataarr['rebateMoneyDouble']=null;
		$dataarr['rewardRebateDouble']=null;
		$dataarr['betMoneyDouble']=null;
		if($list['data']){
			$allarr['data']=array();
			foreach($list['data'] as $key => $var){ 
				$dataarr=array();
				$dataarr['id']=null;
				$dataarr['gameId']=null;
				$dataarr['userId']=intval($var['uid']);
				$dataarr['userName']=$var['username'];
				$dataarr['statDate']=$var['date'];
				$dataarr['betCount']=intval($var['betCount']);
				//$dataarr['betMoney']=floatval($var['betAmount']);
				$dataarr['reward']=floatval($var['zjAmount']);
				$dataarr['rewardRebate']=floatval($var['zjAmount'] + $var['rebateMoney'] - $var['betAmount']);
				/*$dataarr['rebateMoney']=floatval($var['rebateMoney']);
				$dataarr['rewardDouble']=floatval($var['zjAmount'] + $var['rebateMoney'] - $var['betAmount']);*/
				$dataarr['rebateMoneyDouble']=floatval($var['rebateMoney']);
				$dataarr['rewardRebateDouble']=floatval($var['zjAmount'] + $var['rebateMoney'] - $var['betAmount']);
				$dataarr['betMoneyDouble']=floatval($var['betAmount']);

				array_push($allarr['data'],$dataarr);

			}
			$allarr['totalCount']=$list['total'];
		}
		echo json_encode($allarr);

		/*{"data":[{"id":null,"gameId":null,"userId":67473,"dlId":null,"dlName":null,"zdlId":null,"zdlName":null,"userName":"","statDate":"2016-12-20 星期二","betCount":10,"betMoney":16.0,"reward":-2.47,"rewardRebate":-2.39,"rebateMoney":0.08,"userCount":null,"fullName":null,"rewardDouble":-2.47,"rebateMoneyDouble":0.08,"rewardRebateDouble":-2.39,"betMoneyDouble":16.0}],"totalCount":1,"otherData":null}*/

	}

	public final function getTotalStatBetsdo(){
		$elemet=$_GET['elemet'];
		$settled=$_GET['settled'];
		$Date=date("Y-m-d",strtotime($_POST['date']));
		/*$datestr=time()-24*3600;
		if($endDate>$datestr){
			exit;
		}*/
		$sql=" and date = '{$Date}' ";
		$sql=$sql.' order by type asc';
		$list=$this->getRows("select * from {$this->prename}count where uid={$this->user['uid']} {$sql}");
		$idkey=array();
		$datanewarr=array();
		$data=array();
		$data['id']=null;
		$data['gameId']=null;
		$data['userId']=null;
		$data['userName']=null;
		$data['statDate']=null;
		$data['betCount']=null;
		$data['betMoney']=null;
		$data['reward']=null;
		$data['rewardRebate']=null;
		$data['rebateMoney']=null;
		$data['rewardDouble']=null;
		$data['rebateMoneyDouble']=null;
		$data['rewardRebateDouble']=null;
		$data['betMoneyDouble']=null;
		if($list){
			foreach($list as $var){ 
				$data['id']=null;
				$data['gameId']=intval($var['type']);
				$data['userId']=intval($var['uid']);
				$data['userName']=$var['username'];
				$data['statDate']=$var['date'];
				$data['betCount']=$var['betCount'];
				$data['betMoney']=floatval($var['betAmount']);
				/*$data['reward']=floatval($var['zjAmount']);*/
				$data['rewardRebate']=floatval($var['zjAmount']-$var['betAmount']+$var['rebateMoney']);
				/*$data['rebateMoney']=floatval($var['rebateMoney']);
				$data['rewardDouble']=floatval($var['zjAmount']+$var['rebateMoney']);*/
				$data['rebateMoneyDouble']=floatval($var['rebateMoney']);
				$data['rewardRebateDouble']=floatval($var['zjAmount'] + $var['rebateMoney'] - $var['betAmount']);
				$data['betMoneyDouble']=floatval($var['betAmount']);
				array_push($idkey, $var['type']);
				array_push($datanewarr, $data);
			}
		}
		$datanewarr2= array_combine($idkey,$datanewarr);
		echo json_encode($datanewarr2);

		/*{"1":{"id":null,"gameId":1,"userId":null,"dlId":null,"dlName":null,"zdlId":null,"zdlName":null,"userName":null,"statDate":"2016-12-20 星期二","betCount":3,"betMoney":3.0,"reward":-1.01,"rewardRebate":-0.995,"rebateMoney":0.015,"userCount":null,"fullName":null,"rewardDouble":-1.01,"rebateMoneyDouble":0.015,"rewardRebateDouble":-0.995,"betMoneyDouble":3.0},"50":{"id":null,"gameId":50,"userId":null,"dlId":null,"dlName":null,"zdlId":null,"zdlName":null,"userName":null,"statDate":"2016-12-20 星期二","betCount":7,"betMoney":13.0,"reward":-1.46,"rewardRebate":-1.395,"rebateMoney":0.065,"userCount":null,"fullName":null,"rewardDouble":-1.46,"rebateMoneyDouble":0.065,"rewardRebateDouble":-1.395,"betMoneyDouble":13.0}}*/

	}

	public final function getNoticesdo(){
		//'Userrech/getNotices.php'
		echo '';
	}
	public final function onlinePaydo(){
		$this->freshSession();
		if($this->user['uid']){
			$rechargeId=$this->getRechId();
			$bankid=$_REQUEST["payId"];
			$uid=$this->user['uid'];
			$amount=floatval($_REQUEST['amount']);
			$time=date('Y-m-d H:i:s', time());
			$rechId = $_REQUEST['rechId'];

			if($amount && $uid && $rechargeId){
				if($this->update("INSERT INTO {$this->prename}order (order_number, username, recharge_amount, state, time) VALUES('{$rechargeId}', '{$uid}', '{$amount}', '0', '{$time}')")){
					$para=array();
					$para['mBankId']=intval($bankid);
					$para['amount']=floatval($amount);
					$para['rechargeId']=$rechargeId;
					$para['actionTime']=$this->time;
					$para['uid']=$this->user['uid'];
					$para['username']=$this->user['username'];
					$para['actionIP']=$this->ip(true);
					if($rechId==287 || $bankid=='ZHIFUBAO'){
						$para['info']='支付宝扫码充值';
					}elseif($rechId==286 || $bankid=='WEIXIN'){
						$para['info']='新宝微信扫码充值';
					}else{
						$para['info']='用户在线充值';
					}
					if($this->insertRow($this->prename .'member_recharge', $para)){
						if($bankid==1 || $bankid==2){
							$url='?MerBillNo='.$rechargeId.'&bankid='.$bankid.'&uid='.$uid.'&Amount='.$amount;
							header("Location: http://www.38000a.com/pay/zfb.html".$url); 
						}else{
							$pay_type='0002';//新宝微信
							$url='?pay_type='.$pay_type.'&order_no='.$rechargeId.'&amount='.$amount;
							header("Location: http://www.38000a.com/pay/wx.html".$url); 			
						}
					}else{
						echo '充值订单生成出错';
						exit;
					}		
				}else{
					echo '操作错误';
					exit;	
				}
			}
		}
	}
	
	public final function savedo(){
		$this->freshSession();
		if($this->user['uid']){
		$rechargeId=$this->getRechId();
		$uid=$this->user['uid'];
		$amount=floatval($_POST['amount']);
		$cfgId=$_POST['cfgId'];
		$time=date('Y-m-d H:i:s', time());
		$username=$_POST['username'];
		$depositTime=$_POST['depositTime'];
			if($amount && $uid && $rechargeId && $depositTime && $username){
				$para=array();
				$para['amount']=$amount;
				$para['rechargeId']=$rechargeId;
				$para['actionTime']=$this->time;
				$para['uid']=$this->user['uid'];
				$para['username']=$this->user['username'];
				$para['actionIP']=$this->ip(true);
				if ($cfgId == 288) {
		            $para['info']='微信扫码支付充值';
		            $para['depositinfo']='微信昵称:'.$username.'<br>存款时间:'.$depositTime;
		            $para['rechType']='weixin';
		        } else if($cfgId == 289) {
		            $para['info']='支付宝扫码支付充值';
		            $para['depositinfo']='支付宝昵称:'.$username.'<br>存款时间:'.$depositTime;
		            $para['rechType']='alipay';
		        }else if ($cfgId == 290) {
		            $para['info']='银行转账充值';
		            $para['depositinfo']='附言：'.$_POST['code'].'<br>银行卡账号:'.$username.'<br>存款方式：'.$_POST['type'].'<br>存款时间:'.$depositTime;
		            $para['rechType']='unionpay';
		        } else {
		            $para['info']='支付宝转账充值';
		            $para['depositinfo']='支付宝昵称:'.$username.'<br>存款时间:'.$depositTime;
		            $para['rechType']='alipay';
		        }

				if($this->insertRow($this->prename .'member_recharge', $para)){
					echo '存款信息提交成功，请等待客服审核';
					exit;
				}else{
					echo '提交失败,请联系客服处理';
					exit;
				}		
			}else{
					echo '提交失败';
					exit;
				}	
		}
	}

	public final function getRechId(){
		$rechargeId=date('YmdHis').mt_rand(1000,9999);
		if($this->getRow("select id from {$this->prename}member_recharge where rechargeId=$rechargeId")){
			getRechId();
		}else{
			return $rechargeId;
		}
	}
}

?>