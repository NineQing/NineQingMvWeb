<?php 
 include "config.php"; 
 require_once(dirname(__FILE__).'/../include/class.db.php');
 session_start(); 
 if(isset($_SESSION['lock_config'])){ $time=(int)$_SESSION['lock_config']-(int)time(); if($time>0){ exit(json_encode(array('success'=>0,'icon'=>5,'m'=>"请勿频繁提交，".$time."秒后再试！")));}}
 $_SESSION['lock_config']= time()+ $from_timeout;
  
//播放器基本设置；
if(filter_has_var(INPUT_POST, "state")){
	$play = array(
	    'state' => filter_input(INPUT_POST, "state"),
		'logo' => filter_input(INPUT_POST, "logo"),
		'poster' => filter_input(INPUT_POST, "poster"),
		'copyright' => trim(filter_input(INPUT_POST, "copyright")),
		'rightlink' => trim(filter_input(INPUT_POST, "rightlink")),
		'auto' => filter_input(INPUT_POST, "auto"),
		'cookie' => filter_input(INPUT_POST, "cookie"),
		'loop' => filter_input(INPUT_POST, "loop"),
		'controls' => filter_input(INPUT_POST, "controls"),
		'hls' => filter_input(INPUT_POST, "hls")
	);
}
 
 //前置广告设置；
if(filter_has_var(INPUT_POST, "pre_off")){
	$pre = array(
	    'off' => filter_input(INPUT_POST, "pre_off"),
		'time' => trim(filter_input(INPUT_POST, "pre_time")),
		'pic' => trim(filter_input(INPUT_POST, "pre_pic")),
		'link' => trim(filter_input(INPUT_POST, "pre_link"))
	);
} 

 //暂停广告设置；
if(filter_has_var(INPUT_POST, "pause_off")){
	$pause = array(
	    'off' => filter_input(INPUT_POST, "pause_off"),
		'pic' => trim(filter_input(INPUT_POST, "pause_pic")),
		'link' => trim(filter_input(INPUT_POST, "pause_link"))
	);
} 

if( Main_db::save()){
	
	     exit(json_encode(array('success'=>1,'icon'=>1,'m'=>"保存成功!")));
	
	 }else{
		 exit(json_encode(array('success'=>0,'icon'=>0,'m'=>"保存失败!请检测配置文件权限")));
} 
  

