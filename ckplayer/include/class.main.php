<?php
//不显示读取错误
ini_set("error_reporting", "E_ALL & ~E_NOTICE");

header('Content-Type:text/html;charset=utf-8');

//图片转base64
function base64EncodeImage ($image_file) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $image_file);
	curl_setopt($curl, CURLOPT_TIMEOUT, 10); 
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION,true);
    curl_setopt($curl, CURLOPT_ENCODING, 'gzip');
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); 
    $data = curl_exec($curl);
    $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    if ($code == 200){
        $logo_url = "data:image/jpeg;base64," . base64_encode($data);
    }else{
		$logo_url = '';
	}
	return $logo_url;
}

//获取远程内容
function geturl($url, $timeout = 10)
{
    $user_agent = "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36";
    $curl = curl_init();                                        //初始化 curl
    curl_setopt($curl, CURLOPT_URL, $url);                      //要访问网页 URL 地址
    curl_setopt($curl, CURLOPT_USERAGENT, $user_agent);           //模拟用户浏览器信息 
    curl_setopt($curl, CURLOPT_REFERER, $url);               //伪装网页来源 URL
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1);                //当Location:重定向时，自动设置header中的Referer:信息                   
    curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);             //数据传输的最大允许时间 
    curl_setopt($curl, CURLOPT_HEADER, 0);                     //不返回 header 部分
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);            //返回字符串，而非直接输出到屏幕上
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);             //跟踪爬取重定向页面
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, '0');        //不检查 SSL 证书来源
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, '0');        //不检查 证书中 SSL 加密算法是否存在
    curl_setopt($curl, CURLOPT_ENCODING, '');              //解决网页乱码问题
    $data = curl_exec($curl);
    curl_close($curl);
    return $data;
}

function lsMobile()
{
    if (isset($_SERVER['HTTP_USER_AGENT'])) {
        $clientkeywords = array('nokia', 'sony', 'ericsson', 'mot', 'samsung', 'htc', 'sgh', 'lg', 'sharp', 'sie-', 'philips', 'panasonic', 'alcatel', 'lenovo', 'iphone', 'ipod', 'blackberry', 'meizu', 'android', 'netfront', 'symbian', 'ucweb', 'windowsce', 'palm', 'operamini', 'operamobi', 'openwave', 'nexusone', 'cldc', 'midp', 'wap', 'mobile');
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
            return true;
        }
    }
    return false;
}


