<html>
<head>
<script charset="utf-8" src="jquery-1.7.2.min.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
<meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- IE内核 强制使用最新的引擎渲染网页 -->
<meta name="renderer" content="webkit">  <!-- 启用360浏览器的极速模式(webkit) -->
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0 ,maximum-scale=1.0, user-scalable=no"><!-- 手机H5兼容模式 -->
<title>ckplayer</title>
<style type="text/css">body,html,.a1{background-color:#000;padding: 0;margin: 0;width:100%;height:100%;}</style>
<script type="text/javascript" src="ckplayer.js"></script>
</head>
<body ondragstart="window.event.returnValue=false" oncontextmenu="window.event.returnValue=false" onselectstart="event.returnValue=false" style="overflow-y:hidden;">
<input type="hidden" id="url" value="<?php echo $_GET['url'];?>">
<div id="video" style="width:100%;height:100%;"></div>
<script type="text/javascript">
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
	var videoObject = {
		container: '#video', //容器的ID或className
		variable: 'player', //播放函数名称
		autoplay: true,//是否自动播放
		html5m3u8:true,
		video:url
		};
	var player = new ckplayer(videoObject);
</script>
</body>
</html>
