<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Game extends WebLoginBase_Controller {

	public function __construct()
    {
        parent::__construct();
    }

    public final function getServerDatado(){
    	echo '{"quotaConfig":{},"playConfig":{}}';
	}

	
	public final function getMoneydo(){
		if($this->user['testFlag']==1){
			$userAmount=$this->getValue("select coin from {$this->prename}guestmembers where uid={$this->user['uid']}");
		}else{
			$userAmount=$this->getValue("select coin from {$this->prename}members where uid={$this->user['uid']}");
		}
		echo $userAmount;
	}

	//aaron add //
	public function getServerCurrenttimedo(){
		echo json_encode(time());
	}
	public function getRealtimeStatusdo(){
		//gameid
		//updatetime
		if(!isset($_POST['gameId']) || !isset($_POST['updateTime']))
		{
			$result = array();
			echo json_encode($result);
			return;
		}
		$gameId=intval($_POST['gameId']);
		$stime=intval($_POST['updateTime']);

		$result = $this->getRows("select * from {$this->prename}bets where isDelete=0 and type={$gameId} and actionTime >= {$stime}");

		echo json_encode($result);
	}

	public final function getNotcountdo(){
		$pagenum=1;
		$pagesize=10;
		$gametype=$this->getPage("select * from {$this->prename}type order by sort asc",$pagenum,$pagesize);
		if($gametype){
			//$datestr=strtotime('00:00');
			$allarr=array();
			foreach($gametype['data'] as $key => $var){
				$gameId=$var['id'];
				$sql=" and type={$gameId}";
				/*if($datestr){
				//$sql=" and actionTime >= {$datestr} ";	
				}*/
				if($this->user['testFlag']==1){
					$list=$this->getRow("select type as gameId, sum(totalNums)  totalNums, sum(money * totalNums) totalMoney from {$this->prename}guestbets where isDelete=0 and lotteryNo='' and uid={$this->user['uid']} {$sql}");
				}else{
					$list=$this->getRow("select type as gameId, sum(totalNums)  totalNums, sum(money * totalNums) totalMoney from {$this->prename}bets where isDelete=0 and lotteryNo='' and uid={$this->user['uid']} {$sql}");
				}	
				if($list['gameId'] && $list['totalMoney']){
				$list['gameId']=intval($list['gameId']);
				$list['totalNums']=intval($list['totalNums']);
				$list['totalMoney']=intval($list['totalMoney']);
				array_push($allarr, $list);
				}
			}
			echo json_encode($allarr);
		}
		/*[{"gameId":50,"totalNums":5,"totalMoney":10.0},{"gameId":1,"totalNums":5,"totalMoney":10.0}]*/
	}

	public final function getNotcountDetaildo(){
		//即时注单明细-未结算明细
		$gameId=intval($_POST['gameId']);
		$pagenum=intval($_POST['page']);
		$pagesize=intval($_POST['rows']);
		$elemet=$_GET['elemet'];
		$settled=$_GET['settled'];
		if(!$pagenum){
			$pagenum=1;
		}
		if(!$pagesize){
			$pagesize=100;	
		}
		if(!$settled){$settled='false';}
		if($gameId){
			$sql=" and type={$gameId} ";
		}
		if($settled=='false'){
			$sql=$sql." and lotteryNo='' ";
		}elseif($settled=='true'){
			$sql=$sql." and lotteryNo !='' ";
		}else{
			$sql=$sql." and lotteryNo='' ";	
		}
		$datestr=strtotime('00:00');

		if($settled=='true'){
			$sql=$sql." and actionTime >= {$datestr} ";
		}
		$sql=$sql.' order by id desc';
		if($this->user['testFlag']==1){
			$list=$this->getPage("select * from {$this->prename}guestbets where  isDelete=0 and uid={$this->user['uid']} {$sql}");
		}else{
			$list=$this->getPage("select * from {$this->prename}bets where  isDelete=0 and uid={$this->user['uid']} {$sql}");
		}

		$allarr=array();
		$allarr['data']=null;
		$allarr['totalCount']=0;
		$allarr['otherData']=null;

		$dataarr=array();
		$dataarr['id']=null;
		$dataarr['userId']=null;
		$dataarr['userName']=null;
		/* $dataarr['dlId']=null;
		$dataarr['zdlId']=null; */
		$dataarr['playId']=null;
		$dataarr['playCateId']=null;
		$dataarr['odds']=null;
		$dataarr['rebate']=0;
		$dataarr['addTime']=null;
		$dataarr['turnNum']=null;
		$dataarr['gameId']=null;
		$dataarr['status']=0; //0为未结明细,1为已结明细
		$dataarr['rebateMoney']=0;
		$dataarr['orderNo']=null;
		$dataarr['lotteryNo']=null;
		$dataarr['remark']='';
		$dataarr['openTime']=null;
		$listarr['testFlag']=$this->user['testFlag'];
		$dataarr['multiple']=1;
		$dataarr['betInfo']='';
		$dataarr['money']=0; //投注金额
		$dataarr['resultMoney']=0;

		$allarr['otherData']=array();
		$allarr['otherData']['totalRebateMoney']=0;
		$allarr['otherData']['totalResultMoney']=0;
		$allarr['otherData']['totalBetMoney']=0;

		if($list['data']){
			$allarr['data']=array();
			foreach($list['data'] as $key => $var){ 
				$dataarr['id']=intval($var['id']);
				$dataarr['userId']=intval($var['uid']);
				$dataarr['userName']=$var['username'];
				/* $dataarr['dlId']=null; //代理
				$dataarr['zdlId']=null;//总代理 */
				$dataarr['playId']=intval($var['playedId']);
				$dataarr['playCateId']=intval($var['playedGroup']);
				$dataarr['odds']=floatval($var['odds']);
				$dataarr['rebate']=floatval($var['rebate']);
				$dataarr['addTime']=date("Y-m-d H:i:s",$var['actionTime']);
				$dataarr['turnNum']=$var['actionNo'];
				$dataarr['gameId']=intval($var['type']);
				$tzmoney=$var['money'] * $var['totalNums'];
				if($settled=='true'){
					//已结算明细
					$dataarr['status']=1;
					$dataarr['money']=floatval($tzmoney);
					$dataarr['rebateMoney']=$tzmoney*$var['rebate']; //已退水金额
					$allarr['otherData']['totalRebateMoney']+=floatval(sprintf("%.2f",$tzmoney*$var['rebate'])); //退水总计
					$dataarr['resultMoney']=floatval(sprintf("%.2f",$var['bonus']-$tzmoney+$tzmoney*$var['rebate'])); //未结明细为可赢金额//已结明细为赢亏结果包括退水

				}else{
					//未结算明细
					$dataarr['status']=0;	
					$dataarr['money']=floatval($tzmoney);
					$dataarr['resultMoney']=floatval(sprintf("%.2f",$var['money']*$var['odds']-$tzmoney+$tzmoney*$var['rebate']));//未结明细可赢额金包括退水//已结明细结果包括退水
					
				}

				$dataarr['orderNo']=$var['wjorderId'];
				$dataarr['lotteryNo']=$var['lotteryNo'];
				$dataarr['remark']=$var['lotteryNo'];
				$lastNo=$this->getGameLastNo($var['type'],$var['time']);
				$dataarr['openTime']=date("Y-m-d H:i:s",$var['kjTime']);
				$dataarr['testFlag']=$this->user['testFlag'];//测试用户为1
				array_push($allarr['data'],$dataarr);

				$allarr['otherData']['totalResultMoney']+=$dataarr['resultMoney'];
				$allarr['otherData']['totalBetMoney']+=$tzmoney;

			}
			$allarr['totalCount']=$list['total'];
		}
		echo json_encode($allarr);
	}

	public final function statbetList(){
		$this->display('game/stat/betList.php');
	}
	
	public final function statstatTotalBet(){
		$this->display('game/stat/statTotalBet.php');
	}

	public final function statstatBet(){
		$this->display('game/stat/statBet.php');
	}
	
	public final function includeuser_bet_info(){
		$this->display('game/include/user_bet_info.php');
	}
	
	public final function includegame_rule(){
		$this->display('game/include/game_rule.php');
	}

	public final function getLotteryDatado(){
		$gameId = intval($_POST['gameId']);
		$toTime = strtotime('00:00:00');
		$totalMoney = $balancedMoney = $unbalancedMoney=0;

		if($gameId==70){
		$actionNo=$this->getGamenextNo($gameId);
		$lastNo=intval($actionNo['actionNo'])-1;
		//echo $lastNo;
		$sql=" and type={$gameId} and actionNo={$lastNo} ";
		}elseif($gameId){
		$sql=" and type={$gameId} and actionTime>={$toTime} ";
		}else{
		$sql=" and actionTime>={$toTime} ";
		}
		$sql=$sql.' order by id desc';
		if($this->user['testFlag']==1){
		$list=$this->getRows("select * from {$this->prename}guestbets where  isDelete=0 and uid={$this->user['uid']}  {$sql}");
		$userAmount=$this->getValue("select coin from {$this->prename}guestmembers where uid={$this->user['uid']}");
		}else{
		$list=$this->getRows("select * from {$this->prename}bets where  isDelete=0 and uid={$this->user['uid']}  {$sql}");
		$userAmount=$this->getValue("select coin from {$this->prename}members where uid={$this->user['uid']}");
		}

		$userinfo=array();
		$userAmount=$this->getValue("select coin from {$this->prename}members where uid={$this->user['uid']}");
		$userinfo['balance']=floatval($userAmount);		
		$userinfo['unbalancedMoney']=floatval($unbalancedMoney);		
		$userinfo['totalTotalMoney']=floatval($TotalMoney-$balancedMoney);

		$userinfo['userBetNew']=null;
		$userinfo['userBetWinList']=null;
		$userinfo['pushMessage']=null;
		$userinfo['userNoticeMsg']=0;

		$listarr=array();
		$listarr['id']=null;
		$listarr['userId']=null;
		$listarr['userName']=null;
		/*$listarr['dlId']=null;
		$listarr['dlName']=null;
		$listarr['zdlId']=null;
		$listarr['zdlName']=null;*/
		$listarr['playId']=null;
		$listarr['playCateId']=null;
		$listarr['money']=0;
		$listarr['odds']=0;
		$listarr['rebate']=0;
		$listarr['addTime']=null;
		$listarr['turnNum']=null;
		$listarr['gameId']=null;
		$listarr['status']=0; //0为未结明细,1为已结明细
		$listarr['orderNo']=null;
		$listarr['openNum']=null;
		$listarr['openTime']=null;
		$listarr['testFlag']=$this->user['testFlag'];
		$listarr['multiple']=1;
		$listarr['betInfo']='';
		$listarr['betRebateMoney']=0;
		$listarr['unbalancedMoney']=0;
		$listarr['resultMoney']=0;

		if($list){
		$userinfo['userBetNew']=array();	
			foreach($list as $key => $var){ 

				if(!$var['lotteryNo'] && $key <15){	
					$betmoney=$var['money'] * $var['totalNums'];
					$listarr['id']=intval($var['id']);
					$listarr['userId']=intval($var['uid']);
					$listarr['userName']=$var['username'];
					/*$listarr['dlId']=null; //代理
					$listarr['zdlId']=null;//总代理*/
					$listarr['playId']=intval($var['playedId']);
					$listarr['playCateId']=intval($var['playedGroup']);
					$listarr['odds']=floatval($var['odds']);
					$listarr['rebate']=floatval($var['rebate']);
					$listarr['addTime']=date("Y-m-d H:i:s",$var['actionTime']);
					$listarr['turnNum']=$var['actionNo'];
					$listarr['gameId']=$var['type'];
					$listarr['money']=$betmoney;
					//未结算明细
					$listarr['unbalancedMoney']=floatval(sprintf("%.2f",$var['money']*$var['odds']-$betmoney+$betmoney*$var['rebate']));//用户金额变化未结算显示实际可赢金额包括退水
					$listarr['resultMoney']=$listarr['unbalancedMoney']; //未结明细可赢额包括退水//已结明细结果包括退水
					if($var['rebate']){
					$listarr['betRebateMoney']=$betmoney*$var['rebate']; //投注退水金额
					}
					$listarr['orderNo']=$var['wjorderId'];
					$listarr['openNum']=$var['lotteryNo'];
					$listarr['remark']='';
					$lastNo=$this->getGameLastNo($var['type'],$var['time']);
					$listarr['openTime']=date("Y-m-d H:i:s", $var['kjTime']);
					$listarr['testFlag']=$this->user['testFlag'];//测试用户为1		
					array_push($userinfo['userBetNew'], $listarr); 
				}
					if(!$var['lotteryNo']){
						//未开奖投注总金额		
						$unbalancedMoney+=$betmoney;
					}
					if($var['lotteryNo']){
						//已开奖投注总金额
						if($var['betInfo'] !=''){
							$betmoney2=$var['money'] * $var['totalNums'];	
						}else{
							$betmoney2=$var['money'];
						}
						$balancedMoney+=$betmoney2;
						$totalrebatemoney = (isset($totalrebatemoney) ? $totalrebatemoney : NULL) + $var['rebateMoney'];
					}			
					if($var['zjCount'] && $var['lotteryNo']){
					//已派奖总金额
					$TotalMoney+=$var['bonus'];
					}

			}
				$userinfo['unbalancedMoney']=floatval($unbalancedMoney);	
				$userinfo['totalTotalMoney']=floatval(sprintf("%.2f",$TotalMoney-$balancedMoney+$totalrebatemoney));
		}
		echo json_encode($userinfo);

		/*{"balance":1996.0,"unbalancedMoney":4.0,"totalTotalMoney":0.0,"userBetWinList":null,
		"userBetNew":[{"id":20630469,"userId":70742,"userName":"guest_148165246240","dlId":null,"dlName":"null","zdlId":null,"zdlName":"null",
		"playId":5510411,"playCateId":104,"betInfo":"","multiple":1,"winCount":null,"money":2.0,"odds":1.99,"rebate":0.005,"addTime":"2016-12-14 02:09:06",
		"turnNum":"20161213158","gameId":55,"status":0,"reward":0.0,"rewardRebate":null,"rebateMoney":null,"betSrc":0,"orderNo":"12161214020906790912562",
		"openNum":"null","remark":"null","result":0,"userCount":null,"move":0,"openTime":null,"statTime":"2016-12-13 00:00:00",
		"testFlag":1,"fullName":"null","formatAddTime":"12-14 02:09","rebateDouble":0.005,"betRebateMoney":0.01,"winMoney":3.98,
		"oddsDouble":1.99,"moneyDouble":2.0,"rewardRebateDouble":0.0,"unbalancedMoney":1.99,"resultMoney":1.99}
		],"pushMessage":null,"userNoticeMsg":0}
		*/	
	}
	
	public final function getUserMsgdo(){
		$this->type=$gameId=intval(isset($_GET['gameId']) ? $_GET['gameId'] : NULL);
		$toTime=strtotime('00:00:00');
		$totalMoney=$balancedMoney=$unbalancedMoney=0;

		if($gameId==70){
		$actionNo=$this->getGamenextNo($gameId);
		$lastNo=intval($actionNo['actionNo'])-1;
		//echo $lastNo;
		$sql=" and type={$gameId} and actionNo={$lastNo} ";
		}elseif($gameId){
		$sql=" and type={$gameId} and actionTime>={$toTime} ";
		}else{
		$sql=" and actionTime>={$toTime} ";
		}
		$sql=$sql.' order by id desc';
		if($this->user['testFlag']==1){
		$list=$this->getRows("select * from {$this->prename}guestbets where  isDelete=0 and uid={$this->user['uid']}  {$sql}");
		$userAmount=$this->getValue("select coin from {$this->prename}guestmembers where uid={$this->user['uid']}");
		}else{
		$list=$this->getRows("select * from {$this->prename}bets where  isDelete=0 and uid={$this->user['uid']}  {$sql}");
		$userAmount=$this->getValue("select coin from {$this->prename}members where uid={$this->user['uid']}");
		}

		$userinfo=array();
		$userinfo['balance']=floatval($userAmount);	
		$userinfo['unbalancedMoney']=floatval($unbalancedMoney);	
		$userinfo['totalTotalMoney']=floatval($totalMoney-$balancedMoney);

		$userinfo['userBetNew']=null;
		$userinfo['userBetWinList']=null;
		$userinfo['pushMessage']=null;
		$userinfo['userNoticeMsg']=0;

		$listarr=array();
		$listarr['id']=null;
		$listarr['userId']=null;
		$listarr['userName']=null;
		/*$listarr['dlId']=null;
		$listarr['dlName']=null;
		$listarr['zdlId']=null;
		$listarr['zdlName']=null;*/
		$listarr['playId']=null;
		$listarr['playCateId']=null;
		$listarr['money']=0;
		$listarr['odds']=0;
		$listarr['rebate']=0;
		$listarr['addTime']=null;
		$listarr['turnNum']=null;
		$listarr['gameId']=null;
		$listarr['status']=1; //0为未结明细,1为已结明细
		$listarr['orderNo']=null;
		$listarr['openNum']=null;
		$listarr['openTime']=null;
		$listarr['testFlag']=$this->user['testFlag'];
		$listarr['multiple']=1;
		$listarr['betInfo']='';
		$listarr['betRebateMoney']=0;
		$listarr['unbalancedMoney']=0;
		$listarr['resultMoney']=0;

		if($list){
		//$userinfo['userBetWinList']=array();	
			foreach($list as $key => $var){ 

				/*if($var['lotteryNo'] && $key <15){	
					if($var['betInfo'] !=''){
						$betmoney=$var['money'] * $var['totalNums'];
						$listarr['multiple']=$var['totalNums'];
						$listarr['betInfo']=$var['betInfo'];
					}else{
						$betmoney=$var['money'];
					}
					$listarr['id']=intval($var['id']);
					$listarr['userId']=intval($var['uid']);
					$listarr['userName']=$var['username'];
					$listarr['playId']=intval($var['playedId']);
					$listarr['playCateId']=intval($var['playedGroup']);
					$listarr['odds']=floatval($var['odds']);
					$listarr['rebate']=floatval($var['rebate']);
					$listarr['addTime']=date("Y-m-d H:i:s",$var['actionTime']);
					$listarr['turnNum']=$var['actionNo'];
					$listarr['gameId']=intval($var['type']);
					$listarr['money']=$betmoney;
					//已结算明细
					$listarr['unbalancedMoney']=floatval(sprintf("%.2f",$var['bonus']-$betmoney+$betmoney*$var['rebate']));//用户金额变化未结算显示实际可赢金额包括退水
					$listarr['resultMoney']=$listarr['unbalancedMoney']; //未结明细可赢额包括退水//已结明细结果包括退水
					if($var['rebate']){
					$listarr['betRebateMoney']=$betmoney*$var['rebate']; //投注退水金额
					}
					$listarr['orderNo']=$var['wjorderId'];
					$listarr['openNum']=$var['lotteryNo'];
					$listarr['remark']='';
					$lastNo=$this->getGameLastNo($var['type'],$var['time']);
					$listarr['openTime']=date("Y-m-d H:i:s", $var['kjTime']);
					$listarr['testFlag']=$this->user['testFlag'];//测试用户为1		
					array_push($userinfo['userBetWinList'], $listarr); 
				}*/
					if(!$var['lotteryNo']){
						//未开奖投注总金额		
						$unbalancedMoney+=(isset($betmoney) ? $betmoney : NULL);
					}
					if($var['lotteryNo']){
						//已开奖投注总金额
						if($var['betInfo'] !=''){
							$betmoney2=$var['money'] * $var['totalNums'];	
						}else{
							$betmoney2=$var['money'];
						}
						$balancedMoney+=$betmoney2;
						$totalrebatemoney = (isset($totalrebatemoney) ? $totalrebatemoney : NULL) + $var['rebateMoney'];			
					}			
					if($var['zjCount'] && $var['lotteryNo']){
					//已派奖总金额
					$totalMoney+=$var['bonus'];
					}

			}
				$userinfo['unbalancedMoney']=floatval($unbalancedMoney);	
				$userinfo['totalTotalMoney']=floatval(sprintf("%.2f",$totalMoney-$balancedMoney+(isset($totalrebatemoney) ? $totalrebatemoney : NULL)));
		}
		echo json_encode($userinfo);
		/*{"balance":2000.0,"unbalancedMoney":0.0,"totalTotalMoney":0.0,"userBetWinList":null,"userBetNew":null,"pushMessage":null,"userNoticeMsg":0}	*/	
	}
	
	public final function getHistorydo(){
		$this->type=$gameId=intval($_GET['gameId']);
		$count=intval($_GET['count']);
		if($count){
			$data=$this->getRows("select * from {$this->prename}data where type={$this->type} order by number desc,time desc limit {$count}");
		}else{
			$data=$this->getRows("select * from {$this->prename}data where type={$this->type} order by number desc,time desc limit 200");
		}
		$types=$this->getTypes();
		$kjdTime=$types[$gameId]['data_ftime'];
		$alldata=array();
		$historyData=array();
		$historyData['turnNum']=null;
		$historyData['openNum']=null;
		$historyData['openTime']=null;
		$historyData['openDate']=null;
		//$historyData['gameId']=$this->type;
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
		$historyData['total']=null;
		/*for($i = 1; $i <= 20; $i++){
			echo '$n'.$i.'=';
		}*/
		$historyData2='';
		foreach ($data as $key=>$value){
			//echo $value['number'];
			$lastNo=$this->getGameLastNo($gameId,$value['time']);
			$diffTime=strtotime($lastNo['actionTime'])-$kjdTime;
			//echo $lastNo['actionNo'].'_'.$lastNo['actionTime'].'<br>';
			$historyData['turnNum']=$value['number'];
			$historyData['openNum']=$value['data'];
			$historyData['openTime']=date("m-d H:i",strtotime($lastNo['actionTime']));
			$historyData['openDate']=date("Y-m-d H:i:s",strtotime($lastNo['actionTime']));
			$historyData['total']=0;
			$nums = explode(',', $value['data']);
			foreach ($nums as $keynum=>$n){
				$historyData['n'.($keynum+1)]=intval($n);
				$historyData['total']+=intval($n);
			}
			array_push($alldata, $historyData);

		}

		echo json_encode($alldata);
		/*[{"turnNum":"161209081","openNum":"3,3,5","openTime":"12-09 22:00","openDate":"2016-12-09 22:00:00",
		"n1":3,"n2":3,"n3":5,"n4":null,"n5":null,"n6":null,"n7":null,"n8":null,"n9":null,"n10":null,
		"n11":null,"n12":null,"n13":null,"n14":null,"n15":null,"n16":null,"n17":null,"n18":null,"n19":null,"n20":null,"total":11}]*/
	}
	public final function cqssc(){
		$this->display('game/cqssc/index.php');
	}
	
	public final function cqsscsol(){
		$this->display('game/cqssc/sol.php');
	}
	
	public final function cqsschistory(){
		$this->display('game/cqssc/history.php');
	}
	
	public final function pk10(){
		$this->display('game/pk10/index.php');
	}
	
	public final function pk10sol(){
		$this->display('game/pk10/sol.php');
	}
	
	public final function pk10com(){
		$this->display('game/pk10/com.php');
	}

	public final function pk10history(){
		$this->display('game/pk10/history.php');
	}

	public final function gdkl10(){
		$this->display('game/gdkl10/index.php');
	}
	
	public final function gdkl10sol(){
		$this->display('game/gdkl10/sol.php');
	}

	public final function gdkl10q1(){
		$this->display('game/gdkl10/q1.php');
	}

	public final function gdkl10q2(){
		$this->display('game/gdkl10/q2.php');
	}

	public final function gdkl10q3(){
		$this->display('game/gdkl10/q3.php');
	}

	public final function gdkl10q4(){
		$this->display('game/gdkl10/q4.php');
	}

	public final function gdkl10q5(){
		$this->display('game/gdkl10/q5.php');
	}

	public final function gdkl10q6(){
		$this->display('game/gdkl10/q6.php');
	}

	public final function gdkl10q7(){
		$this->display('game/gdkl10/q7.php');
	}

	public final function gdkl10q8(){
		$this->display('game/gdkl10/q8.php');
	}

	public final function gdkl10zm(){
		$this->display('game/gdkl10/zm.php');
	}

	public final function gdkl10lm(){
		$this->display('game/gdkl10/lm.php');
	}

	public final function gdkl10history(){
		$this->display('game/gdkl10/history.php');
	}
	
	public final function xync(){
		$this->display('game/xync/index.php');
	}
	
	public final function xyncsol(){
		$this->display('game/xync/sol.php');
	}
	
	public final function xyncq1(){
		$this->display('game/xync/q1.php');
	}

	public final function xyncq2(){
		$this->display('game/xync/q2.php');
	}

	public final function xyncq3(){
		$this->display('game/xync/q3.php');
	}

	public final function xyncq4(){
		$this->display('game/xync/q4.php');
	}

	public final function xyncq5(){
		$this->display('game/xync/q5.php');
	}

	public final function xyncq6(){
		$this->display('game/xync/q6.php');
	}

	public final function xyncq7(){
		$this->display('game/xync/q7.php');
	}

	public final function xyncq8(){
		$this->display('game/xync/q8.php');
	}

	public final function xynczm(){
		$this->display('game/xync/zm.php');
	}

	public final function xynclm(){
		$this->display('game/xync/lm.php');
	}

	public final function xynchistory(){
		$this->display('game/xync/history.php');
	}
	
	public final function pcdd(){
		$this->display('game/pcdd/index.php');
	}

	public final function pcddhistory(){
		$this->display('game/pcdd/history.php');
	}

	public final function bjkl8(){
		$this->display('game/bjkl8/index.php');
	}

	public final function bjkl8sol(){
		$this->display('game/bjkl8/sol.php');
	}

	public final function bjkl8history(){
		$this->display('game/bjkl8/history.php');
	}
	
	public final function gd11x5(){
		$this->display('game/gd11x5/index.php');
	}
	
	public final function gd11x5sol(){
		$this->display('game/gd11x5/sol.php');
	}
	public final function gd11x5zx(){
		$this->display('game/gd11x5/zx.php');
	}

	public final function gd11x5lm(){
		$this->display('game/gd11x5/lm.php');
	}

	public final function gd11x5history(){
		$this->display('game/gd11x5/history.php');
	}
	
	public final function jsk3(){
		$this->display('game/jsk3/index.php');
	}
	
	public final function jsk3history(){
		$this->display('game/jsk3/history.php');
	}

	public final function xyft(){
		$this->display('game/xyft/index.php');
	}
	
	public final function xyftsol(){
		$this->display('game/xyft/sol.php');
	}
	public final function xyftcom(){
		$this->display('game/xyft/com.php');
	}

	public final function xyfthistory(){
		$this->display('game/xyft/history.php');
	}

	public final function lhc(){
		$this->display('game/lhc/index.php');
	}

	public final function lhc2m(){
		$this->display('game/lhc/2m.php');
	}
	
	public final function lhcsb(){
		$this->display('game/lhc/sb.php');
	}

	public final function lhctx(){
		$this->display('game/lhc/tx.php');
	}

	public final function lhchx(){
		$this->display('game/lhc/hx.php');
	}

	public final function lhctws(){
		$this->display('game/lhc/tws.php');
	}

	public final function lhczm(){
		$this->display('game/lhc/zm.php');
	}

	public final function lhczmt(){
		$this->display('game/lhc/zmt.php');
	}

	public final function lhczm16(){
		$this->display('game/lhc/zm16.php');
	}

	public final function lhcwx(){
		$this->display('game/lhc/wx.php');
	}

	public final function lhcptyxws(){
		$this->display('game/lhc/ptyxws.php');
	}

	public final function lhczx(){
		$this->display('game/lhc/zx.php');
	}

	public final function lhc7sb(){
		$this->display('game/lhc/7sb.php');
	}

	public final function lhczhongxiao(){
		$this->display('game/lhc/zhongxiao.php');
	}

	public final function lhczxbz(){
		$this->display('game/lhc/zxbz.php');
	}

	public final function lhclxlw(){
		$this->display('game/lhc/lxlw.php');
	}

	public final function lhclm(){
		$this->display('game/lhc/lm.php');
	}

	public final function lhchistory(){
		$this->display('game/lhc/history.php');
	}
}

?>