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
	<script type="text/javascript"> 
		$(document).ready(function(){ 
			alert("你好！这是测试网站，请勿充值，需要请联系QQ "); 
		}) 
	</script>
</head>
<body class="{{'skin_' + appConfig.skin}} ng-binding" ng-app="ionicz" ng-controller="AppCtrl">
	<script src="<?php echo site_url('app/lib/spin.min.js'); ?>"></script>
	
  	<ion-nav-bar class="bar-header bar-positive hide">
		<!-- <ion-nav-back-button></ion-nav-back-button> -->
	</ion-nav-bar>
  	<!-- <div ng-if="inited">
  		<ion-nav-view></ion-nav-view>
  	</div> -->
  	<ion-nav-view></ion-nav-view>
  	
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
<!-- <script src="<?php echo site_url('app/views/ucenter/ucenter.js'); ?>"></script> -->
</html>