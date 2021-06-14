<?php
include "config.php";
include dirname(__FILE__) . '/../include/class.db.php';

//检测参数
if (!filter_has_var(INPUT_POST, "type")) { exit(json_encode(array('success' => 0, 'icon' => 0, 'm' => "请勿非法调用！")));}

//传参初始化
$type = filter_input(INPUT_POST, 'type');
$id = filter_input(INPUT_POST, 'id');

//json 初始化
$info = array('success' => 0, 'icon' => 6);

switch ($type) {
    //修改 管理员密码 
    case 'user_edit':
        $CONFIG["user"] = trim(filter_input(INPUT_POST, 'username'));
        $CONFIG["pass"] = md5(trim(filter_input(INPUT_POST, 'password')));
        $info['m'] = $user . "修改成功";
        break;	
    default:
        exit(json_encode(array('success' => 0, 'icon' => 0, 'm' => "参数错误！")));
}


if (Main_db::save()) {
    $info['success'] = 1;
} else {

    $info['success'] = 0;
    $info['icon'] = 5;
    $info['m'] = "操作失败！";
}

exit(json_encode($info));

function isid(){   
    if(!filter_has_var(INPUT_POST, "id")){ exit(json_encode(array('success' => 0, 'icon' => 0, 'm' => "id错误，没有找到id！"))); }   
}

function curl($url, $ref = '') {
    $params["ua"] = "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.84 Safari/537.36";
    $params['ref'] = $ref;
    return GlobalBase::curl($url, $params);
}
