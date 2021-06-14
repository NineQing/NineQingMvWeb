<?php
//引入上传类
require_once dirname(__FILE__).'/../include/class.upload.php';
$upload = new uploads();
$upload->uploadPath = '../upload'; //设定上传目录
$dest = $upload->uploadsFile();
if($dest[0]){
	$img = str_replace("../","/ckplayer/",$dest[0]);
    $arr['msg'] = '文件上传成功';
    $arr['code'] = 1;
    $arr['data'] = array('file'=>$img);	
}else{
    $arr['msg'] = '文件上传失败';
    $arr['code'] = 0;
    $arr['data'] = array('file'=>'');	
}
echo json_encode($arr,true);
?>