<script charset="utf-8" src="jquery-1.7.2.min.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><!-- IE内核 强制使用最新的引擎渲染网页 -->
<meta name="renderer" content="webkit">  <!-- 启用360浏览器的极速模式(webkit) -->
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0 ,maximum-scale=1.0, user-scalable=no"><!-- 手机H5兼容模式 -->
<link rel="stylesheet" href="DPlayer.min.css">
<style type="text/css">
    body,html{width:100%;height:100%;background:#000;padding:0;margin:0;overflow-x:hidden;overflow-y:hidden}
    *{margin:0;border:0;padding:0;text-decoration:none}
    #dplayer{position:inherit}
</style>
<style>
      .b-videobottom {width:100%;height:20px;background:#ffffff;position:fixed;text-align:center;left:0;z-index:100;}
      .b-adicon {font-size:12px;color:#09a76d;line-height:15px;margin-left:5px;display:none;}
      .total{/*position:fixed;top:5px;left:8px;*/position:absolute;left:8px;bottom:60px;font-size:12px;color:#fdfdfd;text-shadow:1px 1px 1px #000, 1px 1px 1px #000}
    </style>  
  <body>
    <!--div class="b-videobottom">
        <span class="b-adicon" style="display: inline;">公告 > 请勿相信视频广告内容 > 卡顿请切换来源</span>
	</div--> 
<script language="javascript">
function codefans(){
var box=document.getElementById("divbox");
box.style.display="none";
}
//2秒，可以改动
setTimeout("codefans()",20000);
</script>
<!--提醒控制器-->
    <!--新增提醒-->
	<div id="divbox" style="width:80%; margin:0 auto;  z-index:9999999999; line-height:30px; height:30px; font-size:14px; position:absolute; color:#00a2ff;  top:5px; left:10%; text-align:center;border-radius: 8px;
    border-top-right-radius: 8px;
    border-top-left-radius: 8px;
    border-bottom-right-radius: 8px;
    border-bottom-left-radius: 8px;border:#00a2ff solid 1px;   "> 请勿相信视频内的文字广告！#卡顿请切换来源# </div>
<div id="dplayer"></div>
<div id="stats"></div>
<input type="hidden" id="url" value="<?php echo $_GET["url"];?>">
<script src="hls.min.js"></script>
<script src="DPlayer.min.js"></script>
<script>
    url=$("#url").val();
    temp=url.split("://");
    url=temp[1];   
    ishttps = 'https:' == document.location.protocol ? true: false;	
   	 if(ishttps){
   		url="https://"+url;
   	 }
   	 else{
   		 url="http://"+url;
   	 }
    var webdata = {
        set:function(key,val){
            window.sessionStorage.setItem(key,val);
        },
        get:function(key){
            return window.sessionStorage.getItem(key);
        },
        del:function(key){
            window.sessionStorage.removeItem(key);
        },
        clear:function(key){
            window.sessionStorage.clear();
        }
    };
	var dp = new DPlayer({
        container: document.getElementById('dplayer'),
        autoplay: true,
		hotkey: true,  // 移动端全屏时向右划动快进，向左划动快退。
		theme: '#FADFA3',
		lang: 'zh-cn',
		screenshot: true,
		preload: 'auto',
		volume: 0.7,
		mutex: true,
        video: {
            url: url,
			pic:'/jiuqingplayer/dp/loading.gif',
        },
		subtitle: {
		        url: 'dplayer.vtt',
		        type: 'webvtt',
		        fontSize: '25px',
		        bottom: '10%',
		        color: '#e64d66',
		}
    });
	dp.seek(webdata.get('vod'+url));
    setInterval(function(){
        webdata.set('vod'+url,dp.video.currentTime);
    },1000);
</script>