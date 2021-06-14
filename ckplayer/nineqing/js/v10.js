var comm = {
	'lister': {
		'each': function(urls) {
			var html = '<div class="layui-collapse">';
			$.each(dcys, function(list, name) {
				html += '<div class="layui-colla-item"><h2 class="layui-colla-title"><span style="float:left">' + name.head + '</span>&nbsp;&nbsp;<span style="font-size:6px;">' + name.tips + '</span></h2>';		
				if(list == 'advs'||list == 'zanzhu'){
					html += '<div class="layui-colla-content layui-show">';
				}else{
					html += '<div class="layui-colla-content">';
				}
				html += '<table class="layui-table"><tbody>';
				$.each(name.rows, function(nums, info) {
					var type = list == 'down' ? '下载' : '播放';
					var nums = (nums + 1) < 10 ? '0' + (nums + 1) : (nums + 1);
					var url1 = urls.replace('{flag}', info.flag).replace('{apis}', info.apis).replace('{ac}', 'list').replace('{h}', '');
					var url2 = urls.replace('{flag}', info.flag).replace('{apis}', info.apis).replace('{ac}', 'cj').replace('{h}', '24');
					var url3 = urls.replace('{flag}', info.flag).replace('{apis}', info.apis).replace('{ac}', 'cj').replace('{h}', '168');
					var url4 = urls.replace('{flag}', info.flag).replace('{apis}', info.apis).replace('{ac}', 'cj').replace('{h}', '');
					html += '<tr>';
					html += '<td width="20" align="center">' + nums + '</td>';
					html += '<td width="70" align="center">' + info.tips + '</td>';
					if(list == 'advs') {
						html += '<td ><a target="_blank" href="' + info.urls + '">' + info.name + '【' + info.rema + '】</a></td>';
						html += '<td width="18%" align="center"><a target="_blank" href="' + info.url1 + '">' + info.tip1 + '</a></td></td>';
						html += '<td width="18%" align="center"><a target="_blank" href="' + info.url2 + '">' + info.tip2 + '</a></td>';
						html += '<td width="18%" align="center"><a target="_blank" href="' + info.url3 + '">' + info.tip3 + '</a></td>';
						html += '<td width="18%" align="center"><a target="_blank" href="' + info.url4 + '">' + info.tip4 + '</a></td>';
					} else if(list == 'news' || list == 'star') {
						if(list=='news'){mid = 2}else{mid=8}
						html += '<td><a href="javascript:;" class="dataurl" data-urls="' + url1 + '&mid=' + (list == 'news' ? 2 : 8) + '" data-head="' + info.name + '">' + info.name + '【' + info.rema + '】</a></td>';
						if(list=='star'){
						html += '<td width="60" align="center"><a href="javascript:;" class="star" style="color:red">修复采集</a></td>';	
						}
						html += '<td width="60" align="center"><a href="javascript:;" class="timming" data-name="当日采集：' + info.name + '【' + name.head + '】' + '" data-flag="' + info.flag + list + nums + '" data-param="' + url2.replace($('.j-ajax', parent.document).attr('href').replace('/index/clear.html', '') + '/collect/api?', '') + '&mid=' + mid + '">定时配置</a></td>';
						html += '<td width="60" align="center"><a href="javascript:;" class="dataurl" data-urls="' + url2 + '&mid=' + mid + '" data-head="' + info.name + '【' + info.rema + '】">采集当天</a></td>';
						html += '<td width="60" align="center"><a href="javascript:;" class="dataurl" data-urls="' + url3 + '&mid=' + mid + '" data-head="' + info.name + '【' + info.rema + '】">采集本周</a></td>';
						html += '<td width="60" align="center"><a href="javascript:;" class="dataurl" data-urls="' + url4 + '&mid=' + mid + '" data-head="' + info.name + '【' + info.rema + '】">采集全部</a></td>';
					} else {
						html += '<td><a href="javascript:;" class="dataurl" data-urls="' + url1 + (list == 'down' ? '&param=JmN0PTE' : '') + '" data-head="' + info.name + '【' + info.rema + '】">' + info.name + '【' + info.rema + '】</a></td>';
						html += '<td width="60" align="center"><a href="javascript:;" class="players" data-name="' + info.name + '" data-type="' + list + '" data-flag="' + info.coll + '" data-desc="' + info.rema + '" data-tips="' + info.tips.match(/[\u4e00-\u9fa5]{2,}/g) + '">' + type + '配置</a></td>';
						html += '<td width="60" align="center"><a href="javascript:;" class="timming" data-name="当日采集：' + info.name + '【' + name.head + '】' + '" data-flag="' + info.flag + list + nums + '" data-param="' + url2.replace($('.j-ajax', parent.document).attr('href').replace('/index/clear.html', '') + '/collect/api?', '') + (list == 'down' ? '&param=JmN0PTE' : '') +'">定时配置</a></td>';
						html += '<td width="60" align="center"><a href="javascript:;" class="dataurl" data-urls="' + url2 + (list == 'down' ? '&param=JmN0PTE' : '') +'" data-head="' + info.name + '【' + info.rema + '】">采集当天</a></td>';
						html += '<td width="60" align="center"><a href="javascript:;" class="dataurl" data-urls="' + url3 + (list == 'down' ? '&param=JmN0PTE' : '') +'" data-head="' + info.name + '【' + info.rema + '】">采集本周</a></td>';
						html += '<td width="60" align="center"><a href="javascript:;" class="dataurl" data-urls="' + url4 + (list == 'down' ? '&param=JmN0PTE' : '') +'" data-head="' + info.name + '【' + info.rema + '】">采集全部</a></td>';	
					}
					html += '</tr>';
				});
				html += '</tbody></table></div>';
			});
            html += '</div>';
			$('.layui-collect').html(html);
		  if(typeof(is_vip) !== 'undefined' && is_vip && dcy.zidingyi.rows!=''){
			var html2 = '<div class="layui-collapse">';
			$.each(dcy, function(list, name) {
				html2 += '<div class="layui-colla-item"><h2 class="layui-colla-title"><span style="float:left">' + name.head + '</span>&nbsp;&nbsp;<span style="font-size:6px;">' + name.tips + '</span></h2>';		
				html2 += '<div class="layui-colla-content">';
				html2 += '<table class="layui-table"><tbody>';
				$.each(name.rows, function(nums, info) {
					var type = list == 'down' ? '下载' : '播放';
					var nums = (nums + 1) < 10 ? '0' + (nums + 1) : (nums + 1);
					var url1 = urls.replace('{flag}', info.flag).replace('{apis}', info.apis).replace('{ac}', 'list').replace('{h}', '');
					var url2 = urls.replace('{flag}', info.flag).replace('{apis}', info.apis).replace('{ac}', 'cj').replace('{h}', '24');
					var url3 = urls.replace('{flag}', info.flag).replace('{apis}', info.apis).replace('{ac}', 'cj').replace('{h}', '168');
					var url4 = urls.replace('{flag}', info.flag).replace('{apis}', info.apis).replace('{ac}', 'cj').replace('{h}', '');
					html2 += '<tr>';
					html2 += '<td width="20" align="center">' + nums + '</td>';
					html2 += '<td width="70" align="center">' + info.tips + '</td>';
					html2 += '<td><a href="javascript:;" class="dataurl" data-urls="' + url1 + '" data-head="' + info.name + '【' + info.rema + '】">' + info.name + '</a></td>';
					if(url1.indexOf("mid")==-1){
						html2 += '<td width="60" align="center"><a href="javascript:;" class="players" data-type="cj_player">' + type + '配置</a></td>';
					}else{
						html2 += '<td width="60" align="center"></td>';
					}
					html2 += '<td width="60" align="center"><a href="javascript:;" class="timming" data-name="当日采集：' + info.name + '【' + name.head + '】' + '" data-flag="' + info.flag + list + nums + '" data-param="' + url2.replace($('.j-ajax', parent.document).attr('href').replace('/index/clear.html', '') + '/collect/api?', '') + '">定时配置</a></td>';					
					html2 += '<td width="60" align="center"><a href="javascript:;" class="dataurl" data-urls="' + url2 + '" data-head="' + info.name + '【' + info.rema + '】">采集当天</a></td>';
					html2 += '<td width="60" align="center"><a href="javascript:;" class="dataurl" data-urls="' + url3 + '" data-head="' + info.name + '【' + info.rema + '】">采集本周</a></td>';
					html2 += '<td width="60" align="center"><a href="javascript:;" class="dataurl" data-urls="' + url4 + '" data-head="' + info.name + '【' + info.rema + '】">采集全部</a></td>';
					html2 += '</tr>';
				});
				html2 += '</tbody></table></div>';
			});
			html2 += '</div>';
			$('.cj-collect').html(html2);
		  }
		}
	},
	'timing': {
		'init': function() {
			$(document).on('click', '.timming', function() {
				if(typeof(is_vip) !== 'undefined' && is_vip){
				var that = $(this);
				layer.confirm('确认添加到定时任务吗？<br/>请确保当前资源站的分类已绑定！', {
					title: '添加定时任务',
					icon:3
				}, function() {
					$.post(parent.ROOT_PATH+'/addons/mycj/create.php?id=tim&name=' + my.name, 'name=' + that.attr('data-name') + '&flag=' + that.attr('data-flag') + '&param=' + encodeURIComponent(that.attr('data-param')), function(data) {
						if(data.code == 200){
						    layer.alert(data.msg + '！如未生效请手动清理缓存<br/>请在 “系统” -> “定时任务” 中查看<br/>定时任务需要用宝塔监控才可生效！',{icon:1});
						}else{
							layer.alert(data.msg,{icon:2});
						}
					}).error(function(data) {
						if(data.status == 404) {
							tips();
						} else layer.alert('请求失败！文件读取失败！',{icon:2});
					}, 'json');
				});
				}else{
					tips();
				}
			});
		}
	},
    'player': {
        'init': function() {
            $(document).on('click', '.players', function() {
                var that = $(this);
                var type = that.attr('data-type') == 'down' ? '下载' : '播放';
                var desc = that.attr('data-type') == 'down' ? '' + that.attr('data-desc') + '' : '支持手机电脑在线播放';
				var jxapi = '//cdn.zyc888.top/?url=';	              			
				if(that.attr('data-type')=='down'){
                    layer.confirm('确认添加到' + type + '器中吗？', {
                        title: '添加' + type + '器'
                    }, function() {
                        $.post(parent.ROOT_PATH+'/addons/mycj/save.php?id=vod&name=' + my.name, 'name=' + that.attr('data-name') + '&type=' + that.attr('data-type') + '&flag=' + encodeURIComponent(that.attr('data-flag')) + '&tips=无需安装任何插件&apis='+jxapi+'&desc=' + desc, function(data) {
                            if (data.code == 200) {
                                layer.alert(data.msg + '！如未生效请手动清理缓存', {icon:1}, function() { layer.closeAll(); });
                            } else {
                                layer.alert(data.msg, {icon: 2}, function() { layer.closeAll(); });
                            }
                        }).error(function(data) {
                            layer.alert('请求失败！', { icon: 2}, function() { layer.closeAll(); });
                        }, 'json');
                    });			
				}else{
					layer.open({
					    title: that.attr('data-name'),
					    content: parent.ROOT_PATH+'/addons/mycj/player.php?name=' + that.attr('data-name') + '&type=' + that.attr('data-type') + '&flag=' + encodeURIComponent(that.attr('data-flag')) + '&tips=无需安装任何插件&apis='+jxapi+'&desc=' + desc,
						area: ['60%', '70%'],
					    type: 2
				    });
			  }				
           });
      }
    },
	'search': {
		'init': function(urls) {
			$(document).on('click', '.searchs', function() {				
				if(typeof(is_vip) == 'undefined' || !is_vip){ tips(); return false;}
				if($('.layui-input-search').val() == '') return false;
				$('.cj-collect').hide();			
				$('.layui-collect').html('<table class="layui-table"><thead><tr><td width="30" align="center">编号</td><td width="90" align="center">资源站</td><td>名称</td><td width="60" align="center">操作</td><td width="60" align="center">分类</td><td width="60" align="center">来源</td><td width="60" align="center">更新时间</td></tr></thead><tbody></tbody><tfoot><tr><td colspan="7" align="center">搜索中，请稍等...</td></tr></tfoot></table>');
				if($('select[name="collect"] option:selected').val()=='zidingyi'){
				    var collec = dcy[$('select[name="collect"] option:selected').val()].rows;
				    comm.search.post(urls, collec, 0);					
				}else{
				    var collec = dcys[$('select[name="collect"] option:selected').val()].rows;
				    comm.search.post(urls, collec, 0);	
				}
			});
		},
		'post': function(urls, collec, hander) {
			$.ajaxSettings.timeout = 10000;
			var xhr = $.post(parent.ROOT_PATH+'/addons/mycj/create.php?id=sea&name=' + my.name, 'name=' + encodeURIComponent($('.layui-input-search').val()) + '&apis=' + encodeURIComponent(collec[hander].apis), function(data, status) {
				$('.layui-collect tfoot tr td').html('【' + collec[hander].name + '】搜索到' + data.length + '条相关资源&nbsp;&nbsp;&nbsp;<span>' + $('.interval').val() + '秒后搜索下一条,请稍等...</span>');
				if(data.length > 0) {
					var html = '';
					var url1 = urls.replace('{flag}', collec[hander].flag).replace('{apis}', collec[hander].apis).replace('{ac}', 'list').replace('{h}', '');
					for(var i = 0; i < data.length; i++) {
						html += '<tr>';
						html += '<td width="30" align="center">' + (hander + 1) + '</td>';
						html += '<td width="90" align="center"><span class="layui-badge layui-bg-green">' + collec[hander].name + '</span></td>';
						html += '<td><a href="javascript:;" class="dataurl" data-urls="' + url1 + '&wd=' + $('.layui-input-search').val() + '" data-head="' + collec[hander].name + '【' + collec[hander].rema + '】">' + data[i].name + '【' + data[i].note + '】</a></td>';
						html += '<td width="60" align="center"><a href="javascript:;" class="players" data-name="' + collec[hander].name + '" data-type="' + $('select[name="collect"] option:selected').val() + '" data-flag="' + collec[hander].coll + '" data-desc="' + collec[hander].rema + '" data-tips="' + collec[hander].tips.match(/[\u4e00-\u9fa5]{2,}/g) + '">播放配置</a></td>';
						html += '<td width="60" align="center"><a href="javascript:;">' + data[i].type + '</a></td>';
						html += '<td width="60" align="center"><a href="javascript:;">' + data[i].dt + '</a></td>';
						html += '<td width="130" align="center"><a href="javascript:;">' + data[i].last + '</a></td>';
						html += '</tr>';
					}
					$('.layui-collect tbody').append(html);
				}
			}).complete(function(data, status) {
				if(data.status == 404) {
					tips();
					return false;
				}
				if(status == 'timeout') {
					$('.layui-collect tfoot tr td').html('【' + collec[hander].name + '】请求超时&nbsp;&nbsp;&nbsp;<span>' + $('.interval').val() + '秒后搜索下一条,请稍等...</span>');
					xhr.abort();
				}
				if(collec.length == hander + 1) {
					$('.layui-collect tfoot tr td').html('搜索完毕');
					clearInterval(meters);
					return false;
				}
				var timers = $('.interval').val() - 1;
				var meters = setInterval(function() {
					if(timers == 0) {
						$('.layui-collect tfoot tr td span').html('正在搜索【' + collec[hander + 1].name + '】请稍等...');
					} else $('.layui-collect tfoot tr td span').html(timers-- + '秒后搜索下一条,请稍等...');
				}, 1000);
				var setout = setTimeout(function() {
					clearInterval(meters);
					comm.search.post(urls, collec, hander + 1);
				}, 1000 * (Number($('.interval').val()) + 1));
			}, 'json');
		},
		'data': function() {
			$(document).on('click', '.add_cj', function() {
			  if(typeof(is_vip) !== 'undefined' && is_vip){	
				layer.full(layer.open({
					title: '添加自定义资源站',
					content: $('.j-ajax', parent.document).attr('href').replace('/index/clear.html', '') + '/collect/index.html',
					type: 2
				}));
			  }else{
				tips();  
			  }				
			});
			$(document).on('click', '.dataurl', function() {
				layer.full(layer.open({
					title: $(this).attr('data-head'),
					content: $(this).attr('data-urls'),
					type: 2
				}));
			});			
			$(document).on('click', '.alljx', function() {
			  if(typeof(is_vip) !== 'undefined' && is_vip){				
				layer.full(layer.open({
					title: '批量修改解析接口',
					content: $('.j-ajax', parent.document).attr('href').replace('/index/clear.html', '') + '/vodplayer/index.html',
					type: 2
				}));
			  }else{
				tips();  
			  }
			});	
			$(document).on('click', '.duandian', function() {
			  if(typeof(is_vip) !== 'undefined' && is_vip){				
				layer.full(layer.open({
					title: '视频断点采集',
					content: parent.ADMIN_PATH+'/admin/collect/load.html?flag=vod',
					type: 2
				}));
			  }else{
				tips();  
			  }
			});	
            $(document).on('click', '.star', function() {
				if(my.mac_ver < '2019.03.06.1617'){
					layer.confirm('检测到你的苹果cms版本为：<font color="red">'+my.mac_ver+'</font>，最新版为：<font color="red">2019.03.06.1617</font><br/><br/>版本不符合修复要求，请先升级程序版本！<br/>',{title:'提示信息',btn:['我要升级','取消']},function() {
						top.location.href = 'http://www.vrecf.com/maccms/down.html';
					});
				}else{
					layer.confirm('如果你采集明星数据的时候，只能采集第一页，不能自动跳转采集第二页，那么可以尝试点这里修复。<br/><br/>【注意事项】<br/>修复会修改系统文件，请自行备份根目录下的 application文件夹中的所有文件，防止修复后，出现程序功能性故障，可以恢复备份文件。<br/><br/>',{title:'提示信息',btn:['我要修复','取消']},function() {
                        $.post(parent.ROOT_PATH+'/addons/mycj/save.php?id=star&name=' + my.name, function(data) {
                            if (data.code == 200) {
                                layer.alert(data.msg, {icon:1}, function() { layer.closeAll(); });
                            } else {
                                layer.alert(data.msg, function() { layer.closeAll(); });
                            }
                        }).error(function(data) {
                            layer.alert('请求失败！', { icon: 2}, function() { layer.closeAll(); });
                        }, 'json');						
					});
				}
			});				
            $(document).on('click', '.update', function() {
				comm.update.init();
			});			
            $(document).on('click', '.explain', function() {
				layer.open({
					type: 1,title: '采集说明',closeBtn: false,area: '500px;',shade: 0.8,id: 'explain',btn: ['我已阅读并知晓'],btnAlign: 'c',moveType: 1,
					content: '<div style="padding: 50px; line-height: 22px; background-color: #393D49; color: #fff; font-weight: 300;">采集资源前，请先认真阅读本提示<br>1、本插件仅提供资源站整合，不对资源有效性负责<br>2、本插件有提供默认解析接口，手机播放有广告<br>3、如果你想要去除手机端播放的广告，建议搭建自己的播放器，不要调用解析接口，<a href="http://www.vrecf.com/a/52.html" target="_blank" class="layui-btn layui-btn-xs">点此了解无广告解析播放器>></a><br>4、调用解析接口，意味着可被别人控制，别人可在播放器内加广告，或者劫持你的网站流量跳转<br>5、采集腾讯优酷爱奇艺等无法播放，那就不要采集，你没有稳定能直接解析腾讯优酷的接口，就不要采集官方直链<br></div>'
				});
			});			
			
		}
	},
	'cookie': {
		'set': function(name, value, days) {
			var exp = new Date();
			exp.setTime(exp.getTime() + days * 24 * 60 * 60 * 1000);
			var arr = document.cookie.match(new RegExp('(^| )' + name + '=([^;]*)(;|$)'));
			document.cookie = name + '=' + escape(value) + ';path=/;expires=' + exp.toUTCString();
		},
		'get': function(name) {
			var arr = document.cookie.match(new RegExp('(^| )' + name + '=([^;]*)(;|$)'));
			if(arr != null) return unescape(arr[2]);
		},
		'del': function(name) {
			var exp = new Date();
			exp.setTime(exp.getTime() - 1);
			var cval = this.get(name);
			if(cval != null) document.cookie = name + '=' + escape(cval) + ';path=/;expires=' + exp.toUTCString();
		}
	},
	'update': {
		'vers': '2.8',
		'init': function() {
			if(verv10 == this.vers){
				layer.alert('当前已经是最新版了，无需更新！');				
			}else{
				var output = '<ul>';
					output += '<li class="layui-text">2019-08-18 更新日志</li>';
				    output += '<li class="layui-text">1、VIP版新增自定义添加资源站</li>';
					output += '<li class="layui-text">2、免费版增加一键在线升级</li>';
				    output += '<li class="layui-text">3、其他细节调整</li>';
				    output += '</ul>';					
				if(typeof(is_vip) !== 'undefined' && is_vip){
					var downurl = 'http://caiji-api.oss-cn-shanghai.aliyuncs.com/v10.2.8/vipv10.2.8.zip';
				}else{
					var downurl = 'http://caiji-api.oss-cn-shanghai.aliyuncs.com/v10.2.8/freev10.2.8.zip';
				}		
				layer.confirm(output, {
						area: '300px',
						title: '最新版本：'+this.vers,
						btn: ['立即升级','取消']
					}, function() {
						var index = layer.msg('正在更新，请稍等片刻...',{icon: 16,time:false});
						$.ajax({
							url: 'update.php?name='+my.name, 
							type: 'POST',
							data: {downurl:downurl},
							dataType: 'json',
							success: function(res){
								if (res.code=='200') {
									layer.alert(res.msg, {title:'更新成功',icon: 6,closeBtn: 0},function(index) {
										location.reload();
									});
								}else{
								    layer.alert(res.msg, {title:'更新失败',icon: 5,closeBtn: 0},function(index) {
					                    top.location.href = 'https://mv.nineqing.com/';
				                    });
								}
							},
							error: function(res){
								layer.alert(res.msg, {title:'更新失败',icon: 5,closeBtn: 0},function(index) {
					                top.location.href = 'https://mv.nineqing.com/';
				                });
							}
					});						
				});	
			}	
		}
	}	
}

