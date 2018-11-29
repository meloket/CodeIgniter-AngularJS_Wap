<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">
    <meta name="format-detection" content="telephone=no">
    <title>welcome</title>
    
    <!-- favicon -->
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo base_url().'assets/favicon/apple-icon-57x57.png'; ?>">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo base_url().'assets/favicon/apple-icon-60x60.png'; ?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url().'assets/favicon/apple-icon-72x72.png'; ?>">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url().'assets/favicon/apple-icon-76x76.png'; ?>">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url().'assets/favicon/apple-icon-114x114.png'; ?>">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url().'assets/favicon/apple-icon-120x120.png'; ?>">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo base_url().'assets/favicon/apple-icon-144x144.png'; ?>">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url().'assets/favicon/apple-icon-152x152.png'; ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url().'assets/favicon/apple-icon-180x180.png'; ?>">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo base_url().'assets/favicon/android-icon-192x192.png'; ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url().'assets/favicon/favicon-32x32.png'; ?>">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url().'assets/favicon/favicon-96x96.png'; ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url().'assets/favicon/favicon-16x16.png'; ?>">
    <link rel="manifest" href="<?php echo base_url().'assets/favicon/manifest.json' ?>">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo base_url().'assets/favicon/ms-icon-144x144.png'; ?>">
    <meta name="theme-color" content="#ffffff">
    <!-- favicon -->

    <script src="http://ajax.aspnetcdn.com/ajax/jquery/jquery-2.1.1.min.js"></script>
    <script src="<?php echo site_url('app/lib/ionic/js/qrcode.js'); ?>"></script>
    <script type="text/javascript"> 
      $(document).ready(function(){ 
        //alert("你好！这是测试网站，请勿充值，需要请联系QQ "); 
      }) 
    </script>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url().'assets/vendor/bootstrap/css/bootstrap.min.css'; ?>" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url().'assets/css/business-frontpage.css'; ?>" rel="stylesheet">


    <link href="<?php echo base_url().'app/lib/ionic/css/ionic.min.css'; ?>" rel="stylesheet">
      <!-- <link href="<?php echo base_url().'app/css/main.pack.min.css'; ?>" rel="stylesheet"> -->


    <!-- Bootstrap core JavaScript -->
    <!-- <script src="<?php echo base_url().'assets/vendor/jquery/jquery.min.js'; ?>"></script> -->
    <script src="<?php echo base_url().'assets/vendor/bootstrap/js/bootstrap.bundle.min.js'; ?>"></script>

