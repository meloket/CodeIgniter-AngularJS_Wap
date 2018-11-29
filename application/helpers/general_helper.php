<?php
defined('BASEPATH') or exit('No direct script access allowed');
header('Content-Type: text/html; charset=utf-8');

	/**
	 * Get Client Ip Address
	 */
	/*function ip($outFormatAsLong=false){
		if (isset($HTTP_SERVER_VARS['HTTP_X_FORWARDED_FOR']))
			$ip = $HTTP_SERVER_VARS['HTTP_X_FORWARDED_FOR'];
		elseif (isset($HTTP_SERVER_VARS['HTTP_CLIENT_IP']))
			$ip = $HTTP_SERVER_VARS['HTTP_CLIENT_IP'];
		elseif (isset($HTTP_SERVER_VARS['REMOTE_ADDR']))
			$ip = $HTTP_SERVER_VARS['REMOTE_ADDR'];
		elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		elseif (isset($_SERVER['HTTP_CLIENT_IP']))
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		elseif (isset($_SERVER['REMOTE_ADDR']))
			$ip = $_SERVER['REMOTE_ADDR'];
		else
			$ip = '0.0.0.0';
		if(strrpos(',',$ip)>=0){
			$ip = explode(',',$ip,2);
			$ip = current($ip);
		}
		return $outFormatAsLong ? ip2long($ip) : $ip;
	}*/
	/**
	 * Filter string
	 */
	function wjStrFilter($str,$pi_Def="",$pi_iType=1){

		if ($str)
			$str = trim($str);
		else
			return $pi_Def;
		// INT
		if ($pi_iType==0)
		{
			if (is_numeric($str))
				return $str;
			else
				return $pi_Def;
		}
	  
		// String
		if($str){
			$str=str_replace("chr(9)","&nbsp;",$str);
			$str=str_replace("chr(10)chr(13)","<br />",$str);
			$str=str_replace("chr(10)","<br />",$str);
			$str=str_replace("chr(13)","<br />",$str);
			$str=str_replace("chr(32)","&nbsp;",$str);
			$str=str_replace("chr(34)","&quot;",$str);
			$str=str_replace("chr(39)","&#39;",$str);
			$str=str_replace("script", "&#115cript",$str);
			$str=str_replace("&","&amp;",$str);
			$str=str_replace(";","&#59;",$str);
			$str=str_replace("'","&#39;",$str);
			$str=str_replace("<","&lt;",$str);
			$str=str_replace(">","&gt;",$str);
			$str=str_replace("#","&#40;",$str);
			$str=str_replace("*","&#42;",$str);
			$str=str_replace("--","&#45;&#45;",$str);
			
			$str=preg_replace("/insert/i", "",$str);
			$str=preg_replace("/update/i", "",$str);
			$str=preg_replace("/delete/i", "",$str);
			$str=preg_replace("/select/i", "",$str);
			$str=preg_replace("/drop/i", "",$str);
			$str=preg_replace("/load_file/i", "",$str);
			$str=preg_replace("/outfile/i", "",$str);
			$str=preg_replace("/into/i", "",$str);
			$str=preg_replace("/exec/i", "",$str);
			$str=preg_replace("/ssc_/i", "",$str);
			$str=preg_replace("/union/i", "",$str);
			$str=preg_replace("/%/i", "",$str);
			
			if (get_magic_quotes_gpc()){
				$str = str_replace("\\\"", "&quot;",$str);
				$str = str_replace("\\''", "&#039;",$str);
			}else{
				$str = addslashes($str);
				$str = str_replace("\"", "&quot;",$str);
				$str = str_replace("'", "&#039;",$str);
				
			}
		}
		return $str;
	}
?>