function tips(){
	layer.confirm('免费版不支持此功能，如有需要请升级为VIP版', { title: '提示'}, function() {
		top.location.href = 'https://mv.nineqing.com/';   
	});	
}

function ggfree() {
	layer.open({
		type: 1,
		title: '邀请升级VIP',
		closeBtn: false,
		area: '400px;',
		shade: 0.8,
		id: 'upvip',
		btn: ['我要升级', ['残忍拒绝']],
		btnAlign: 'c',
		moveType: 1,
		content: '<div style="padding: 50px; line-height: 22px; background-color: #393D49; color: #fff; font-weight: 300;">您当前使用的是：免费版<br><br>VIP版支持更多功能：<br>1、支持断点采集<br>2、支持添加播放器自定义解析接口<br>3、支持批量修改播放器接口<br>4、支持全网搜索资源<br>5、支持一键配置定时任务<br/>6、支持自定义添加资源站<br/>您不考虑升级VIP版吗？</div>',
		yes: function(index, layero) {
			var btn = layero.find('.layui-layer-btn');
			btn.find('.layui-layer-btn0').attr({
				href: 'https://mv.nineqing.com/',
				target: '_blank'
			});
			layer.close(index);
		},
		end: function() {
			layer.close(index);
		}
	});
}


function cj_tj() {
	$.ajax({
		url: 'https://api.k8dy.xyz/caiji/tj.php',
		type: 'POST',
		async: true,
		data: {domain: window.location.host, vip:is_vip?'1':'0', cms:my.mac_version},
		dataType: 'json',
	});
}	