</head>
<body class="{{'skin_' + appConfig.skin}} ng-binding bodydiv" ng-app="ionicz" ng-controller="AppCtrl">
  <script src="<?php echo site_url('app/lib/spin.min.js'); ?>"></script>
  
  <!-- <ion-nav-bar class="bar-header bar-positive hide"> -->
    <!-- <ion-nav-back-button></ion-nav-back-button> -->
  <!-- </ion-nav-bar> -->
  



    <!-- Top First Navigation ::::::::::     This is showed before login -->
    <nav class="c_first_nav navbar navbar-expand-lg navbar-dark">
      <div class="container">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">                    
                <a class="nav-link"><span class="icon img-tel" style=""></span> 手机客户端</a>
            </li>
            <em class="left_right_pd">|</em>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url().'help'; ?>">帮助中心</a>
            </li>
        </ul>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link">客服中心</a>
            </li>
            <em class="left_right_pd">|</em>
            <li class="nav-item">
                <a class="nav-link"><span class="icon img-mes"><em class="red-dot"></em></span> 平台公告</a>
            </li>
            <em class="left_right_pd">|</em>
            <li class="nav-item">
                <a class="nav-link"><span class="icon img-person"><em class="red-dot"></em></span>{{My.getUserName()}}</a>
            </li>
            <li class="nav-item">
                <div class="row">
                    <a class="nav-link">余额:</a>
                    <a class="nav-link" style="float:left; padding-left:10px!important">{{My.getMoney()}}</a>
                </div>
            </li>
            <li class="nav-item active">
                <a class="nav-link btn-danger" href="<?php echo base_url().'#/bank/deposit'; ?>">充值</a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn-primary" href="<?php echo base_url().'#/bank/withdraw'; ?>">提现</a>
            </li>
            <em class="left_right_pd">|</em>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo site_url('/user/logout'); ?>">退出</a>
                <!-- <a class="nav-link" ng-click="logout();">退出</a> -->
            </li>
          </ul>
        </div>
      </div>
    </nav>


    <!-- Navigation -->
    <nav class="c_second_nav navbar navbar-expand-lg navbar-dark">
      <div class="container">
        <a class="navbar-brand" href="<?php echo base_url() ?>"><img src="<?php echo base_url().'/assets/img/logo.png' ?>" width=50%></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link navsub" href="#">购彩大厅</a>
              <div  class="lobbyBox" style="display: none;">
                <div class="lobby" style="border: 1px solid #888">
                  <div class="row">
                    <div class="col-sm-4 lobby_item">
                      <img src="<?php echo base_url().'/assets/img/g_mssc.png' ?>" width="25px">
                      <a style="color: rgba(208,2,27,.67);" href="<?php echo base_url().'#/lottery/index/72'; ?>"> 极速赛车</a><br>
                      <span style="font-size:14px">极速赛车</span>
                    </div>
                    <div class="col-sm-4 lobby_item">
                      <img src="<?php echo base_url().'/assets/img/g-bjpk10.png' ?>" width="25px">
                      <a style="color: rgba(208,2,27,.67);" href="<?php echo base_url().'#/lottery/index/50'; ?>"> 北京赛车(PK10)</a><br>
                      <span style="font-size:14px">北京赛车(PK10)</span>
                    </div>
                    <div class="col-sm-4 lobby_item">
                      <img src="<?php echo base_url().'/assets/img/g-ssc.png' ?>" width="25px">
                      <a style="color: rgba(208,2,27,.67);" href="<?php echo base_url().'#/lottery/index/1'; ?>"> 重庆时时彩</a><br>
                      <span style="font-size:14px">重庆时时彩</span>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-4 lobby_item">
                      <img src="<?php echo base_url().'/assets/img/g-xyft.png' ?>" width="25px">
                      <a style="color: rgba(208,2,27,.67);" href="<?php echo base_url().'#/lottery/index/55'; ?>"> 幸运飞艇</a><br>
                      <span style="font-size:14px">幸运飞艇</span>
                    </div>
                    <div class="col-sm-4 lobby_item">
                      <img src="<?php echo base_url().'/assets/img/g-msssc.png' ?>" width="25px">
                      <a style="color: rgba(208,2,27,.67);" href="<?php echo base_url().'#/lottery/index/73'; ?>"> 极速时时彩</a><br>
                      <span style="font-size:14px">极速时时彩</span>
                    </div>
                    <div class="col-sm-4 lobby_item">
                      <img src="<?php echo base_url().'/assets/img/g-pcdd.png' ?>" width="25px">
                      <a style="color: rgba(208,2,27,.67);" href="<?php echo base_url().'#/lottery/index/66'; ?>"> PC蛋蛋</a><br>
                      <span style="font-size:14px">PC蛋蛋</span>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-4 lobby_item">
                      <img src="<?php echo base_url().'/assets/img/g-hkc.png' ?>" width="25px">
                      <a style="color: rgba(208,2,27,.67);" href="<?php echo base_url().'#/lottery/index/70'; ?>"> 香港六合彩</a><br>
                      <span style="font-size:14px">香港六合彩</span>
                    </div>
                    <div class="col-sm-4 lobby_item">
                      <img src="<?php echo base_url().'/assets/img/g-klsf.png' ?>" width="25px">
                      <a style="color: rgba(208,2,27,.67);" href="<?php echo base_url().'#/lottery/index/60'; ?>"> 广东快乐十分</a><br>
                      <span style="font-size:14px">广东快乐十分</span>
                    </div>
                    <div class="col-sm-4 lobby_item">
                      <img src="<?php echo base_url().'/assets/img/g-hfc.png' ?>" width="25px">
                      <a style="color: rgba(208,2,27,.67);" href="<?php echo base_url().'#/lottery/index/21'; ?>"> 广东11选5</a><br>
                      <span style="font-size:14px">广东11选5</span>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-4 lobby_item">
                      <img src="<?php echo base_url().'/assets/img/g-jiang.png' ?>" width="25px">
                      <a style="color: rgba(208,2,27,.67);" href="<?php echo base_url().'#/lottery/index/10'; ?>"> 江苏骰宝(快3)</a><br>
                      <span style="font-size:14px">江苏骰宝(快3)</span>
                    </div>
                    <div class="col-sm-4 lobby_item">
                      <img src="<?php echo base_url().'/assets/img/g-da.png' ?>" width="25px">
                      <a style="color: rgba(208,2,27,.67);" href="<?php echo base_url().'#/lottery/index/74'; ?>"> 极速六合彩</a><br>
                      <span style="font-size:14px">极速六合彩</span>
                    </div>
                    <div class="col-sm-4 lobby_item">
                      <img src="<?php echo base_url().'/assets/img/g-wu.png' ?>" width="25px">
                      <a style="color: rgba(208,2,27,.67);" href="<?php echo base_url().'#/lottery/index/61'; ?>"> 重庆幸运农场</a><br>
                      <span style="font-size:14px">重庆幸运农场</span>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            
            <li class="nav-item">
              <a class="nav-link" href="#/lottery/history/">开奖结果</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#/lottery/huodong">活动中心</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#/lottery/task">任务中心</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">手机APP</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url().'#/ucenter/index'; ?>">用户中心</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <style>
    .c_second_nav .navbar-nav li > a:hover {
      background: rgba(255,186,0,.8);
      border-radius: 10px;
    }
    </style>

    <script>
    $(".navsub").hover(function(){
    // $(".lobbyBox").css("display", "block");
    $( ".lobbyBox" ).slideUp( 10 ).delay( 0 ).fadeIn( 100 );
    }, function(){
    // $(".lobbyBox").css("display", "none");
    $(".lobbyBox").hover(function(){
      $(".lobbyBox").css("display", "block");
      
      }, function(){
        $( ".lobbyBox" ).slideUp( 300 ).delay( 10 ).fadeOut( 1400 );
      // $(".lobbyBox").css("display", "none");
      // $( ".lobbyBox" ).slideUp( 300 ).delay( 10 ).fadeOut( 1400 );
    });

    });


    </script>

    <div ng-if="inited">
      <ion-nav-view  scroll="false"></ion-nav-view>
    </div>
    
    <!-- <div id="tanchu" class="backdrop visible active"></div>
    <div id="tanchuinfo" class="popup-container info-mdf popup-showing active" ng-class="cssClass" style="">
        <div class="popup">
            <div class="popup-head">
                <h3 class="popup-title ng-binding">公告</h3>
              
            </div>
            <div class="popup-body"><span>通知：网易彩票正式更名为"321彩票，会员帐号，会员额度以及登入网址保持不变。</span></div>
            <div class="popup-buttons">
                <button onclick="ttgb()" class="button ng-binding button-default">取消</button>
                <button onclick="ttgb()" class="button ng-binding button-positive">确定</button>
            </div>
        </div>
    </div> -->

  <!-- <ion-nav-view></ion-nav-view> -->
  

    <footer class="py-5 myfooter">
      <div class="container">
        <p class="m-0 text-center text-white">© 2011-2018 畅赢娱乐城版权所有<br>畅赢娱乐城郑重提示：彩票有风险，投注需谨慎，不向未满18周岁的青少年出售彩票</p>
      </div>
    </footer>

    


  <script id="test-template" type="text/ng-template">
    <div class="row">
      <div class="col">
        <div class="item item-input" ng-repeat="item in debugMsgList">{{item.time + ': ' + item.msg + ' - '+ item.count}}</div>
      </div>
    </div>
  </script>


  

</body>

<script src="<?php echo site_url('app/config/config.js'); ?>"></script>
  
<script src="<?php echo site_url('app/lib/ionic/js/ionic.bundle.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo site_url('app/js/lib.pack.js?v=1610251707'); ?>" ></script>

<script type="text/javascript" src="<?php echo site_url('app/js/app.pack.js?v=1610251707'); ?>" ></script>

<script src="<?php echo site_url('app/views/home/home.js'); ?>"></script>
<script src="<?php echo site_url('app/views/ucenter/ucenter.js'); ?>"></script>
</html>