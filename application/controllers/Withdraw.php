<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Withdraw extends WebLoginBase_Controller {

	public function __construct()
    {
        parent::__construct();
    }

    public final function getWithDrawListdo(){
		$pagenum=intval($_GET['page']);
		$pagesize=intval($_GET['rows']);
		$startDate = isset($_GET['startDate']) ? $_GET['startDate'] : NULL;
		$endDate = isset($_GET['endDate']) ? $_GET['endDate'] : NULL;
		$state=intval(isset($_GET['status']) ? $_GET['status'] : NULL);
		
		$sql = "";
		if($startDate){
			$startDate=strtotime($_GET['startDate']);
			$sql=" and c.actionTime >={$startDate} ";
		}
		if($endDate){
			$endDate=strtotime($endDate.' 23:59:59');
			$sql.=" and c.actionTime <= {$endDate} ";
		}
		//充值订单状态：0申请，1手动到账,2自动到账,3充值失败,9管理员充值
		if(is_null(isset($_GET['status']) ? $_GET['status'] : NULL)){
			$state=5;
		}
		if($state==0 || $state==3){
			$sql.=" and c.state in(0,3) ";
		}elseif($state==1){
			$sql.=" and c.state=1 ";
		}elseif($state==2 || $state==4){
			$sql.=" and c.state in(2,4) ";
		}else{
			$sql.=" and c.state < 5 ";
		}
		$sql="select b.name bankName, c.*, u.username userAccount, u.gudongId, u.zparentId, u.parentId, d.countname from {$this->prename}bank_list b, {$this->prename}member_cash c, {$this->prename}members u,{$this->prename}member_bank d where b.isDelete=0 and c.isDelete=0 and u.uid={$this->user['uid']} {$sql} and c.bankId=b.id and c.uid=u.uid and u.uid=d.uid order by c.id desc";
		//echo $sql;
		$list=$this->getPage($sql, $pagenum, $pagesize);
		//提现状态：0已到帐, 1用户申请，2已取消，3已支付，4提现失败，0确认到帐, 5后台删除
		//$stateName=array('已到帐','申请中','已取消','已支付','已失败','已删除');

		$allarr=array();
		$allarr['data']=array();
		$allarr['totalCount']=0;
		$allarr['otherData']=null;
		if($list){
			$listarr=array();
			foreach($list['data'] as $var){
					$listarr['id']=intval($var['id']);
					$listarr['userId']=intval($var['uid']);
					$listarr['applyMoney']=floatval($var['amount']);
					$listarr['orderNo']=date("YmdHis",$var['actionTime']).$var['uid'];
					$listarr['applyTime']=date("Y-m-d H:i:s",$var['actionTime']);
					$listarr['reason']=$var['bankName'].'尾号'.substr($var['account'],-4);
					$listarr['checkStatus']=intval($var['state']);
					$listarr['bankName']=$var['bankName'];
					$listarr['bankCard']=$var['account'];
					$listarr['bankAccount']=$var['username'];
					array_push($allarr['data'], $listarr);
			}
			$allarr['totalCount']=$list['total'];
		}
		echo json_encode($allarr);

		/*{"data":[{"id":288658,"userId":67473,"account":"","userName":"","dlId":3,"dlName":"dl01","accountMoney":0.0,"rechMoney":20.0,"orderNo":"10161220222206972992","addTime":"2016-12-20 22:22:07","status":2,"rechTime":"2016-12-20 22:22:07","remark":"通过闪付充值20.0元","channel":55,"operator":null,"operatorTime":null,"rechType":"onlinePayment","rechName":"在线支付","payeeName":null,"payee":"610208","payeeInfo":null,"payeeBankName":null,"actualMoney":20.0,"updateTime":"2016-12-20 22:24:34","thirdOrderNo":null,"rechLevel":"0","rebateMoney":0.0,"thirdChannel":"57","statDate":"2016-12-20 22:24:34","onlineType":7}],"totalCount":2,"otherData":null}*/

	}

	/**
	 * 提现申请
	 */
	public final function submitdo(){
		if(!$_POST){echo '参数出错';exit;}
		$para['amount']=$_POST['amount'];
		$para['coinpwd']=$_POST['coinpwd'];
		$bank=$this->getRow("select username,account,bankId from {$this->prename}member_bank where uid={$this->user['uid']} limit 1",$this->user['uid']);
		$para['username']=$bank['username'];
		$para['account']=$bank['account'];
		$para['bankId']=$bank['bankId'];
		if(!ctype_digit($para['amount'])){echo '提现金额包含非法字符';exit;} //throw new Exception('提现金额包含非法字符');
		if($para['amount']<=0){echo '提现金额只能为正整数';exit;} //throw new Exception("提现金额只能为正整数");
		if($para['amount']>$this->user['coin']){echo '提款金额大于可用余额，无法提款';exit;} //throw new Exception("提款金额大于可用余额，无法提款");
		if($this->user['coin']<=0){echo '可用余额为零，无法提款';exit;} //throw new Exception("可用余额为零，无法提款");
		
		//提示时间检查
		$baseTime=strtotime(date('Y-m-d ',$this->time).'06:00');
		$fromTime=strtotime(date('Y-m-d ',$this->time).$this->settings['cashFromTime'].':00');
		$toTime=strtotime(date('Y-m-d ',$this->time).$this->settings['cashToTime'].':00');
		if($toTime<$baseTime) $toTime.=24*3600;
		if($this->time < $fromTime || $this->time > $toTime ){echo "提现时间：从".$this->settings['cashFromTime']."到".$this->settings['cashToTime'];exit;} 
		//throw new Exception("提现时间：从".$this->settings['cashFromTime']."到".$this->settings['cashToTime']);

		//消费判断
		$cashAmout=0;
		$rechargeAmount=0;
		$rechargeTime=strtotime('00:00')-2*24*3600;
		if($this->settings['cashMinAmount']){
			$cashMinAmount=$this->settings['cashMinAmount']/100;
			$gRs=$this->getRow("select sum(case when rechargeAmount>0 then rechargeAmount else amount end) as rechargeAmount from {$this->prename}member_recharge where  uid={$this->user['uid']} and state in (1,2,9) and isDelete=0 and rechargeTime>=".$rechargeTime);
			if($gRs){
				$rechargeAmount=$gRs["rechargeAmount"]*$cashMinAmount;
			}
			if($rechargeAmount){
				//消费总额
				//throw new Exception("消费满".$this->settings['cashMinAmount']."%才能提现");
			}
		}//消费判断结束
		$this->beginTransaction();
		try{
			$this->freshSession();
			if($this->user['coinPassword']!=md5($para['coinpwd'])){echo '提款密码不正确';exit;} //throw new Exception('提款密码不正确');
			unset($para['coinpwd']);
			
			if($this->user['coin']<$para['amount']){echo '你帐户资金不足';exit;} //throw new Exception('你帐户资金不足');
		
			// 查询最大提现次数与已经提现次数
			$time=strtotime(date('Y-m-d', $this->time));
			/*if($times=$this->getValue("select count(*) from {$this->prename}member_cash where actionTime>=$time and uid=?", $this->user['uid'])){
				if($times>=5) throw new Exception('对不起，今天你提现次数已达到最大限额，请明天再来');
			}*/
			
			// 插入提现请求表
			$para['actionTime']=$this->time;
			$para['uid']=$this->user['uid'];
			if(!$this->insertRow($this->prename .'member_cash', $para)){echo '提交提现请求出错';exit;} //throw new Exception('提交提现请求出错');
			$id=$this->lastInsertId();
			
			// 流动资金
			$this->addCoin(array(
				'coin'=>0-$para['amount'],
				'fcoin'=>$para['amount'],
				'uid'=>$para['uid'],
				'liqType'=>106,
				'info'=>"提现[$id]资金冻结",
				'extfield0'=>$id
			));

			$this->commit();
			echo 'ok';
			exit;
			//return '申请提现成功，请等待客服人员审核';
		}catch(Exception $e){
			$this->rollBack();
			//return 9999;
			throw $e;
		}
	}
}

?>