layui.use(['form','element', 'jquery', 'layer'], function() {
	var urls = $('.j-ajax', parent.document).attr('href').replace('/index/clear.html', '') + '/collect/api?ac={ac}&h={h}&cjflag={flag}&cjurl={apis}';
	var layer = layui.layer;
	var jquery = layui.jquery;
	var element = layui.element;
	var form = layui.form;	
	comm.lister.each(urls);
	comm.search.init(urls); 
	comm.search.data();
	comm.player.init();
	comm.timing.init();
	element.render('collapse'); 
	cj_tj();
	document.getElementById("version").innerHTML = '<font color="#ff0000">' + comm.update.vers + '</font>&nbsp;&nbsp;<a class="update" href="javascript:;"><font color="blue">更新插件</font></a>&nbsp;&nbsp;<!--当前苹果cms系统版本：<font color="red">'+my.mac_ver+'</font>&nbsp;&nbsp;最新版本：<font color="red">2019.03.06.1617</font>&nbsp;&nbsp;<a href="https://mv.nineqing.com/" target="_blank"><font color="blue">更新程序</font></a><span style="display:none"></span>-->';
	if ((navigator.userAgent.indexOf('MSIE') >= 0)
			|| (navigator.userAgent.indexOf('Trident') >= 0)) {
		alert("请勿使用IE浏览器和兼容模式，会造成某些功能异常！");
     }		
    if(typeof(verv10) == 'undefined' || verv10 != comm.update.vers){
		if(comm.cookie.get('ver'+comm.update.vers)!=1){
			comm.update.init();
			comm.cookie.set('ver'+comm.update.vers, 1, 1);
		}
	}else if(typeof(is_vip) == 'undefined' || !is_vip){ 
		if(comm.cookie.get('free')!=1){
            ggfree();
           	comm.cookie.set('free',1,1);		
	    }	
	}else{
		if(comm.cookie.get('gg')!=1){
            layer.alert('2.8版本新增添加自定义资源站<br><a href="#" class="layui-btn layui-btn-xs" target="_blank">使用方法请点此查看教程</a><br><br>如果使用过程中有什么BUG，欢迎反馈！');
           	comm.cookie.set('gg',1,1);		
	    }		
	}
});